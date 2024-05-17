<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Charts\IXChart;
use App\Charts\SXChart;
use App\Models\Absen;
use App\Models\AbsenReg;
use App\Models\EmpOut;
use App\Models\Leave;
use App\Models\TestingAbsen;
use App\Models\User;
use App\Models\WorkHistory;
use App\Models\ShiftArchive;
use Carbon\Carbon;
use DataTables;
use DB;
use File;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use App\Charts\SakitChart;

class AdminController extends Controller
{
    public function index()
    {
        $todayL = Carbon::now();

        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $nowDay = Carbon::parse($now)->format('d');
        $nowMonth = Carbon::parse($now)->format('m');
        $nowYear = Carbon::parse($now)->format('Y');
        $startDay = $now->startOfMonth()->format('Y-m-d');
        $endDay = $now->endOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $dept = \Auth::user()->dept;

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

        foreach ($inputAbsen as $item) {
            if ($item->dept == 'I/A') {
                $absenA[] = $item;
            }
        }

        $staff = User::where('status', 'Staff')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $manager = User::where('status', 'Manager')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $regular = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $reg_L_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_H_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_TA_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_MX_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_D_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_E_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_I_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_S_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_C_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_IX_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_SX_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today, $nowYear) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
            $query->whereYear('date', $nowYear);
        })->count();

        $reg_L = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_D = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_A = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_A_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_A_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_A_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_A_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_A_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_MX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_H = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_E = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_TA = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_MX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_I = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_S = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_C = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_IX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_SX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();
        // $t_attend = Absen::where('date',$today)->with(['user' => function($q) {
        //   $q->where('status', 'Regular');
        // }])->count();

        $budget_monthly = User::where('status', 'Monthly')->count();
        $budget_staff = User::where('status', 'Staff')->count();
        $budget_manager = User::where('status', 'Manager')->count();
        $budget_regular = User::where('status', 'Regular')->count();
        $budget_dept = User::where('status', 'Regular')->where('dept', $dept)->count();

        // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_manager = ($manager / $budget_manager) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_manager + $budget_regular;
        $act_total = $monthly + $staff + $manager + $regular;
        $per_total = ($act_total / $budget_total) * 100;

        // tanggal
        $date = Carbon::parse(Carbon::now())->subDay(1)->translatedformat('l M, Y');

        // latest
        $latest1 = AbsenReg::latest()->first();
        $latest = ($latest1 == null) ? 0 : Carbon::parse($latest1->created_at)->format('d M Y H:s');
        // $latest = Carbon::parse($latest1->created_at)->format('d M Y H:s');

        // total karyawan
        $t_kary = User::count();

        // total dept kehadiran
        $t_dept = ($reg_H_dept == 0) ? 0 : ($reg_H_dept / $budget_dept) * 100;

        // todate
        $month = Carbon::parse(Carbon::now())->format('m');
        $day1 = range(1, Carbon::now()->month($month)->daysInMonth);
        $day = (implode(",", $day1));
        // $day = json_encode($day1);

        foreach ($day1 as $key => $value) {
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'SX');
            })->count();

        }

        $reg_h_day = (implode(",", $reg_h_day_array));
        $reg_a_day = (implode(",", $reg_a_day_array));
        $reg_mx_day = (implode(",", $reg_mx_day_array));
        $reg_l_day = (implode(",", $reg_l_day_array));
        $reg_d_day = (implode(",", $reg_d_day_array));
        $reg_e_day = (implode(",", $reg_e_day_array));
        $reg_i_day = (implode(",", $reg_i_day_array));
        $reg_s_day = (implode(",", $reg_s_day_array));
        $reg_c_day = (implode(",", $reg_c_day_array));
        $reg_ix_day = (implode(",", $reg_ix_day_array));
        $reg_sx_day = (implode(",", $reg_sx_day_array));
        // dd($reg_a_day);
        // $reg_h_day = (json_encode($reg_h_day_array));

        // todate regular
        $reg_months = $todayL->startOfMonth();
        $reg_month = Carbon::parse($reg_months)->format('Y-m-d');

        $to_reg_h = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'H')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', \Auth::user()->dept)->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', \Auth::user()->dept);
            })->get();

        return view('admin.pages.dashboard', [
            'monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_manager' => $budget_manager,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_manager' => $per_manager,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_h_b' => $reg_H_B,
            'reg_h_c' => $reg_H_C,
            'reg_h_d' => $reg_H_D,
            'reg_h_e' => $reg_H_E,
            'reg_h_f' => $reg_H_F,
            'reg_l' => $reg_L,
            'reg_l_b' => $reg_L_B,
            'reg_l_c' => $reg_L_C,
            'reg_l_d' => $reg_L_D,
            'reg_l_e' => $reg_L_E,
            'reg_l_f' => $reg_L_F,
            'reg_d' => $reg_D,
            'reg_d_b' => $reg_D_B,
            'reg_d_c' => $reg_D_C,
            'reg_d_d' => $reg_D_D,
            'reg_d_e' => $reg_D_E,
            'reg_d_f' => $reg_D_F,
            'reg_a' => $reg_A,
            'reg_a_b' => $reg_A_B,
            'reg_a_c' => $reg_A_C,
            'reg_a_d' => $reg_A_D,
            'reg_a_e' => $reg_A_E,
            'reg_a_f' => $reg_A_F,
            'reg_mx' => $reg_MX,
            'reg_mx_b' => $reg_MX_B,
            'reg_mx_c' => $reg_MX_C,
            'reg_mx_d' => $reg_MX_D,
            'reg_mx_e' => $reg_MX_E,
            'reg_mx_f' => $reg_MX_F,
            'reg_e' => $reg_E,
            'reg_e_b' => $reg_E_B,
            'reg_e_c' => $reg_E_C,
            'reg_e_d' => $reg_E_D,
            'reg_e_e' => $reg_E_E,
            'reg_e_f' => $reg_E_F,
            'reg_ta' => $reg_TA,
            'reg_ta_b' => $reg_TA_B,
            'reg_ta_c' => $reg_TA_C,
            'reg_ta_d' => $reg_TA_D,
            'reg_ta_e' => $reg_TA_E,
            'reg_ta_f' => $reg_TA_F,
            'reg_mx' => $reg_MX,
            'reg_mx_b' => $reg_MX_B,
            'reg_mx_c' => $reg_MX_C,
            'reg_mx_d' => $reg_MX_D,
            'reg_mx_e' => $reg_MX_E,
            'reg_mx_f' => $reg_MX_F,
            'reg_i' => $reg_I,
            'reg_i_b' => $reg_I_B,
            'reg_i_c' => $reg_I_C,
            'reg_i_d' => $reg_I_D,
            'reg_i_e' => $reg_I_E,
            'reg_i_f' => $reg_I_F,
            'reg_s' => $reg_S,
            'reg_s_b' => $reg_S_B,
            'reg_s_c' => $reg_S_C,
            'reg_s_d' => $reg_S_D,
            'reg_s_e' => $reg_S_E,
            'reg_s_f' => $reg_S_F,
            'reg_c' => $reg_C,
            'reg_c_b' => $reg_C_B,
            'reg_c_c' => $reg_C_C,
            'reg_c_d' => $reg_C_D,
            'reg_c_e' => $reg_C_E,
            'reg_c_f' => $reg_C_F,
            'reg_ix' => $reg_IX,
            'reg_ix_b' => $reg_IX_B,
            'reg_ix_c' => $reg_IX_C,
            'reg_ix_d' => $reg_IX_D,
            'reg_ix_e' => $reg_IX_E,
            'reg_ix_f' => $reg_IX_F,
            'reg_sx' => $reg_SX,
            'reg_sx_b' => $reg_SX_B,
            'reg_sx_c' => $reg_SX_C,
            'reg_sx_d' => $reg_SX_D,
            'reg_sx_e' => $reg_SX_E,
            'reg_sx_f' => $reg_SX_F,
            'reg_h_dept' => $reg_H_dept,
            'reg_ta_dept' => $reg_TA_dept,
            'reg_mx_dept' => $reg_MX_dept,
            'reg_l_dept' => $reg_L_dept,
            'reg_d_dept' => $reg_D_dept,
            'reg_e_dept' => $reg_E_dept,
            'reg_i_dept' => $reg_I_dept,
            'reg_s_dept' => $reg_S_dept,
            'reg_c_dept' => $reg_C_dept,
            'reg_ix_dept' => $reg_IX_dept,
            'reg_sx_dept' => $reg_SX_dept,
            'dept' => $dept,
            't_dept' => $t_dept,
            'day' => $day,
            'reg_h_day' => $reg_h_day,
            'reg_a_day' => $reg_a_day,
            'reg_mx_day' => $reg_mx_day,
            'reg_l_day' => $reg_l_day,
            'reg_d_day' => $reg_d_day,
            'reg_e_day' => $reg_e_day,
            'reg_i_day' => $reg_i_day,
            'reg_s_day' => $reg_s_day,
            'reg_c_day' => $reg_c_day,
            'reg_ix_day' => $reg_ix_day,
            'reg_sx_day' => $reg_sx_day,
            'to_reg_h' => $to_reg_h,
            'to_reg_a' => $to_reg_a,
            'to_reg_mx' => $to_reg_mx,
            'to_reg_l' => $to_reg_l,
            'to_reg_d' => $to_reg_d,
            'to_reg_e' => $to_reg_e,
            'to_reg_i' => $to_reg_i,
            'to_reg_s' => $to_reg_s,
            'to_reg_c' => $to_reg_c,
            'to_reg_ix' => $to_reg_ix,
            'to_reg_sx' => $to_reg_sx,
            'tot_reg' => $tot_reg,
            'per_tot_reg_h' => $per_tot_reg_h,
            'per_tot_reg_a' => $per_tot_reg_a,
            'per_tot_reg_mx' => $per_tot_reg_mx,
            'budget_reg_dept' => $budget_reg_dept,
            'list_absen_reg' => $list_absen_reg,
            'kondisi' => $kondisi,
        ]);
    }

    public function attendance(SXChart $chart, IXChart $ixchart)
    {
        $data = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('users.nik', 'users.name', 'absen_regs.date', 'absen_regs.start_work', 'absen_regs.end_work', 'absen_regs.desc', 'absen_regs.info as infos')
            ->whereNotNull('absen_regs.info')
            ->get();

        return view('admin.pages.attendance', ['data' => $data, 'chart' => $chart->build(), 'ixchart' => $ixchart->build()]);
    }

    public function attendance_input(Request $request)
    {

        $data = DB::table('test_absen_regs')
            ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
            ->select('users.*', 'test_absen_regs.*')
            ->where('test_absen_regs.date', Carbon::now()->format('Y-m-d'))
            ->get();
        return view('admin.pages.attendance-input', ['data' => $data]);
    }

    public function attendance_edit()
    {
        $users = DB::table('users')->get();

        return view('admin.pages.attendance-input-ubah', ['users' => $users]);
    }

    public function attendance_edit_new(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $nik = $request->nik;

        $SXLists = DB::table('sxlists')->get();
        $IXLists = DB::table('ixlists')->get();

        $data = DB::table('test_absen_regs')
            ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
            ->select('users.nik', 'users.name', 'test_absen_regs.*')
            ->whereBetween('test_absen_regs.date', [$date1, $date2])
            ->where('test_absen_regs.user_id', $nik)
            ->get();

        return view('admin.pages.attendance-input-ubah-baru', ['data' => $data, 'sxlists' => $SXLists, 'ixlists' => $IXLists]);
    }

    public function update_attendance_edit(Request $request)
    {
        // $start_work = $request->start_work;
        foreach ($request->input('user_id') as $key => $value) {
            // cek jumlah cuti
            $cek_cuti = Leave::where('user_id', $request->user_id[$key])
                ->whereYear('date', Carbon::now()->format('Y'))
                ->count();

            $cekShift = ShiftArchive::where('nik', $request->user_id[$key])
                ->select('shift')
                ->first();

            $ids = $request->ids[$key];
            $date = $request->date_select[$key];

            $start_work = $request->start_work[$key];
            $end_work = $request->end_work[$key];

            if ($start_work == null && $end_work == null) {
                $sw = null;
                $ew = null;
            } elseif ($end_work == null) {
                $sw = Carbon::parse($start_work)->format('H:i:s');
                $ew = null;
            } else {
                $sw = Carbon::parse($start_work)->format('H:i:s');
                $ew = Carbon::parse($end_work)->format('H:i:s');
            }

            if ($sw == null && $ew == null) {
                $swW = null;
                $ewW = null;
            } elseif ($ew == null) {
                $swW = '' . $date . ' ' . $sw . '';
                $ewW = null;
            } else {
                $swW = '' . $date . ' ' . $sw . '';
                $ewW = '' . $date . ' ' . $ew . '';
            }

            $info = $request->input('info');
            $infoString = implode(',', $info);

            if ($info == null) {
                $infoGet = null;
            } else {
                $infoGet = $infoString;
            }

            // $image = $this->saveImage($request->image, 'absens');

            if ($cek_cuti > 12 && $request->desc[$key] == 'I') {
                Alert::error('Gagal', 'Maaf izin tidak bisa karena jumlah cuti anda habis');
            } else {
                if ($request->hasfile('start_work_info_url') == true && $request->hasfile('end_work_info_url') == true) {
                    foreach ($request->file('start_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $data[] = $name;
                    }

                    foreach ($request->file('end_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $edata[] = $name;
                    }

                    TestingAbsen::where('id', $ids)->update([
                        'user_id' => $request->get('user_id')[$key],
                        'date' => $request->get('date_select')[$key],
                        'start_work' => $swW,
                        'start_work_info' => $request->get('start_work_info')[$key],
                        'start_work_info_url' => $data[$key],
                        'end_work' => $ewW,
                        'end_work_info' => $request->get('end_work_info')[$key],
                        'end_work_info_url' => $edata[$key],
                        'desc' => $request->get('desc')[$key],
                        'hadir' => 1,
                        'shift' => $cekShift,
                        'info' => $infoGet,
                    ]);

                    // $Record = new TestingAbsen;

                    // $Record->user_id = $request->get('user_id')[$key];
                    // $Record->date = $request->get('date_select')[$key];
                    // $Record->start_work = $swW;
                    // $Record->start_work_info = $request->get('start_work_info')[$key];
                    // $Record->start_work_info_url = $data[$key];
                    // $Record->end_work = $ewW;
                    // $Record->end_work_info = $request->get('end_work_info')[$key];
                    // $Record->end_work_info_url = $edata[$key];
                    // $Record->desc = $request->get('desc')[$key];
                    // $Record->hadir = 1;
                    // $Record->shift = 1;
                    // $Record->where('id', $id)->update();
                } else if ($request->hasfile('start_work_info_url') == true && $request->hasfile('end_work_info_url') == false) {
                    foreach ($request->file('start_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $data[] = $name;
                    }

                    TestingAbsen::where('id', $request->ids[$key])->update([
                        'user_id' => $request->get('user_id')[$key],
                        'date' => $request->get('date_select')[$key],
                        'start_work' => $swW,
                        'start_work_info' => $request->get('start_work_info')[$key],
                        'start_work_info_url' => $data[$key],
                        'end_work' => $ewW,
                        'end_work_info' => $request->get('end_work_info')[$key],
                        'desc' => $request->get('desc')[$key],
                        'hadir' => 1,
                        'shift' => $cekShift,
                        'info' => $infoGet,
                    ]);

                    // $Record = new TestingAbsen;

                    // $Record->user_id = $request->get('user_id')[$key];
                    // $Record->date = $request->get('date_select')[$key];
                    // $Record->start_work = $swW;
                    // $Record->start_work_info = $request->get('start_work_info')[$key];
                    // $Record->start_work_info_url = $data[$key];
                    // $Record->end_work = $ewW;
                    // $Record->end_work_info = $request->get('end_work_info')[$key];
                    // $Record->desc = $request->get('desc')[$key];
                    // $Record->hadir = 1;
                    // $Record->shift = 1;
                    // $Record->where('id', $id)->update();
                } else if ($request->hasfile('start_work_info_url') == false && $request->hasfile('end_work_info_url') == true) {
                    foreach ($request->file('end_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $edata[] = $name;
                    }

                    $data = TestingAbsen::where('id', $ids)->update([
                        'user_id' => $request->get('user_id')[$key],
                        'date' => $request->get('date_select')[$key],
                        'start_work' => $swW,
                        'start_work_info' => $request->get('start_work_info')[$key],
                        'end_work' => $ewW,
                        'end_work_info' => $request->get('end_work_info')[$key],
                        'end_work_info_url' => $edata[$key],
                        'desc' => $request->get('desc')[$key],
                        'hadir' => 1,
                        'shift' => $cekShift,
                        'info' => $infoGet,
                    ]);

                    // $Record = new TestingAbsen;

                    // $Record->user_id = $request->get('user_id')[$key];
                    // $Record->date = $request->get('date_select')[$key];
                    // $Record->start_work = $swW;
                    // $Record->start_work_info = $request->get('start_work_info')[$key];
                    // $Record->end_work = $ewW;
                    // $Record->end_work_info = $request->get('end_work_info')[$key];
                    // $Record->end_work_info_url = $edata[$key];
                    // $Record->desc = $request->get('desc')[$key];
                    // $Record->hadir = 1;
                    // $Record->shift = 1;
                    // $Record->where('id', $id)->update();

                } else if ($request->hasfile('start_work_info_url') == false && $request->hasfile('end_work_info_url') == false) {

                    $data = TestingAbsen::where('id', $request->ids[$key])->update([
                        'user_id' => $request->get('user_id')[$key],
                        'date' => $request->get('date_select')[$key],
                        'start_work' => $swW,
                        'start_work_info' => $request->get('start_work_info')[$key],
                        'end_work' => $ewW,
                        'end_work_info' => $request->get('end_work_info')[$key],
                        'desc' => $request->get('desc')[$key],
                        'hadir' => 1,
                        'shift' => $cekShift,
                        'info' => $infoGet,
                    ]);

                    // $Record = new TestingAbsen;

                    // $Record->user_id = $request->get('user_id')[$key];
                    // $Record->date = $request->get('date_select')[$key];
                    // $Record->start_work = $swW;
                    // $Record->start_work_info = $request->get('start_work_info')[$key];
                    // $Record->end_work = $ewW;
                    // $Record->end_work_info = $request->get('end_work_info')[$key];
                    // $Record->desc = $request->get('desc')[$key];
                    // $Record->hadir = 1;
                    // $Record->shift = 1;
                    // $Record->where('id', $id)->update();
                }

                Alert::success('Berhasil', 'Data Absensi Tersimpan!!!');
            }
        }

        return redirect()->route('attendance-input-ubah');
    }

    public function attendance_now(Request $request)
    {
        if ($request->ajax()) {
            $date = Carbon::now()->format('Y-m-d');
            $data = Absen::where('date', $date)->with('user');
            return DataTables::eloquent($data)
                ->addColumn('user', function (Absen $absen) {
                    return $absen->user->name;
                })
                ->addColumn('date', function ($row) {
                    $date = date("d F Y", strtotime($row->date));
                    return $date;
                })
                ->addColumn('start_work', function ($row) {
                    $start_work = date("H:i:s", strtotime($row->start_work));
                    return $start_work;
                })
                ->addColumn('end_work', function ($row) {
                    if ($row->end_work == null) {
                        $end_work = 'Belum Absen';
                        return $end_work;
                    } else {
                        $end_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->end_work)->format('H:i:s');
                        return $end_work;
                    }
                })
                ->toJson();
        }
        return view('admin.pages.attendance');
    }

    public function index_approval(Request $request)
    {
        // use this for later
        // $td1 = Carbon::parse('2022-04-11 12:00:00');
        // $td2 = Carbon::parse('2022-04-12 07:00:00');
        // $diff = $td1->diff($td2);
        // $hours = $diff->format('%h');
        if ($request->ajax()) {
            $data = Absen::with('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function (Absen $absen) {
                    return $absen->user->nik;
                })
                ->addColumn('name', function (Absen $absen) {
                    return $absen->user->name;
                })
                ->addColumn('dept', function (Absen $absen) {
                    return $absen->user->dept;
                })
                ->addColumn('date', function ($row) {
                    $date = date("d F Y", strtotime($row->date));
                    return $date;
                })
                ->addColumn('start_work', function ($row) {
                    $start_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->start_work)->format('H:i:s');
                    return $start_work;
                })
                ->editColumn('end_work', function ($row) {
                    if ($row->end_work == null) {
                        $end_work = 'Belum Absen';
                        return $end_work;
                    } else {
                        $end_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->end_work)->format('H:i:s');
                        return $end_work;
                    }
                })
                ->addColumn('approval', function ($row) {
                    if ($row->approval == 'approved') {
                        $approval = '<form action="' . route('update-approved', $row->id) . '" method="post">

                          <button class="edit btn btn-primary btn-sm" type="submit">Approved</button>
                        </form>';
                        return $approval;
                    } elseif ($row->approval == '' || $row->approval == 'unapproved') {
                        $approval = '<form action="' . route('update-approval', $row->id) . '" method="post">

                          <button class="edit btn btn-danger btn-sm" type="submit">Unapproved</button>
                        </form>';
                        return $approval;
                    }
                })
                ->addColumn('action', 'admin.includes.action-manager')
                ->addColumn('check', 'admin.includes.action-check')
                ->rawColumns(['approval', 'action', 'check'])
                ->make(true);
        }

        return view('admin.pages.attendance-approval');
    }

    public function update_approve($id)
    {
        $absen = Absen::where('id', $id)->update([
            'approval' => 'approved',
            'approval_by' => \Auth::user()->name,
        ]);

        return Redirect::back();
    }

    public function update_approve_batch(Request $request)
    {
        $ids = $request->idc;
        $idd = array_map('intval', explode(',', $ids));

        $absen = Absen::whereIn('id', $idd)->update([
            'approval' => 'approved',
            'approval_by' => \Auth::user()->name,
        ]);

        return Redirect::back();
    }

    public function update_unapprove_batch(Request $request)
    {
        $ids = $request->idc;
        $idd = array_map('intval', explode(',', $ids));

        $absen = Absen::whereIn('id', $idd)->update([
            'approval' => 'unapproved',
            'approval_by' => '',
        ]);

        return Redirect::back();
    }

    public function update_approved($id)
    {
        $absen = Absen::where('id', $id)->update([
            'approval' => 'unapproved',
            'approval_by' => '',
        ]);

        return Redirect::back();
    }

    public function index_checked(Request $request)
    {
        // use this for later
        // $td1 = Carbon::parse('2022-04-11 12:00:00');
        // $td2 = Carbon::parse('2022-04-12 07:00:00');
        // $diff = $td1->diff($td2);
        // $hours = $diff->format('%h');
        if ($request->ajax()) {
            $data = Absen::where('approval', 'approved')->with('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function (Absen $absen) {
                    return $absen->user->nik;
                })
                ->addColumn('user', function (Absen $absen) {
                    return $absen->user->name;
                })
                ->addColumn('dept', function (Absen $absen) {
                    return $absen->user->dept;
                })
                ->addColumn('loc', function (Absen $absen) {
                    return $absen->user->loc;
                })
                ->addColumn('date', function ($row) {
                    $date = date("d F Y", strtotime($row->date));
                    return $date;
                })
                ->addColumn('start_work', function ($row) {
                    $start_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->start_work)->format('H:i:s');
                    return $start_work;
                })
                ->addColumn('start_work_info_url', function ($row) {
                    if ($row->start_work_info_url !== null) {
                        $check = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm edit-att">
            View
          </a>';
                        return $check;
                    } else {
                        $check = '<form action="' . route('update-checked', $row->id) . '" method="post">
                          <button class="edit btn btn-danger btn-sm" type="submit">Not Data</button>
                        </form>';
                        return $check;
                    }
                })
                ->editColumn('end_work', function ($row) {
                    if ($row->end_work == null) {
                        $end_work = 'Belum Absen';
                        return $end_work;
                    } else {
                        $end_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->end_work)->format('H:i:s');
                        return $end_work;
                    }
                })
                ->addColumn('end_work_info_url', 'admin.includes.action-att')
                ->addColumn('checked', function ($row) {
                    if ($row->checked == 'checked') {
                        $check = '<form action="' . route('update-unchecked', $row->id) . '" method="post">
                          <button class="edit btn btn-primary btn-sm" type="submit">Checked</button>
                        </form>';
                        return $check;
                    } else {
                        $check = '<form action="' . route('update-checked', $row->id) . '" method="post">
                          <button class="edit btn btn-danger btn-sm" type="submit">Unchecked</button>
                        </form>';
                        return $check;
                    }
                })
                ->addColumn('action', 'admin.includes.action-hrd')->rawColumns(['action', 'checked', 'start_work_info_url', 'end_work_info_url'])
                ->make(true);
        }

        return view('admin.pages.attendance-check');
    }

    public function update_checked($id)
    {
        $absen = Absen::where('id', $id)->update([
            'checked' => 'checked',
            'checked_by' => \Auth::user()->name,
        ]);

        return Redirect::back();
    }

    public function update_unchecked($id)
    {
        $absen = Absen::where('id', $id)->update([
            'checked' => 'unchecked',
            'checked_by' => '',
        ]);

        return Redirect::back();
    }

    public function show_att(Request $request)
    {
        $where = array('id' => $request->id);
        $absen = Absen::where($where)->with('user')->first();

        return Response()->json($absen);

    }

    public function show_att_start(Request $request)
    {
        $where = array('id' => $request->id);
        $absen = Absen::where($where)->with('user')->first();

        return Response()->json($absen);

    }

    public function edit_hrd(Request $request)
    {
        $where = array('id' => $request->id);
        $absen = Absen::where($where)->with('user')->first();

        return Response()->json($absen);
    }

    public function update_att(Request $request)
    {
        $attId = $request->id;
        $att = Absen::where('id', $attId)->update(
            [
                'start_work' => $request->start_work,
                'end_work' => $request->end_work,
            ]
        );
        return Response()->json($att);
    }

    public function index_summary(Request $request)
    {
        // use this for later
        // $td1 = Carbon::parse('2022-04-11 12:00:00');
        // $td2 = Carbon::parse('2022-04-12 07:00:00');
        // $diff = $td1->diff($td2);
        // $hours = $diff->format('%h');
        if ($request->ajax()) {
            $data = Absen::where([
                ['approval', '=', 'approved'],
                ['checked', '=', 'checked'],
            ])->whereNotNull('start_work')->whereNotNull('end_work')->with('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function (Absen $absen) {
                    return $absen->user->name;
                })
                ->addColumn('date', function ($row) {
                    $date = date("d F Y", strtotime($row->date));
                    return $date;
                })
                ->addColumn('start_work', function ($row) {
                    $start_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->start_work)->format('H:i:s');
                    return $start_work;
                })
                ->editColumn('end_work', function ($row) {
                    if ($row->end_work == null) {
                        $end_work = 'Belum Absen';
                        return $end_work;
                    } else {
                        $end_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->end_work)->format('H:i:s');
                        return $end_work;
                    }
                })
                ->make(true);
        }

        return view('admin.pages.attendance-summary');
    }

    public function master_employee(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = User::latest();

        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->orderColumn('start', '-name $1')
        //         ->addColumn('action', 'admin.includes.action-master-emp')
        //         ->make(true);
        // }

        if (Auth::user()->dept == 'HR Legal') {
            $data = DB::table('users')->latest()->get();
        } else {
            $data = DB::table('users')->where('dept', Auth::user()->dept)->where('status', 'Contract FL')->latest()->get();
        }



        return view('admin.pages.master-employee', ['data' => $data]);
    }

    public function add_emp()
    {
        $dept = DB::table('departements')->get();
        $position = DB::table('jabatan')->get();
        $location = DB::table('locations')->get();
        $education = DB::table('educations')->get();
        $kemandoran = DB::table('kemandoran')
                      ->join('users', 'kemandoran.nik', '=', 'users.nik')->get();

        return view('admin.pages.add-emp', ['dept' => $dept,
                                            'position' => $position,
                                            'location' => $location,
                                            'education' => $education,
                                            'kemandoran' => $kemandoran]);
    }

    public function store_emp(Request $request)
    {
        $nik = $request->nik;
        $no_ktp = $request->no_ktp;

        $check_nik = DB::table('users')->where('nik', $nik)->first();
        $check_no_ktp = DB::table('users')->where('no_ktp', $no_ktp)->first();

        $inputName = $request->input('name');

        // Remove leading and trailing spaces from the input string
        $inputName = trim($inputName);

        // Get the first character (start letter)
        $startLetter = $inputName[0] ?? '';

        // Get the last character (end letter)
        $endLetter = substr($inputName, -1);

        $ttl = $request->ttl;
        $ttl_format = Carbon::parse($ttl)->format('dmy');

        $absent_code = $startLetter.$endLetter.$ttl_format;

        if ($check_nik || $check_no_ktp) {
            Alert::warning('Gagal', 'Data sudah ada di database');
            return Redirect::back();
        } else {
            $path = ($request->file == null) ? 0 : $request->file->store('public/images');

            $input = User::create([
                'absent_code' => $absent_code,
                'nik' => $request->nik,
                'name' => $request->name,
                'dept' => $request->dept,
                'jabatan' => $request->jabatan,
                'kemandoran' => $request->kemandoran,
                'email' => $request->email,
                'loc_kerja' => $request->loc_kerja,
                'domisili' => $request->domisili,
                'sex' => $request->sex,
                'status' => $request->status,
                'grade' => $request->grade,
                'ttl' => $request->ttl,
                'start' => $request->start,
                'pendidikan' => $request->pendidikan,
                'agama' => $request->agama,
                'start_work_user' => $request->start_work_user,
                'end_work_user' => $request->end_work_user,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'sistem_absensi' => $request->sistem_absensi,
                'suku' => $request->suku,
                'loc' => $request->loc,
                'sistem_absensi' => $request->sistem_absensi,
                'no_ktp' => $request->no_ktp,
                'no_telpon' => $request->no_telpon,
                'kis' => $request->kis,
                'kpj' => $request->kpj,
                'no_sepatu_safety' => $request->no_sepatu_safety,
                'aktual_cuti' => $request->aktual_cuti,
                'status_pernikahan' => $request->status_pernikahan,
                'istri_suami' => $request->istri_suami,
                'anak_1' => $request->anak_1,
                'anak_2' => $request->anak_2,
                'anak_3' => $request->anak_3,
                'image_url' => $path,
                'no_baju' => $request->no_baju,
                'gol_darah' => $request->gol_darah,
                'bank' => $request->bank,
                'no_bank' => $request->no_bank,
            ]);

            WorkHistory::create([
                'nik' => $request->nik,
                'start' => $request->start,
                'position' => $request->jabatan,
                'status' => $request->status,
                'division' => $request->dept
            ]);

            Alert::success('Berhasil', 'Data tersimpan di database');
            return Redirect::back();
        }

    }

    public function update_emp(Request $request)
    {
        $action = $request->action;

        switch ($action) {
            case 'update':
                if ($image = $request->file) {
                    $destinationPath = 'image/';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                }

                if ($image != null) {
                    $input = User::where('id', $request->id)->update([
                        'nik' => $request->nik_emp,
                        'active' => $request->active,
                        'name' => $request->name,
                        'dept' => $request->dept,
                        'jabatan' => $request->jabatan,
                        'kemandoran' => $request->kemandoran,
                        'email' => $request->email,
                        'loc_kerja' => $request->loc_kerja,
                        'domisili' => $request->domisili,
                        'sex' => $request->sex,
                        'status' => $request->status,
                        'grade' => $request->grade,
                        'ttl' => $request->ttl,
                        'start' => $request->start_w,
                        'pendidikan' => $request->pendidikan,
                        'agama' => $request->agama,
                        'suku' => $request->suku,
                        'loc' => $request->loc,
                        'start_work_user' => $request->start_work_user,
                        'end_work_user' => $request->end_work_user,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'sistem_absensi' => $request->sistem_absensi,
                        'no_ktp' => $request->no_ktp,
                        'no_telpon' => $request->no_telpon,
                        'kis' => $request->kis,
                        'kpj' => $request->kpj,
                        'no_sepatu_safety' => $request->no_sepatu_safety,
                        'aktual_cuti' => $request->aktual_cuti,
                        'status_pernikahan' => $request->status_pernikahan,
                        'istri_suami' => $request->istri_suami,
                        'anak_1' => $request->anak_1,
                        'anak_2' => $request->anak_2,
                        'anak_3' => $request->anak_3,
                        'image_url' => $profileImage,
                        'no_baju' => $request->no_baju,
                        'gol_darah' => $request->gol_darah,
                        'bank' => $request->bank,
                        'no_bank' => $request->no_bank,
                    ]);
                    Alert::success('Berhasil', 'Data terupdate di database');
                    return Redirect::back();
                } else {

                    $input = User::where('id', $request->id)->update([
                        'nik' => $request->nik_emp,
                        'active' => $request->active,
                        'name' => $request->name,
                        'dept' => $request->dept,
                        'jabatan' => $request->jabatan,
                        'kemandoran' => $request->kemandoran,
                        'email' => $request->email,
                        'loc_kerja' => $request->loc_kerja,
                        'domisili' => $request->domisili,
                        'sex' => $request->sex,
                        'status' => $request->status,
                        'grade' => $request->grade,
                        'ttl' => $request->ttl,
                        'start' => $request->start_w,
                        'pendidikan' => $request->pendidikan,
                        'agama' => $request->agama,
                        'suku' => $request->suku,
                        'loc' => $request->loc,
                        'start_work_user' => $request->start_work_user,
                        'end_work_user' => $request->end_work_user,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'sistem_absensi' => $request->sistem_absensi,
                        'no_ktp' => $request->no_ktp,
                        'no_telpon' => $request->no_telpon,
                        'kis' => $request->kis,
                        'kpj' => $request->kpj,
                        'no_sepatu_safety' => $request->no_sepatu_safety,
                        'aktual_cuti' => $request->aktual_cuti,
                        'status_pernikahan' => $request->status_pernikahan,
                        'istri_suami' => $request->istri_suami,
                        'anak_1' => $request->anak_1,
                        'anak_2' => $request->anak_2,
                        'anak_3' => $request->anak_3,
                        'no_baju' => $request->no_baju,
                        'gol_darah' => $request->gol_darah,
                        'bank' => $request->bank,
                        'no_bank' => $request->no_bank,
                    ]);
                    Alert::success('Berhasil', 'Data terupdate di database');
                    return Redirect::back();
                }
                break;

                case 'mutation':
                    if ($image = $request->file) {
                        $destinationPath = 'image/';
                        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                        $image->move($destinationPath, $profileImage);
                    }

                    if ($image != null) {
                        $input = User::where('id', $request->id)->update([
                            'nik' => $request->nik_emp,
                            'active' => $request->active,
                            'name' => $request->name,
                            'dept' => $request->dept,
                            'jabatan' => $request->jabatan,
                            'kemandoran' => $request->kemandoran,
                            'email' => $request->email,
                            'loc_kerja' => $request->loc_kerja,
                            'domisili' => $request->domisili,
                            'sex' => $request->sex,
                            'status' => $request->status,
                            'grade' => $request->grade,
                            'ttl' => $request->ttl,
                            'start' => $request->start_w,
                            'pendidikan' => $request->pendidikan,
                            'agama' => $request->agama,
                            'suku' => $request->suku,
                            'loc' => $request->loc,
                            'start_work_user' => $request->start_work_user,
                            'end_work_user' => $request->end_work_user,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude,
                            'sistem_absensi' => $request->sistem_absensi,
                            'no_ktp' => $request->no_ktp,
                            'no_telpon' => $request->no_telpon,
                            'kis' => $request->kis,
                            'kpj' => $request->kpj,
                            'no_sepatu_safety' => $request->no_sepatu_safety,
                            'aktual_cuti' => $request->aktual_cuti,
                            'status_pernikahan' => $request->status_pernikahan,
                            'istri_suami' => $request->istri_suami,
                            'anak_1' => $request->anak_1,
                            'anak_2' => $request->anak_2,
                            'anak_3' => $request->anak_3,
                            'image_url' => $profileImage,
                            'no_baju' => $request->no_baju,
                            'gol_darah' => $request->gol_darah,
                            'bank' => $request->bank,
                            'no_bank' => $request->no_bank,
                        ]);

                        $workHistoryId = WorkHistory::latest()->first();

                        $startDate = Carbon::parse($workHistoryId->start);
                        $endDate = Carbon::parse($request->date_mutation);

                        $total_months = $endDate->diffInMonths($startDate);

                        WorkHistory::where('id', $workHistoryId->id)->update([
                            'end' => $request->date_mutation,
                            'duration' => $total_months,
                        ]);

                        WorkHistory::create([
                            'nik' => $request->nik_riw,
                            'start' => $request->date_mutation,
                            'position' => $request->jabatan,
                            'grade' => $request->grade,
                            'status' => $request->status,
                            'division' => $request->dept
                        ]);

                        Alert::success('Berhasil', 'Data terupdate di database');

                        return Redirect::back();
                    } else {

                        $input = User::where('id', $request->id)->update([
                            'nik' => $request->nik_emp,
                            'active' => $request->active,
                            'name' => $request->name,
                            'dept' => $request->dept,
                            'jabatan' => $request->jabatan,
                            'kemandoran' => $request->kemandoran,
                            'email' => $request->email,
                            'loc_kerja' => $request->loc_kerja,
                            'domisili' => $request->domisili,
                            'sex' => $request->sex,
                            'status' => $request->status,
                            'grade' => $request->grade,
                            'ttl' => $request->ttl,
                            'start' => $request->start_w,
                            'pendidikan' => $request->pendidikan,
                            'agama' => $request->agama,
                            'suku' => $request->suku,
                            'loc' => $request->loc,
                            'start_work_user' => $request->start_work_user,
                            'end_work_user' => $request->end_work_user,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude,
                            'sistem_absensi' => $request->sistem_absensi,
                            'no_ktp' => $request->no_ktp,
                            'no_telpon' => $request->no_telpon,
                            'kis' => $request->kis,
                            'kpj' => $request->kpj,
                            'no_sepatu_safety' => $request->no_sepatu_safety,
                            'aktual_cuti' => $request->aktual_cuti,
                            'status_pernikahan' => $request->status_pernikahan,
                            'istri_suami' => $request->istri_suami,
                            'anak_1' => $request->anak_1,
                            'anak_2' => $request->anak_2,
                            'anak_3' => $request->anak_3,
                            'no_baju' => $request->no_baju,
                            'gol_darah' => $request->gol_darah,
                            'bank' => $request->bank,
                            'no_bank' => $request->no_bank,
                        ]);

                        $workHistoryId = WorkHistory::latest()->first();

                        $startDate = Carbon::parse($workHistoryId->start);
                        $endDate = Carbon::parse($request->date_mutation);

                        $total_months = $endDate->diffInMonths($startDate);

                        WorkHistory::where('id', $workHistoryId->id)->update([
                            'end' => $request->date_mutation,
                            'duration' => $total_months,
                        ]);

                        WorkHistory::create([
                            'nik' => $request->nik_riw,
                            'start' => $request->date_mutation,
                            'position' => $request->jabatan,
                            'grade' => $request->grade,
                            'status' => $request->status,
                            'division' => $request->dept
                        ]);

                        Alert::success('Berhasil', 'Data terupdate di database');

                        return Redirect::back();
                    }
                    break;

            case 'history':
                WorkHistory::create([
                    'nik' => $request->nik_riw,
                    'start' => $request->start . +'-01',
                    'end' => $request->end . +'-01',
                    'duration' => $request->duration,
                    'position' => $request->position,
                    'grade' => $request->grade_history,
                    'status' => $request->status_history,
                    'division' => $request->division,
                    'remark' => $request->remark,
                ]);

                return redirect()->route('edit-emp', $request->id);
                break;

            case 'resign':
                EmpOut::create([
                    'nik' => $request->nik,
                    'no_approval' => $request->no_approval,
                    'start_work' => $request->start_worked,
                    'date_out' => $request->date_out,
                    'work_period' => $request->work_period,
                    'date_resign_approval' => $request->date_resign_approval,
                    'date_out_document' => $request->date_out_document,
                    'date_severance_pay' => $request->date_severance_pay,
                    'total_day_process' => $request->total_day_process,
                    'reason' => $request->reason,
                    'total_severance_pay' => str_replace(',', '', $request->total_severance_pay),
                ]);

                User::where('nik', $request->nik)->update([
                    'active' => $request->status_active,
                ]);

                return redirect()->route('edit-emp', $request->id);
                break;

            case 'del-resign':
                EmpOut::where('id', $request->id_resign)->delete();
                return redirect()->route('edit-emp', $request->id);
                break;

            case 'del-work':
                WorkHistory::where('id', $request->id_work)->delete();
                return redirect()->route('edit-emp', $request->id);
                break;
        }
    }

    public function update_active(Request $request)
    {
        $isChecked = $request->isChecked;
        $nik = $request->nik;
        if ($isChecked == 'true') {
            $data = User::where('nik', $nik)->update([
                'active' => 'yes',
            ]);
            return response()->json(['success' => true, 'message' => $isChecked]);
        } else {
            $data = User::where('nik', $nik)->update([
                'active' => 'no',
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => $isChecked]);

    }

    public function delete_emp(Request $request)
    {
        $data = User::where('id', $request->id)->delete();
        return Response()->json($data);
    }

    public function delete_photo($nik)
    {
        $data = User::where('nik', $nik)->first();

        $image_path = public_path('image/' . $data->image_url);

        if (File::exists($image_path)) {
            File::delete($image_path);

            User::where('nik', $nik)->update([
                'image_url' => '',
            ]);
        }

        return Redirect::route('edit-emp', $data->id);
    }

    public function view_emp($id)
    {
        $emp = User::findOrFail($id);
        return view('admin.pages.view-emp', ['emp' => $emp]);
    }

    public function edit_emp($id)
    {
        $emp = User::findOrFail($id);

        $nik = $emp->nik;
        $grade = DB::table('grade')->get();

        $dept = DB::table('departements')->get();
        $position = DB::table('positions')->get();
        $location = DB::table('locations')->get();
        $education = DB::table('educations')->get();
        $status = User::groupBy('status')->get();
        $work_histories = WorkHistory::where('nik', $nik)->get();
        $resigns = EmpOut::where('nik', $nik)->get();
        $kemandoran = DB::table('kemandoran')
                      ->join('users', 'kemandoran.nik', '=', 'users.nik')->get();

        return view('admin.pages.edit-emp', ['emp' => $emp,
            'dept' => $dept,
            'status' => $status,
            'position' => $position,
            'location' => $location,
            'education' => $education,
            'work_histories' => $work_histories,
            'resigns' => $resigns,
            'kemandoran' => $kemandoran,
            'grade' => $grade
        ]);
    }

    public function export()
    {
        return Excel::download(new AbsensExport, 'users.xlsx');
    }

    public function indexRegular()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->format('Y-m-d');
        $monthly = User::where('status', 'Monthly')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $dept = \Auth::user()->dept;
        // dd($dept);

        $staff = User::where('status', 'Staff')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $manager = User::where('status', 'Manager')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $regular = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $reg_L_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_H_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_TA_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_MX_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_D_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_E_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_I_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_S_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_C_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_IX_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_SX_dept = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_L = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_L_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'L');
        })->count();

        $reg_D = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_D_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'D');
        })->count();

        $reg_A = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'A');
        })->count();

        $reg_A_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'A');
        })->count();

        $reg_A_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'A');
        })->count();

        $reg_A_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'A');
        })->count();

        $reg_A_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'A');
        })->count();

        $reg_A_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'A');
        })->count();

        $reg_H = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_H_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'H');
        })->count();

        $reg_E = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_E_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'E');
        })->count();

        $reg_TA = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_TA_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'M');
        })->count();

        $reg_MX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_MX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'MX');
        })->count();

        $reg_I = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_I_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'I');
        })->count();

        $reg_S = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_S_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'S');
        })->count();

        $reg_C = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_C_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'C');
        })->count();

        $reg_IX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_IX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'IX');
        })->count();

        $reg_SX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();

        $reg_SX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->where('desc', '=', 'SX');
        })->count();
        // $t_attend = Absen::where('date',$today)->with(['user' => function($q) {
        //   $q->where('status', 'Regular');
        // }])->count();

        $budget_monthly = User::where('status', 'Monthly')->count();
        $budget_staff = User::where('status', 'Staff')->count();
        $budget_manager = User::where('status', 'Manager')->count();
        $budget_regular = User::where('status', 'Regular')->count();
        $budget_dept = User::where('status', 'Regular')->where('dept', $dept)->count();

        // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_manager = ($manager / $budget_manager) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_manager + $budget_regular;
        $act_total = $monthly + $staff + $manager + $regular;
        $per_total = ($act_total / $budget_total) * 100;

        // tanggal
        $date = Carbon::parse(Carbon::now())->translatedformat('l M, Y');

        // latest
        $latest1 = AbsenReg::latest()->first();
        $latest = ($latest1 == null) ? 0 : Carbon::parse($latest1->created_at)->format('d M Y H:s');
        // $latest = Carbon::parse($latest1->created_at)->format('d M Y H:s');

        // total karyawan
        $t_kary = User::count();

        // total dept kehadiran
        $t_dept = ($reg_H_dept == 0 || $budget_dept == 0) ? 0 : ($reg_H_dept / $budget_dept) * 100;

        // todate
        $month = Carbon::parse(Carbon::now())->format('m');
        $day1 = range(1, Carbon::now()->month($month)->daysInMonth);
        $day = (implode(",", $day1));
        // $day = json_encode($day1);

        foreach ($day1 as $key => $value) {
            $reg_h_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->whereIn('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'SX');
            })->count();

        }

        $reg_h_day = (implode(",", $reg_h_day_array));
        $reg_a_day = (implode(",", $reg_a_day_array));
        $reg_mx_day = (implode(",", $reg_mx_day_array));
        $reg_l_day = (implode(",", $reg_l_day_array));
        $reg_d_day = (implode(",", $reg_d_day_array));
        $reg_e_day = (implode(",", $reg_e_day_array));
        $reg_i_day = (implode(",", $reg_i_day_array));
        $reg_s_day = (implode(",", $reg_s_day_array));
        $reg_c_day = (implode(",", $reg_c_day_array));
        $reg_ix_day = (implode(",", $reg_ix_day_array));
        $reg_sx_day = (implode(",", $reg_sx_day_array));
        // dd($reg_a_day);
        // $reg_h_day = (json_encode($reg_h_day_array));

        // todate regular
        $reg_months = $todayL->startOfMonth();
        $reg_month = Carbon::parse($reg_months)->format('Y-m-d');

        $to_reg_h = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'H')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->count();

        $tot_regs = User::where('status', 'Regular')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;

        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->count();

        // $list_absen_reg = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        //   $query->where('date', '=', $today);
        //   $query->whereIn('desc', ['M','MX','D','E','I','S','C','IX','SX']);
        // })->get();

        $kondisi = User::where('status', 'Regular')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['M', 'MX', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
            })->get();

        $startDay = Carbon::parse(Carbon::now()->startOfMonth())->format('Y-m-d');
        $endDay = Carbon::parse(Carbon::now())->format('Y-m-d');
        $list_absen_reg_todate = User::where('status', 'Regular')->whereHas('absen_reg', function ($q) use ($startDay, $endDay) {
            $q->whereIn('desc', ['M', 'MX', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
            $q->whereBetween('date', [$startDay, $endDay]);
        })
            ->whereHas('mandor')
            ->paginate(10);

        $listDept = User::groupBy('dept')->get();

        return view('admin.pages.dashboard-regular', [
            'monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'listDept' => $listDept,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_manager' => $budget_manager,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_manager' => $per_manager,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_h_b' => $reg_H_B,
            'reg_h_c' => $reg_H_C,
            'reg_h_d' => $reg_H_D,
            'reg_h_e' => $reg_H_E,
            'reg_h_f' => $reg_H_F,
            'reg_l' => $reg_L,
            'reg_l_b' => $reg_L_B,
            'reg_l_c' => $reg_L_C,
            'reg_l_d' => $reg_L_D,
            'reg_l_e' => $reg_L_E,
            'reg_l_f' => $reg_L_F,
            'reg_d' => $reg_D,
            'reg_d_b' => $reg_D_B,
            'reg_d_c' => $reg_D_C,
            'reg_d_d' => $reg_D_D,
            'reg_d_e' => $reg_D_E,
            'reg_d_f' => $reg_D_F,
            'reg_a' => $reg_A,
            'reg_a_b' => $reg_A_B,
            'reg_a_c' => $reg_A_C,
            'reg_a_d' => $reg_A_D,
            'reg_a_e' => $reg_A_E,
            'reg_a_f' => $reg_A_F,
            'reg_mx' => $reg_MX,
            'reg_mx_b' => $reg_MX_B,
            'reg_mx_c' => $reg_MX_C,
            'reg_mx_d' => $reg_MX_D,
            'reg_mx_e' => $reg_MX_E,
            'reg_mx_f' => $reg_MX_F,
            'reg_e' => $reg_E,
            'reg_e_b' => $reg_E_B,
            'reg_e_c' => $reg_E_C,
            'reg_e_d' => $reg_E_D,
            'reg_e_e' => $reg_E_E,
            'reg_e_f' => $reg_E_F,
            'reg_ta' => $reg_TA,
            'reg_ta_b' => $reg_TA_B,
            'reg_ta_c' => $reg_TA_C,
            'reg_ta_d' => $reg_TA_D,
            'reg_ta_e' => $reg_TA_E,
            'reg_ta_f' => $reg_TA_F,
            'reg_i' => $reg_I,
            'reg_i_b' => $reg_I_B,
            'reg_i_c' => $reg_I_C,
            'reg_i_d' => $reg_I_D,
            'reg_i_e' => $reg_I_E,
            'reg_i_f' => $reg_I_F,
            'reg_s' => $reg_S,
            'reg_s_b' => $reg_S_B,
            'reg_s_c' => $reg_S_C,
            'reg_s_d' => $reg_S_D,
            'reg_s_e' => $reg_S_E,
            'reg_s_f' => $reg_S_F,
            'reg_c' => $reg_C,
            'reg_c_b' => $reg_C_B,
            'reg_c_c' => $reg_C_C,
            'reg_c_d' => $reg_C_D,
            'reg_c_e' => $reg_C_E,
            'reg_c_f' => $reg_C_F,
            'reg_ix' => $reg_IX,
            'reg_ix_b' => $reg_IX_B,
            'reg_ix_c' => $reg_IX_C,
            'reg_ix_d' => $reg_IX_D,
            'reg_ix_e' => $reg_IX_E,
            'reg_ix_f' => $reg_IX_F,
            'reg_sx' => $reg_SX,
            'reg_sx_b' => $reg_SX_B,
            'reg_sx_c' => $reg_SX_C,
            'reg_sx_d' => $reg_SX_D,
            'reg_sx_e' => $reg_SX_E,
            'reg_sx_f' => $reg_SX_F,
            'reg_h_dept' => $reg_H_dept,
            'reg_ta_dept' => $reg_TA_dept,
            'reg_mx_dept' => $reg_MX_dept,
            'reg_l_dept' => $reg_L_dept,
            'reg_d_dept' => $reg_D_dept,
            'reg_e_dept' => $reg_E_dept,
            'reg_i_dept' => $reg_I_dept,
            'reg_s_dept' => $reg_S_dept,
            'reg_c_dept' => $reg_C_dept,
            'reg_ix_dept' => $reg_IX_dept,
            'reg_sx_dept' => $reg_SX_dept,
            'dept' => $dept,
            't_dept' => $t_dept,
            'day' => $day,
            'reg_h_day' => $reg_h_day,
            'reg_a_day' => $reg_a_day,
            'reg_mx_day' => $reg_mx_day,
            'reg_l_day' => $reg_l_day,
            'reg_d_day' => $reg_d_day,
            'reg_e_day' => $reg_e_day,
            'reg_i_day' => $reg_i_day,
            'reg_s_day' => $reg_s_day,
            'reg_c_day' => $reg_c_day,
            'reg_ix_day' => $reg_ix_day,
            'reg_sx_day' => $reg_sx_day,
            'to_reg_h' => $to_reg_h,
            'to_reg_a' => $to_reg_a,
            'to_reg_mx' => $to_reg_mx,
            'to_reg_l' => $to_reg_l,
            'to_reg_d' => $to_reg_d,
            'to_reg_e' => $to_reg_e,
            'to_reg_i' => $to_reg_i,
            'to_reg_s' => $to_reg_s,
            'to_reg_c' => $to_reg_c,
            'to_reg_ix' => $to_reg_ix,
            'to_reg_sx' => $to_reg_sx,
            'tot_reg' => $tot_reg,
            'per_tot_reg_h' => $per_tot_reg_h,
            'per_tot_reg_a' => $per_tot_reg_a,
            'per_tot_reg_mx' => $per_tot_reg_mx,
            'budget_reg_dept' => $budget_reg_dept,
            'list_absen_reg' => $list_absen_reg,
            'list_absen_reg_todate' => $list_absen_reg_todate,
            'kondisi' => $kondisi,
        ]);
    }

    public function new_dash()
    {
        $dept = Auth::user()->dept;
        $mandor = User::where('dept', $dept)
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();
        $date = Carbon::now()->format('Y-m-d');
        // $date = '2024-04-08';

        if ($dept == 'I/A' || $dept == 'I/C' || $dept == 'II/E' || $dept == 'II/F') {
            $mandor = User::where('dept', $dept)
                ->where('jabatan', 'Mandor Tapping')
                ->select('nik')
                ->get();

            $latestUpdatedAt = AbsenReg::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $data = [];

            $totalRegularTotal1 = 0;
            $totalFlTotal1 = 0;

            $totalHTotalReg = 0;
            $totalTATotalReg = 0;
            $totalDTotalReg = 0;
            $totalLTotalReg = 0;
            $totalMTotalReg = 0;
            $totalMXTotalReg = 0;
            $totalSTotalReg = 0;
            $totalSXTotalReg = 0;
            $totalITotalReg = 0;
            $totalIPTotalReg = 0;
            $totalIXTotalReg = 0;
            $totalCTTotalReg = 0;
            $totalCHTotalReg = 0;
            $totalCBTotalReg = 0;
            $totalCLTotalReg = 0;

            $totalHTotalFl = 0;
            $totalTATotalFl = 0;
            $totalDTotalFl = 0;
            $totalLTotalFl = 0;
            $totalMTotalFl = 0;
            $totalMXTotalFl = 0;
            $totalSTotalFl = 0;
            $totalSXTotalFl = 0;
            $totalITotalFl = 0;
            $totalIPTotalFl = 0;
            $totalIXTotalFl = 0;
            $totalCTTotalFl = 0;
            $totalCHTotalFl = 0;
            $totalCBTotalFl = 0;
            $totalCLTotalFl = 0;

            foreach ($mandor as $mandor) {
                $mandorName = User::where('nik', $mandor)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor)
                    ->where('dept', $dept)
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1 += $regularTotal1;

                $flTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor)
                    ->where('dept', $dept)
                    ->where('status', 'Contract')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1 += $flTotal1;

                $empReg1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor)
                    ->where('users.status', 'Contract')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1 = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->get();

                $totalAttregFinal = $regAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalReg = $regAtt1->sum('hadir');
                $totalTAFinalReg = $regAtt1->sum('ta');
                $totalDFinalReg = $regAtt1->sum('d');
                $totalLFinalReg = $regAtt1->sum('l');
                $totalMFinalReg = $regAtt1->sum('m');
                $totalMXFinalReg = $regAtt1->sum('mx');
                $totalSFinalReg = $regAtt1->sum('s');
                $totalSXFinalReg = $regAtt1->sum('sx');
                $totalIFinalReg = $regAtt1->sum('i');
                $totalIPFinalReg = $regAtt1->sum('ip');
                $totalIXFinalReg = $regAtt1->sum('ix');
                $totalCTFinalReg = $regAtt1->sum('ct');
                $totalCHFinalReg = $regAtt1->sum('ch');
                $totalCBFinalReg = $regAtt1->sum('cb');
                $totalCLFinalReg = $regAtt1->sum('cl');

                $totalHTotalReg += $totalHFinalReg;
                $totalTATotalReg += $totalTAFinalReg;
                $totalDTotalReg += $totalDFinalReg;
                $totalLTotalReg += $totalLFinalReg;
                $totalMTotalReg += $totalMFinalReg;
                $totalMXTotalReg += $totalMXFinalReg;
                $totalSTotalReg += $totalSFinalReg;
                $totalSXTotalReg += $totalSXFinalReg;
                $totalITotalReg += $totalIFinalReg;
                $totalIPTotalReg += $totalIPFinalReg;
                $totalIXTotalReg += $totalIXFinalReg;
                $totalCTTotalReg += $totalCTFinalReg;
                $totalCHTotalReg += $totalCHFinalReg;
                $totalCBTotalReg += $totalCBFinalReg;
                $totalCLTotalReg += $totalCLFinalReg;

                $flAtt1 = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor)
                    ->where('users.status', 'Contract')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinal = $flAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFl = $flAtt1->sum('hadir');
                $totalTAFinalFl = $flAtt1->sum('ta');
                $totalDFinalFl = $flAtt1->sum('d');
                $totalLFinalFl = $flAtt1->sum('l');
                $totalMFinalFl = $flAtt1->sum('m');
                $totalMXFinalFl = $flAtt1->sum('mx');
                $totalSFinalFl = $flAtt1->sum('s');
                $totalSXFinalFl = $flAtt1->sum('sx');
                $totalIFinalFl = $flAtt1->sum('i');
                $totalIPFinalFl = $flAtt1->sum('ip');
                $totalIXFinalFl = $flAtt1->sum('ix');
                $totalCTFinalFl = $flAtt1->sum('ct');
                $totalCHFinalFl = $flAtt1->sum('ch');
                $totalCBFinalFl = $flAtt1->sum('cb');
                $totalCLFinalFl = $flAtt1->sum('cl');

                $totalHTotalFl += $totalHFinalFl;
                $totalTATotalFl += $totalTAFinalFl;
                $totalDTotalFl += $totalDFinalFl;
                $totalLTotalFl += $totalLFinalFl;
                $totalMTotalFl += $totalMFinalFl;
                $totalMXTotalFl += $totalMXFinalFl;
                $totalSTotalFl += $totalSFinalFl;
                $totalSXTotalFl += $totalSXFinalFl;
                $totalITotalFl += $totalIFinalFl;
                $totalIPTotalFl += $totalIPFinalFl;
                $totalIXTotalFl += $totalIXFinalFl;
                $totalCTTotalFl += $totalCTFinalFl;
                $totalCHTotalFl += $totalCHFinalFl;
                $totalCBTotalFl += $totalCBFinalFl;
                $totalCLTotalFl += $totalCLFinalFl;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'regularTotal1' => $regularTotal1,
                    'flTotal1' => $flTotal1,
                    'totalHFinalReg' => $totalHFinalReg,
                    'totalTAFinalReg' => $totalTAFinalReg,
                    'totalDFinalReg' => $totalDFinalReg,
                    'totalLFinalReg' => $totalLFinalReg,
                    'totalMFinalReg' => $totalMFinalReg,
                    'totalMXFinalReg' => $totalMXFinalReg,
                    'totalSFinalReg' => $totalSFinalReg,
                    'totalSXFinalReg' => $totalSXFinalReg,
                    'totalIFinalReg' => $totalIFinalReg,
                    'totalIPFinalReg' => $totalIPFinalReg,
                    'totalIXFinalReg' => $totalIXFinalReg,
                    'totalCTFinalReg' => $totalCTFinalReg,
                    'totalCHFinalReg' => $totalCHFinalReg,
                    'totalCBFinalReg' => $totalCBFinalReg,
                    'totalCLFinalReg' => $totalCLFinalReg,
                    'totalHFinalFl' => $totalHFinalFl,
                    'totalTAFinalFl' => $totalTAFinalFl,
                    'totalDFinalFl' => $totalDFinalFl,
                    'totalLFinalFl' => $totalLFinalFl,
                    'totalMFinalFl' => $totalMFinalFl,
                    'totalMXFinalFl' => $totalMXFinalFl,
                    'totalSFinalFl' => $totalSFinalFl,
                    'totalSXFinalFl' => $totalSXFinalFl,
                    'totalIFinalFl' => $totalIFinalFl,
                    'totalIPFinalFl' => $totalIPFinalFl,
                    'totalIXFinalFl' => $totalIXFinalFl,
                    'totalCTFinalFl' => $totalCTFinalFl,
                    'totalCHFinalFl' => $totalCHFinalFl,
                    'totalCBFinalFl' => $totalCBFinalFl,
                    'totalCLFinalFl' => $totalCLFinalFl,
                    'date' => $date,
                    'dept' => $dept,
                ];

                $data[] = $item;
            }

            usort($data, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            return view(
                'admin.pages.summary-per-dept.summary-per-dept-mandor-result',
                [
                    'empReg1' => $empReg1,
                    'data' => $data,
                    'date' => $date,
                    'dept' => $dept,
                    'totalRegularTotal1' => $totalRegularTotal1,
                    'totalFlTotal1' => $totalFlTotal1,
                    'totalHTotalReg' => $totalHTotalReg,
                    'totalTATotalReg' => $totalTATotalReg,
                    'totalDTotalReg' => $totalDTotalReg,
                    'totalLTotalReg' => $totalLTotalReg,
                    'totalMTotalReg' => $totalMTotalReg,
                    'totalMXTotalReg' => $totalMXTotalReg,
                    'totalSTotalReg' => $totalSTotalReg,
                    'totalSXTotalReg' => $totalSXTotalReg,
                    'totalITotalReg' => $totalITotalReg,
                    'totalIPTotalReg' => $totalIPTotalReg,
                    'totalIXTotalReg' => $totalIXTotalReg,
                    'totalCTTotalReg' => $totalCTTotalReg,
                    'totalCHTotalReg' => $totalCHTotalReg,
                    'totalCBTotalReg' => $totalCBTotalReg,
                    'totalCLTotalReg' => $totalCLTotalReg,
                    'totalHTotalFl' => $totalHTotalFl,
                    'totalTATotalFl' => $totalTATotalFl,
                    'totalDTotalFl' => $totalDTotalFl,
                    'totalLTotalFl' => $totalLTotalFl,
                    'totalMTotalFl' => $totalMTotalFl,
                    'totalMXTotalFl' => $totalMXTotalFl,
                    'totalSTotalFl' => $totalSTotalFl,
                    'totalSXTotalFl' => $totalSXTotalFl,
                    'totalITotalFl' => $totalITotalFl,
                    'totalIPTotalFl' => $totalIPTotalFl,
                    'totalIXTotalFl' => $totalIXTotalFl,
                    'totalCTTotalFl' => $totalCTTotalFl,
                    'totalCHTotalFl' => $totalCHTotalFl,
                    'totalCBTotalFl' => $totalCBTotalFl,
                    'totalCLTotalFl' => $totalCLTotalFl,
                    'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                ]
            );
        } elseif ($dept == 'I/B' || $dept == 'II/D') {

            $latestUpdatedAt = TestingAbsen::whereDate('updated_at', $date)->latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $data = [];

            $totalRegularTotal1 = 0;
            $totalFlTotal1 = 0;

            $totalHTotalReg = 0;
            $totalTATotalReg = 0;
            $totalDTotalReg = 0;
            $totalLTotalReg = 0;
            $totalMTotalReg = 0;
            $totalMXTotalReg = 0;
            $totalSTotalReg = 0;
            $totalSXTotalReg = 0;
            $totalITotalReg = 0;
            $totalIPTotalReg = 0;
            $totalIXTotalReg = 0;
            $totalCTTotalReg = 0;
            $totalCHTotalReg = 0;
            $totalCBTotalReg = 0;
            $totalCLTotalReg = 0;

            $totalHTotalFl = 0;
            $totalTATotalFl = 0;
            $totalDTotalFl = 0;
            $totalLTotalFl = 0;
            $totalMTotalFl = 0;
            $totalMXTotalFl = 0;
            $totalSTotalFl = 0;
            $totalSXTotalFl = 0;
            $totalITotalFl = 0;
            $totalIPTotalFl = 0;
            $totalIXTotalFl = 0;
            $totalCTTotalFl = 0;
            $totalCHTotalFl = 0;
            $totalCBTotalFl = 0;
            $totalCLTotalFl = 0;

            foreach ($mandor as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', $dept)
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1 += $regularTotal1;

                $flTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', $dept)
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1 += $flTotal1;

                $empReg1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1 = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->get();

                $totalAttregFinal = $regAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalReg = $regAtt1->sum('hadir');
                $totalTAFinalReg = $regAtt1->sum('ta');
                $totalDFinalReg = $regAtt1->sum('d');
                $totalLFinalReg = $regAtt1->sum('l');
                $totalMFinalReg = $regAtt1->sum('m');
                $totalMXFinalReg = $regAtt1->sum('mx');
                $totalSFinalReg = $regAtt1->sum('s');
                $totalSXFinalReg = $regAtt1->sum('sx');
                $totalIFinalReg = $regAtt1->sum('i');
                $totalIPFinalReg = $regAtt1->sum('ip');
                $totalIXFinalReg = $regAtt1->sum('ix');
                $totalCTFinalReg = $regAtt1->sum('ct');
                $totalCHFinalReg = $regAtt1->sum('ch');
                $totalCBFinalReg = $regAtt1->sum('cb');
                $totalCLFinalReg = $regAtt1->sum('cl');

                $totalHTotalReg += $totalHFinalReg;
                $totalTATotalReg += $totalTAFinalReg;
                $totalDTotalReg += $totalDFinalReg;
                $totalLTotalReg += $totalLFinalReg;
                $totalMTotalReg += $totalMFinalReg;
                $totalMXTotalReg += $totalMXFinalReg;
                $totalSTotalReg += $totalSFinalReg;
                $totalSXTotalReg += $totalSXFinalReg;
                $totalITotalReg += $totalIFinalReg;
                $totalIPTotalReg += $totalIPFinalReg;
                $totalIXTotalReg += $totalIXFinalReg;
                $totalCTTotalReg += $totalCTFinalReg;
                $totalCHTotalReg += $totalCHFinalReg;
                $totalCBTotalReg += $totalCBFinalReg;
                $totalCLTotalReg += $totalCLFinalReg;

                $flAtt1 = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinal = $flAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFl = $flAtt1->sum('hadir');
                $totalTAFinalFl = $flAtt1->sum('ta');
                $totalDFinalFl = $flAtt1->sum('d');
                $totalLFinalFl = $flAtt1->sum('l');
                $totalMFinalFl = $flAtt1->sum('m');
                $totalMXFinalFl = $flAtt1->sum('mx');
                $totalSFinalFl = $flAtt1->sum('s');
                $totalSXFinalFl = $flAtt1->sum('sx');
                $totalIFinalFl = $flAtt1->sum('i');
                $totalIPFinalFl = $flAtt1->sum('ip');
                $totalIXFinalFl = $flAtt1->sum('ix');
                $totalCTFinalFl = $flAtt1->sum('ct');
                $totalCHFinalFl = $flAtt1->sum('ch');
                $totalCBFinalFl = $flAtt1->sum('cb');
                $totalCLFinalFl = $flAtt1->sum('cl');

                $totalHTotalFl += $totalHFinalFl;
                $totalTATotalFl += $totalTAFinalFl;
                $totalDTotalFl += $totalDFinalFl;
                $totalLTotalFl += $totalLFinalFl;
                $totalMTotalFl += $totalMFinalFl;
                $totalMXTotalFl += $totalMXFinalFl;
                $totalSTotalFl += $totalSFinalFl;
                $totalSXTotalFl += $totalSXFinalFl;
                $totalITotalFl += $totalIFinalFl;
                $totalIPTotalFl += $totalIPFinalFl;
                $totalIXTotalFl += $totalIXFinalFl;
                $totalCTTotalFl += $totalCTFinalFl;
                $totalCHTotalFl += $totalCHFinalFl;
                $totalCBTotalFl += $totalCBFinalFl;
                $totalCLTotalFl += $totalCLFinalFl;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'regularTotal1' => $regularTotal1,
                    'flTotal1' => $flTotal1,
                    'totalHFinalReg' => $totalHFinalReg,
                    'totalTAFinalReg' => $totalTAFinalReg,
                    'totalDFinalReg' => $totalDFinalReg,
                    'totalLFinalReg' => $totalLFinalReg,
                    'totalMFinalReg' => $totalMFinalReg,
                    'totalMXFinalReg' => $totalMXFinalReg,
                    'totalSFinalReg' => $totalSFinalReg,
                    'totalSXFinalReg' => $totalSXFinalReg,
                    'totalIFinalReg' => $totalIFinalReg,
                    'totalIPFinalReg' => $totalIPFinalReg,
                    'totalIXFinalReg' => $totalIXFinalReg,
                    'totalCTFinalReg' => $totalCTFinalReg,
                    'totalCHFinalReg' => $totalCHFinalReg,
                    'totalCBFinalReg' => $totalCBFinalReg,
                    'totalCLFinalReg' => $totalCLFinalReg,
                    'totalHFinalFl' => $totalHFinalFl,
                    'totalTAFinalFl' => $totalTAFinalFl,
                    'totalDFinalFl' => $totalDFinalFl,
                    'totalLFinalFl' => $totalLFinalFl,
                    'totalMFinalFl' => $totalMFinalFl,
                    'totalMXFinalFl' => $totalMXFinalFl,
                    'totalSFinalFl' => $totalSFinalFl,
                    'totalSXFinalFl' => $totalSXFinalFl,
                    'totalIFinalFl' => $totalIFinalFl,
                    'totalIPFinalFl' => $totalIPFinalFl,
                    'totalIXFinalFl' => $totalIXFinalFl,
                    'totalCTFinalFl' => $totalCTFinalFl,
                    'totalCHFinalFl' => $totalCHFinalFl,
                    'totalCBFinalFl' => $totalCBFinalFl,
                    'totalCLFinalFl' => $totalCLFinalFl,
                    'date' => $date,
                    'dept' => $dept,
                ];

                $data[] = $item;
            }

            usort($data, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            return view(
                'admin.pages.dashboard-new',
                [
                    'empReg1' => $empReg1,
                    'date' => $date,
                    'dept' => $dept,
                    'data' => $data,
                    'totalRegularTotal1' => $totalRegularTotal1,
                    'totalFlTotal1' => $totalFlTotal1,
                    'totalHTotalReg' => $totalHTotalReg,
                    'totalTATotalReg' => $totalTATotalReg,
                    'totalDTotalReg' => $totalDTotalReg,
                    'totalLTotalReg' => $totalLTotalReg,
                    'totalMTotalReg' => $totalMTotalReg,
                    'totalMXTotalReg' => $totalMXTotalReg,
                    'totalSTotalReg' => $totalSTotalReg,
                    'totalSXTotalReg' => $totalSXTotalReg,
                    'totalITotalReg' => $totalITotalReg,
                    'totalIPTotalReg' => $totalIPTotalReg,
                    'totalIXTotalReg' => $totalIXTotalReg,
                    'totalCTTotalReg' => $totalCTTotalReg,
                    'totalCHTotalReg' => $totalCHTotalReg,
                    'totalCBTotalReg' => $totalCBTotalReg,
                    'totalCLTotalReg' => $totalCLTotalReg,
                    'totalHTotalFl' => $totalHTotalFl,
                    'totalTATotalFl' => $totalTATotalFl,
                    'totalDTotalFl' => $totalDTotalFl,
                    'totalLTotalFl' => $totalLTotalFl,
                    'totalMTotalFl' => $totalMTotalFl,
                    'totalMXTotalFl' => $totalMXTotalFl,
                    'totalSTotalFl' => $totalSTotalFl,
                    'totalSXTotalFl' => $totalSXTotalFl,
                    'totalITotalFl' => $totalITotalFl,
                    'totalIPTotalFl' => $totalIPTotalFl,
                    'totalIXTotalFl' => $totalIXTotalFl,
                    'totalCTTotalFl' => $totalCTTotalFl,
                    'totalCHTotalFl' => $totalCHTotalFl,
                    'totalCBTotalFl' => $totalCBTotalFl,
                    'totalCLTotalFl' => $totalCLTotalFl,
                    'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                ]
            );
        } elseif ($dept == 'Factory') {
            $mandor = User::where('dept', $dept)
                ->where('jabatan', 'Mandor Tapping')
                ->select('nik')
                ->get();

            $latestUpdatedAt = TestingAbsen::whereDate('updated_at', $date)->latest('updated_at')->value('updated_at');

            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $data = [];

            $totalRegularTotal1 = 0;
            $totalFlTotal1 = 0;

            $totalHTotalReg = 0;
            $totalTATotalReg = 0;
            $totalDTotalReg = 0;
            $totalLTotalReg = 0;
            $totalMTotalReg = 0;
            $totalMXTotalReg = 0;
            $totalSTotalReg = 0;
            $totalSXTotalReg = 0;
            $totalITotalReg = 0;
            $totalIPTotalReg = 0;
            $totalIXTotalReg = 0;
            $totalCTTotalReg = 0;
            $totalCHTotalReg = 0;
            $totalCBTotalReg = 0;
            $totalCLTotalReg = 0;

            $totalHTotalFl = 0;
            $totalTATotalFl = 0;
            $totalDTotalFl = 0;
            $totalLTotalFl = 0;
            $totalMTotalFl = 0;
            $totalMXTotalFl = 0;
            $totalSTotalFl = 0;
            $totalSXTotalFl = 0;
            $totalITotalFl = 0;
            $totalIPTotalFl = 0;
            $totalIXTotalFl = 0;
            $totalCTTotalFl = 0;
            $totalCHTotalFl = 0;
            $totalCBTotalFl = 0;
            $totalCLTotalFl = 0;

            foreach ($mandor as $mandor) {

                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', $dept)
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1 += $regularTotal1;

                $flTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', $dept)
                    ->where('status', 'Contract')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1 += $flTotal1;

                $empReg1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1 = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->get();

                $totalAttregFinal = $regAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalReg = $regAtt1->sum('hadir');
                $totalTAFinalReg = $regAtt1->sum('ta');
                $totalDFinalReg = $regAtt1->sum('d');
                $totalLFinalReg = $regAtt1->sum('l');
                $totalMFinalReg = $regAtt1->sum('m');
                $totalMXFinalReg = $regAtt1->sum('mx');
                $totalSFinalReg = $regAtt1->sum('s');
                $totalSXFinalReg = $regAtt1->sum('sx');
                $totalIFinalReg = $regAtt1->sum('i');
                $totalIPFinalReg = $regAtt1->sum('ip');
                $totalIXFinalReg = $regAtt1->sum('ix');
                $totalCTFinalReg = $regAtt1->sum('ct');
                $totalCHFinalReg = $regAtt1->sum('ch');
                $totalCBFinalReg = $regAtt1->sum('cb');
                $totalCLFinalReg = $regAtt1->sum('cl');

                $totalHTotalReg += $totalHFinalReg;
                $totalTATotalReg += $totalTAFinalReg;
                $totalDTotalReg += $totalDFinalReg;
                $totalLTotalReg += $totalLFinalReg;
                $totalMTotalReg += $totalMFinalReg;
                $totalMXTotalReg += $totalMXFinalReg;
                $totalSTotalReg += $totalSFinalReg;
                $totalSXTotalReg += $totalSXFinalReg;
                $totalITotalReg += $totalIFinalReg;
                $totalIPTotalReg += $totalIPFinalReg;
                $totalIXTotalReg += $totalIXFinalReg;
                $totalCTTotalReg += $totalCTFinalReg;
                $totalCHTotalReg += $totalCHFinalReg;
                $totalCBTotalReg += $totalCBFinalReg;
                $totalCLTotalReg += $totalCLFinalReg;

                $flAtt1 = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinal = $flAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFl = $flAtt1->sum('hadir');
                $totalTAFinalFl = $flAtt1->sum('ta');
                $totalDFinalFl = $flAtt1->sum('d');
                $totalLFinalFl = $flAtt1->sum('l');
                $totalMFinalFl = $flAtt1->sum('m');
                $totalMXFinalFl = $flAtt1->sum('mx');
                $totalSFinalFl = $flAtt1->sum('s');
                $totalSXFinalFl = $flAtt1->sum('sx');
                $totalIFinalFl = $flAtt1->sum('i');
                $totalIPFinalFl = $flAtt1->sum('ip');
                $totalIXFinalFl = $flAtt1->sum('ix');
                $totalCTFinalFl = $flAtt1->sum('ct');
                $totalCHFinalFl = $flAtt1->sum('ch');
                $totalCBFinalFl = $flAtt1->sum('cb');
                $totalCLFinalFl = $flAtt1->sum('cl');

                $totalHTotalFl += $totalHFinalFl;
                $totalTATotalFl += $totalTAFinalFl;
                $totalDTotalFl += $totalDFinalFl;
                $totalLTotalFl += $totalLFinalFl;
                $totalMTotalFl += $totalMFinalFl;
                $totalMXTotalFl += $totalMXFinalFl;
                $totalSTotalFl += $totalSFinalFl;
                $totalSXTotalFl += $totalSXFinalFl;
                $totalITotalFl += $totalIFinalFl;
                $totalIPTotalFl += $totalIPFinalFl;
                $totalIXTotalFl += $totalIXFinalFl;
                $totalCTTotalFl += $totalCTFinalFl;
                $totalCHTotalFl += $totalCHFinalFl;
                $totalCBTotalFl += $totalCBFinalFl;
                $totalCLTotalFl += $totalCLFinalFl;

                $item = [
                    'mandor' => $mandor->nik,
                    'mandorName' => $mandorName,
                    'regularTotal1' => $regularTotal1,
                    'flTotal1' => $flTotal1,
                    'totalHFinalReg' => $totalHFinalReg,
                    'totalTAFinalReg' => $totalTAFinalReg,
                    'totalDFinalReg' => $totalDFinalReg,
                    'totalLFinalReg' => $totalLFinalReg,
                    'totalMFinalReg' => $totalMFinalReg,
                    'totalMXFinalReg' => $totalMXFinalReg,
                    'totalSFinalReg' => $totalSFinalReg,
                    'totalSXFinalReg' => $totalSXFinalReg,
                    'totalIFinalReg' => $totalIFinalReg,
                    'totalIPFinalReg' => $totalIPFinalReg,
                    'totalIXFinalReg' => $totalIXFinalReg,
                    'totalCTFinalReg' => $totalCTFinalReg,
                    'totalCHFinalReg' => $totalCHFinalReg,
                    'totalCBFinalReg' => $totalCBFinalReg,
                    'totalCLFinalReg' => $totalCLFinalReg,
                    'totalHFinalFl' => $totalHFinalFl,
                    'totalTAFinalFl' => $totalTAFinalFl,
                    'totalDFinalFl' => $totalDFinalFl,
                    'totalLFinalFl' => $totalLFinalFl,
                    'totalMFinalFl' => $totalMFinalFl,
                    'totalMXFinalFl' => $totalMXFinalFl,
                    'totalSFinalFl' => $totalSFinalFl,
                    'totalSXFinalFl' => $totalSXFinalFl,
                    'totalIFinalFl' => $totalIFinalFl,
                    'totalIPFinalFl' => $totalIPFinalFl,
                    'totalIXFinalFl' => $totalIXFinalFl,
                    'totalCTFinalFl' => $totalCTFinalFl,
                    'totalCHFinalFl' => $totalCHFinalFl,
                    'totalCBFinalFl' => $totalCBFinalFl,
                    'totalCLFinalFl' => $totalCLFinalFl,
                    'date' => $date,
                    'dept' => $dept,
                ];

                $data[] = $item;
            }

            usort($data, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            return view(
                'admin.pages.dashboard-new',
                [
                    'empReg1' => $empReg1,
                    'data' => $data,
                    'date' => $date,
                    'dept' => $dept,
                    'totalRegularTotal1' => $totalRegularTotal1,
                    'totalFlTotal1' => $totalFlTotal1,
                    'totalHTotalReg' => $totalHTotalReg,
                    'totalTATotalReg' => $totalTATotalReg,
                    'totalDTotalReg' => $totalDTotalReg,
                    'totalLTotalReg' => $totalLTotalReg,
                    'totalMTotalReg' => $totalMTotalReg,
                    'totalMXTotalReg' => $totalMXTotalReg,
                    'totalSTotalReg' => $totalSTotalReg,
                    'totalSXTotalReg' => $totalSXTotalReg,
                    'totalITotalReg' => $totalITotalReg,
                    'totalIPTotalReg' => $totalIPTotalReg,
                    'totalIXTotalReg' => $totalIXTotalReg,
                    'totalCTTotalReg' => $totalCTTotalReg,
                    'totalCHTotalReg' => $totalCHTotalReg,
                    'totalCBTotalReg' => $totalCBTotalReg,
                    'totalCLTotalReg' => $totalCLTotalReg,
                    'totalHTotalFl' => $totalHTotalFl,
                    'totalTATotalFl' => $totalTATotalFl,
                    'totalDTotalFl' => $totalDTotalFl,
                    'totalLTotalFl' => $totalLTotalFl,
                    'totalMTotalFl' => $totalMTotalFl,
                    'totalMXTotalFl' => $totalMXTotalFl,
                    'totalSTotalFl' => $totalSTotalFl,
                    'totalSXTotalFl' => $totalSXTotalFl,
                    'totalITotalFl' => $totalITotalFl,
                    'totalIPTotalFl' => $totalIPTotalFl,
                    'totalIXTotalFl' => $totalIXTotalFl,
                    'totalCTTotalFl' => $totalCTTotalFl,
                    'totalCHTotalFl' => $totalCHTotalFl,
                    'totalCBTotalFl' => $totalCBTotalFl,
                    'totalCLTotalFl' => $totalCLTotalFl,
                    'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                ]
            );
        } elseif ($dept == 'BSKP' || $dept == 'HR Legal') {
            // Factory
            $staffAttFac = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Factory')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttFac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'Factory')
                    ->where('users.status', 'Monthly')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttFac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'Factory')
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttFac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'Factory')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttFac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'Factory')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'Factory')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinal = $totalAttFac->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFac = $totalAttFac->sum('hadir');
                $totalTAFinalFac = $totalAttFac->sum('ta');
                $totalDFinalFac = $totalAttFac->sum('d');
                $totalLFinalFac = $totalAttFac->sum('l');
                $totalMFinalFac = $totalAttFac->sum('m');
                $totalMXFinalFac = $totalAttFac->sum('mx');
                $totalSFinalFac = $totalAttFac->sum('s');
                $totalSXFinalFac = $totalAttFac->sum('sx');
                $totalIFinalFac = $totalAttFac->sum('i');
                $totalIPFinalFac = $totalAttFac->sum('ip');
                $totalIXFinalFac = $totalAttFac->sum('ix');
                $totalCTFinalFac = $totalAttFac->sum('ct');
                $totalCHFinalFac = $totalAttFac->sum('ch');
                $totalCBFinalFac = $totalAttFac->sum('cb');
                $totalCLFinalFac = $totalAttFac->sum('cl');

                $staffTotalFac = DB::table('users')
                    ->where('dept', 'Factory')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalFac = DB::table('users')
                    ->where('dept', 'Factory')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalFac = DB::table('users')
                    ->where('dept', 'Factory')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalFac = DB::table('users')
                    ->where('dept', 'Factory')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalFac = DB::table('users')
                    ->where('dept', 'Factory')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttFac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                        DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'Factory')
                    ->whereDate('test_absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hFac = $empAttFac->sum('hadir');
                    $total_lFac = $empAttFac->sum('l');
                    $total_taFac = $empAttFac->sum('ta');
                    $total_dFac = $empAttFac->sum('d');
                    $total_mFac = $empAttFac->sum('m');
                    $total_mxFac = $empAttFac->sum('mx');
                    $total_sFac = $empAttFac->sum('s');
                    $total_sxFac = $empAttFac->sum('sx');
                    $total_iFac = $empAttFac->sum('i');
                    $total_ipFac = $empAttFac->sum('ip');
                    $total_ixFac = $empAttFac->sum('ix');
                    $total_ctFac = $empAttFac->sum('ct');
                    $total_chFac = $empAttFac->sum('ch');
                    $total_cbFac = $empAttFac->sum('cb');
                    $total_clFac = $empAttFac->sum('cl');

            $mandorFac = User::where('dept', 'Factory')
            ->where('jabatan', 'Mandor')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $dataFac = [];

            $totalRegularTotal1Fac = 0;
            $totalFlTotal1Fac = 0;

            $totalHTotalRegFac = 0;
            $totalTATotalRegFac = 0;
            $totalDTotalRegFac = 0;
            $totalLTotalRegFac = 0;
            $totalMTotalRegFac = 0;
            $totalMXTotalRegFac = 0;
            $totalSTotalRegFac = 0;
            $totalSXTotalRegFac = 0;
            $totalITotalRegFac = 0;
            $totalIPTotalRegFac = 0;
            $totalIXTotalRegFac = 0;
            $totalCTTotalRegFac = 0;
            $totalCHTotalRegFac = 0;
            $totalCBTotalRegFac = 0;
            $totalCLTotalRegFac = 0;

            $totalHTotalFlFac = 0;
            $totalTATotalFlFac = 0;
            $totalDTotalFlFac = 0;
            $totalLTotalFlFac = 0;
            $totalMTotalFlFac = 0;
            $totalMXTotalFlFac = 0;
            $totalSTotalFlFac = 0;
            $totalSXTotalFlFac = 0;
            $totalITotalFlFac = 0;
            $totalIPTotalFlFac = 0;
            $totalIXTotalFlFac = 0;
            $totalCTTotalFlFac = 0;
            $totalCHTotalFlFac = 0;
            $totalCBTotalFlFac = 0;
            $totalCLTotalFlFac = 0;

            foreach ($mandorFac as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1Fac = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'Factory')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1Fac += $regularTotal1Fac;

                $flTotal1Fac = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'Factory')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1Fac += $flTotal1Fac;

                $empReg1Fac = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1Fac = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1Fac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->get();

                $totalAttregFinalFac = $regAtt1Fac->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalRegFac = $regAtt1Fac->sum('hadir');
                $totalTAFinalRegFac = $regAtt1Fac->sum('ta');
                $totalDFinalRegFac = $regAtt1Fac->sum('d');
                $totalLFinalRegFac = $regAtt1Fac->sum('l');
                $totalMFinalRegFac = $regAtt1Fac->sum('m');
                $totalMXFinalRegFac = $regAtt1Fac->sum('mx');
                $totalSFinalRegFac = $regAtt1Fac->sum('s');
                $totalSXFinalRegFac = $regAtt1Fac->sum('sx');
                $totalIFinalRegFac = $regAtt1Fac->sum('i');
                $totalIPFinalRegFac = $regAtt1Fac->sum('ip');
                $totalIXFinalRegFac = $regAtt1Fac->sum('ix');
                $totalCTFinalRegFac = $regAtt1Fac->sum('ct');
                $totalCHFinalRegFac = $regAtt1Fac->sum('ch');
                $totalCBFinalRegFac = $regAtt1Fac->sum('cb');
                $totalCLFinalRegFac = $regAtt1Fac->sum('cl');

                $totalHTotalRegFac += $totalHFinalRegFac;
                $totalTATotalRegFac += $totalTAFinalRegFac;
                $totalDTotalRegFac += $totalDFinalRegFac;
                $totalLTotalRegFac += $totalLFinalRegFac;
                $totalMTotalRegFac += $totalMFinalRegFac;
                $totalMXTotalRegFac += $totalMXFinalRegFac;
                $totalSTotalRegFac += $totalSFinalRegFac;
                $totalSXTotalRegFac += $totalSXFinalRegFac;
                $totalITotalRegFac += $totalIFinalRegFac;
                $totalIPTotalRegFac += $totalIPFinalRegFac;
                $totalIXTotalRegFac += $totalIXFinalRegFac;
                $totalCTTotalRegFac += $totalCTFinalRegFac;
                $totalCHTotalRegFac += $totalCHFinalRegFac;
                $totalCBTotalRegFac += $totalCBFinalRegFac;
                $totalCLTotalRegFac += $totalCLFinalRegFac;

                $flAtt1Fac = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinalFac = $flAtt1Fac->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFlFac = $flAtt1Fac->sum('hadir');
                $totalTAFinalFlFac = $flAtt1Fac->sum('ta');
                $totalDFinalFlFac = $flAtt1Fac->sum('d');
                $totalLFinalFlFac = $flAtt1Fac->sum('l');
                $totalMFinalFlFac = $flAtt1Fac->sum('m');
                $totalMXFinalFlFac = $flAtt1Fac->sum('mx');
                $totalSFinalFlFac = $flAtt1Fac->sum('s');
                $totalSXFinalFlFac = $flAtt1Fac->sum('sx');
                $totalIFinalFlFac = $flAtt1Fac->sum('i');
                $totalIPFinalFlFac = $flAtt1Fac->sum('ip');
                $totalIXFinalFlFac = $flAtt1Fac->sum('ix');
                $totalCTFinalFlFac = $flAtt1Fac->sum('ct');
                $totalCHFinalFlFac = $flAtt1Fac->sum('ch');
                $totalCBFinalFlFac = $flAtt1Fac->sum('cb');
                $totalCLFinalFlFac = $flAtt1Fac->sum('cl');

                $totalHTotalFlFac += $totalHFinalFlFac;
                $totalTATotalFlFac += $totalTAFinalFlFac;
                $totalDTotalFlFac += $totalDFinalFlFac;
                $totalLTotalFlFac += $totalLFinalFlFac;
                $totalMTotalFlFac += $totalMFinalFlFac;
                $totalMXTotalFlFac += $totalMXFinalFlFac;
                $totalSTotalFlFac += $totalSFinalFlFac;
                $totalSXTotalFlFac += $totalSXFinalFlFac;
                $totalITotalFlFac += $totalIFinalFlFac;
                $totalIPTotalFlFac += $totalIPFinalFlFac;
                $totalIXTotalFlFac += $totalIXFinalFlFac;
                $totalCTTotalFlFac += $totalCTFinalFlFac;
                $totalCHTotalFlFac += $totalCHFinalFlFac;
                $totalCBTotalFlFac += $totalCBFinalFlFac;
                $totalCLTotalFlFac += $totalCLFinalFlFac;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1Fac' => $regularTotal1Fac,
                    'flTotal1Fac' => $flTotal1Fac,
                    'totalHFinalRegFac' => $totalHFinalRegFac,
                    'totalTAFinalRegFac' => $totalTAFinalRegFac,
                    'totalDFinalRegFac' => $totalDFinalRegFac,
                    'totalLFinalRegFac' => $totalLFinalRegFac,
                    'totalMFinalRegFac' => $totalMFinalRegFac,
                    'totalMXFinalRegFac' => $totalMXFinalRegFac,
                    'totalSFinalRegFac' => $totalSFinalRegFac,
                    'totalSXFinalRegFac' => $totalSXFinalRegFac,
                    'totalIFinalRegFac' => $totalIFinalRegFac,
                    'totalIPFinalRegFac' => $totalIPFinalRegFac,
                    'totalIXFinalRegFac' => $totalIXFinalRegFac,
                    'totalCTFinalRegFac' => $totalCTFinalRegFac,
                    'totalCHFinalRegFac' => $totalCHFinalRegFac,
                    'totalCBFinalRegFac' => $totalCBFinalRegFac,
                    'totalCLFinalRegFac' => $totalCLFinalRegFac,
                    'totalHFinalFlFac' => $totalHFinalFlFac,
                    'totalTAFinalFlFac' => $totalTAFinalFlFac,
                    'totalDFinalFlFac' => $totalDFinalFlFac,
                    'totalLFinalFlFac' => $totalLFinalFlFac,
                    'totalMFinalFlFac' => $totalMFinalFlFac,
                    'totalMXFinalFlFac' => $totalMXFinalFlFac,
                    'totalSFinalFlFac' => $totalSFinalFlFac,
                    'totalSXFinalFlFac' => $totalSXFinalFlFac,
                    'totalIFinalFlFac' => $totalIFinalFlFac,
                    'totalIPFinalFlFac' => $totalIPFinalFlFac,
                    'totalIXFinalFlFac' => $totalIXFinalFlFac,
                    'totalCTFinalFlFac' => $totalCTFinalFlFac,
                    'totalCHFinalFlFac' => $totalCHFinalFlFac,
                    'totalCBFinalFlFac' => $totalCBFinalFlFac,
                    'totalCLFinalFlFac' => $totalCLFinalFlFac,
                    'staffAttFac' => $staffAttFac,
                    'monAttFac' => $monAttFac,
                    'regAttFac' => $regAttFac,
                    'flAttFac' => $flAttFac,
                    'bskpAttFac' => $bskpAttFac,
                    'staffTotalFac' => $staffTotalFac,
                    'monthlyTotalFac' => $monthlyTotalFac,
                    'regularTotalFac' => $regularTotalFac,
                    'flTotalFac' => $flTotalFac,
                    'bskpTotalFac' => $bskpTotalFac,
                    'totalHFinalFac' => $totalHFinalFac,
                    'totalTAFinalFac' => $totalTAFinalFac,
                    'totalDFinalFac' => $totalDFinalFac,
                    'totalLFinalFac' => $totalLFinalFac,
                    'totalMFinalFac' => $totalMFinalFac,
                    'totalMXFinalFac' => $totalMXFinalFac,
                    'totalSFinalFac' => $totalSFinalFac,
                    'totalSXFinalFac' => $totalSXFinalFac,
                    'totalIFinalFac' => $totalIFinalFac,
                    'totalIPFinalFac' => $totalIPFinalFac,
                    'totalIXFinalFac' => $totalIXFinalFac,
                    'totalCTFinalFac' => $totalCTFinalFac,
                    'totalCHFinalFac' => $totalCHFinalFac,
                    'totalCBFinalFac' => $totalCBFinalFac,
                    'totalCLFinalFac' => $totalCLFinalFac,
                ];

                $dataFac[] = $item;
            }

            usort($dataFac, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            // II/F
            $staffAttF = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'II/F')
                ->where('users.status', 'Staff')
                ->whereDate('absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttF = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/F')
                    ->where('users.status', 'Monthly')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttF = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/F')
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttF = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/F')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttF = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/F')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttF = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/F')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinalF = $totalAttF->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalF = $totalAttF->sum('h');
                $totalTAFinalF = $totalAttF->sum('ta');
                $totalDFinalF = $totalAttF->sum('d');
                $totalLFinalF = $totalAttF->sum('l');
                $totalMFinalF = $totalAttF->sum('m');
                $totalMXFinalF = $totalAttF->sum('mx');
                $totalSFinalF = $totalAttF->sum('s');
                $totalSXFinalF = $totalAttF->sum('sx');
                $totalIFinalF = $totalAttF->sum('i');
                $totalIPFinalF = $totalAttF->sum('ip');
                $totalIXFinalF = $totalAttF->sum('ix');
                $totalCTFinalF = $totalAttF->sum('ct');
                $totalCHFinalF = $totalAttF->sum('ch');
                $totalCBFinalF = $totalAttF->sum('cb');
                $totalCLFinalF = $totalAttF->sum('cl');

                $staffTotalF = DB::table('users')
                    ->where('dept', 'II/F')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalF = DB::table('users')
                    ->where('dept', 'II/F')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalF = DB::table('users')
                    ->where('dept', 'II/F')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalF = DB::table('users')
                    ->where('dept', 'II/F')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalF = DB::table('users')
                    ->where('dept', 'II/F')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttF = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(absen_regs.desc = 'CL') as cl"),
                        // DB::raw("SUM(absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/F')
                    ->whereDate('absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hF = $empAttF->sum('h');
                    $total_lF = $empAttF->sum('l');
                    $total_taF = $empAttF->sum('ta');
                    $total_dF = $empAttF->sum('d');
                    $total_mF = $empAttF->sum('m');
                    $total_mxF = $empAttF->sum('mx');
                    $total_sF = $empAttF->sum('s');
                    $total_sxF = $empAttF->sum('sx');
                    $total_iF = $empAttF->sum('i');
                    $total_ipF = $empAttF->sum('ip');
                    $total_ixF = $empAttF->sum('ix');
                    $total_ctF = $empAttF->sum('ct');
                    $total_chF = $empAttF->sum('ch');
                    $total_cbF = $empAttF->sum('cb');
                    $total_clF = $empAttF->sum('cl');

            $mandorF = User::where('dept', 'II/F')
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $dataF = [];

            $totalRegularTotal1F = 0;
            $totalFlTotal1F = 0;

            $totalHTotalRegF = 0;
            $totalTATotalRegF = 0;
            $totalDTotalRegF = 0;
            $totalLTotalRegF = 0;
            $totalMTotalRegF = 0;
            $totalMXTotalRegF = 0;
            $totalSTotalRegF = 0;
            $totalSXTotalRegF = 0;
            $totalITotalRegF = 0;
            $totalIPTotalRegF = 0;
            $totalIXTotalRegF = 0;
            $totalCTTotalRegF = 0;
            $totalCHTotalRegF = 0;
            $totalCBTotalRegF = 0;
            $totalCLTotalRegF = 0;

            $totalHTotalFlF = 0;
            $totalTATotalFlF = 0;
            $totalDTotalFlF = 0;
            $totalLTotalFlF = 0;
            $totalMTotalFlF = 0;
            $totalMXTotalFlF = 0;
            $totalSTotalFlF = 0;
            $totalSXTotalFlF = 0;
            $totalITotalFlF = 0;
            $totalIPTotalFlF = 0;
            $totalIXTotalFlF = 0;
            $totalCTTotalFlF = 0;
            $totalCHTotalFlF = 0;
            $totalCBTotalFlF = 0;
            $totalCLTotalFlF = 0;

            foreach ($mandorF as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1F = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'II/F')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1F += $regularTotal1F;

                $flTotal1F = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'II/F')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1F += $flTotal1F;

                $empReg1F = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1F = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1F = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->get();

                $totalAttregFinalF = $regAtt1F->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalRegF = $regAtt1F->sum('h');
                $totalTAFinalRegF = $regAtt1F->sum('ta');
                $totalDFinalRegF = $regAtt1F->sum('d');
                $totalLFinalRegF = $regAtt1F->sum('l');
                $totalMFinalRegF = $regAtt1F->sum('m');
                $totalMXFinalRegF = $regAtt1F->sum('mx');
                $totalSFinalRegF = $regAtt1F->sum('s');
                $totalSXFinalRegF = $regAtt1F->sum('sx');
                $totalIFinalRegF = $regAtt1F->sum('i');
                $totalIPFinalRegF = $regAtt1F->sum('ip');
                $totalIXFinalRegF = $regAtt1F->sum('ix');
                $totalCTFinalRegF = $regAtt1F->sum('ct');
                $totalCHFinalRegF = $regAtt1F->sum('ch');
                $totalCBFinalRegF = $regAtt1F->sum('cb');
                $totalCLFinalRegF = $regAtt1F->sum('cl');

                $totalHTotalRegF += $totalHFinalRegF;
                $totalTATotalRegF += $totalTAFinalRegF;
                $totalDTotalRegF += $totalDFinalRegF;
                $totalLTotalRegF += $totalLFinalRegF;
                $totalMTotalRegF += $totalMFinalRegF;
                $totalMXTotalRegF += $totalMXFinalRegF;
                $totalSTotalRegF += $totalSFinalRegF;
                $totalSXTotalRegF += $totalSXFinalRegF;
                $totalITotalRegF += $totalIFinalRegF;
                $totalIPTotalRegF += $totalIPFinalRegF;
                $totalIXTotalRegF += $totalIXFinalRegF;
                $totalCTTotalRegF += $totalCTFinalRegF;
                $totalCHTotalRegF += $totalCHFinalRegF;
                $totalCBTotalRegF += $totalCBFinalRegF;
                $totalCLTotalRegF += $totalCLFinalRegF;

                $flAtt1F = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinalF = $flAtt1F->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFlF = $flAtt1F->sum('h');
                $totalTAFinalFlF = $flAtt1F->sum('ta');
                $totalDFinalFlF = $flAtt1F->sum('d');
                $totalLFinalFlF = $flAtt1F->sum('l');
                $totalMFinalFlF = $flAtt1F->sum('m');
                $totalMXFinalFlF = $flAtt1F->sum('mx');
                $totalSFinalFlF = $flAtt1F->sum('s');
                $totalSXFinalFlF = $flAtt1F->sum('sx');
                $totalIFinalFlF = $flAtt1F->sum('i');
                $totalIPFinalFlF = $flAtt1F->sum('ip');
                $totalIXFinalFlF = $flAtt1F->sum('ix');
                $totalCTFinalFlF = $flAtt1F->sum('ct');
                $totalCHFinalFlF = $flAtt1F->sum('ch');
                $totalCBFinalFlF = $flAtt1F->sum('cb');
                $totalCLFinalFlF = $flAtt1F->sum('cl');

                $totalHTotalFlF += $totalHFinalFlF;
                $totalTATotalFlF += $totalTAFinalFlF;
                $totalDTotalFlF += $totalDFinalFlF;
                $totalLTotalFlF += $totalLFinalFlF;
                $totalMTotalFlF += $totalMFinalFlF;
                $totalMXTotalFlF += $totalMXFinalFlF;
                $totalSTotalFlF += $totalSFinalFlF;
                $totalSXTotalFlF += $totalSXFinalFlF;
                $totalITotalFlF += $totalIFinalFlF;
                $totalIPTotalFlF += $totalIPFinalFlF;
                $totalIXTotalFlF += $totalIXFinalFlF;
                $totalCTTotalFlF += $totalCTFinalFlF;
                $totalCHTotalFlF += $totalCHFinalFlF;
                $totalCBTotalFlF += $totalCBFinalFlF;
                $totalCLTotalFlF += $totalCLFinalFlF;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1F' => $regularTotal1F,
                    'flTotal1F' => $flTotal1F,
                    'totalHFinalRegF' => $totalHFinalRegF,
                    'totalTAFinalRegF' => $totalTAFinalRegF,
                    'totalDFinalRegF' => $totalDFinalRegF,
                    'totalLFinalRegF' => $totalLFinalRegF,
                    'totalMFinalRegF' => $totalMFinalRegF,
                    'totalMXFinalRegF' => $totalMXFinalRegF,
                    'totalSFinalRegF' => $totalSFinalRegF,
                    'totalSXFinalRegF' => $totalSXFinalRegF,
                    'totalIFinalRegF' => $totalIFinalRegF,
                    'totalIPFinalRegF' => $totalIPFinalRegF,
                    'totalIXFinalRegF' => $totalIXFinalRegF,
                    'totalCTFinalRegF' => $totalCTFinalRegF,
                    'totalCHFinalRegF' => $totalCHFinalRegF,
                    'totalCBFinalRegF' => $totalCBFinalRegF,
                    'totalCLFinalRegF' => $totalCLFinalRegF,
                    'totalHFinalFlF' => $totalHFinalFlF,
                    'totalTAFinalFlF' => $totalTAFinalFlF,
                    'totalDFinalFlF' => $totalDFinalFlF,
                    'totalLFinalFlF' => $totalLFinalFlF,
                    'totalMFinalFlF' => $totalMFinalFlF,
                    'totalMXFinalFlF' => $totalMXFinalFlF,
                    'totalSFinalFlF' => $totalSFinalFlF,
                    'totalSXFinalFlF' => $totalSXFinalFlF,
                    'totalIFinalFlF' => $totalIFinalFlF,
                    'totalIPFinalFlF' => $totalIPFinalFlF,
                    'totalIXFinalFlF' => $totalIXFinalFlF,
                    'totalCTFinalFlF' => $totalCTFinalFlF,
                    'totalCHFinalFlF' => $totalCHFinalFlF,
                    'totalCBFinalFlF' => $totalCBFinalFlF,
                    'totalCLFinalFlF' => $totalCLFinalFlF,
                    'staffAttF' => $staffAttF,
                    'monAttF' => $monAttF,
                    'regAttF' => $regAttF,
                    'flAttF' => $flAttF,
                    'bskpAttF' => $bskpAttF,
                    'staffTotalF' => $staffTotalF,
                    'monthlyTotalF' => $monthlyTotalF,
                    'regularTotalF' => $regularTotalF,
                    'flTotalF' => $flTotalF,
                    'bskpTotalF' => $bskpTotalF,
                    'totalHFinalF' => $totalHFinalF,
                    'totalTAFinalF' => $totalTAFinalF,
                    'totalDFinalF' => $totalDFinalF,
                    'totalLFinalF' => $totalLFinalF,
                    'totalMFinalF' => $totalMFinalF,
                    'totalMXFinalF' => $totalMXFinalF,
                    'totalSFinalF' => $totalSFinalF,
                    'totalSXFinalF' => $totalSXFinalF,
                    'totalIFinalF' => $totalIFinalF,
                    'totalIPFinalF' => $totalIPFinalF,
                    'totalIXFinalF' => $totalIXFinalF,
                    'totalCTFinalF' => $totalCTFinalF,
                    'totalCHFinalF' => $totalCHFinalF,
                    'totalCBFinalF' => $totalCBFinalF,
                    'totalCLFinalF' => $totalCLFinalF,
                ];

                $dataF[] = $item;
            }

            usort($dataF, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            // II/F
            $staffAttE = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'II/E')
                ->where('users.status', 'Staff')
                ->whereDate('absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttE = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/E')
                    ->where('users.status', 'Monthly')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttE = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/E')
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttE = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/E')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttE = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/E')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttE = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/E')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinalE = $totalAttE->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalE = $totalAttE->sum('h');
                $totalTAFinalE = $totalAttE->sum('ta');
                $totalDFinalE = $totalAttE->sum('d');
                $totalLFinalE = $totalAttE->sum('l');
                $totalMFinalE = $totalAttE->sum('m');
                $totalMXFinalE = $totalAttE->sum('mx');
                $totalSFinalE = $totalAttE->sum('s');
                $totalSXFinalE = $totalAttE->sum('sx');
                $totalIFinalE = $totalAttE->sum('i');
                $totalIPFinalE = $totalAttE->sum('ip');
                $totalIXFinalE = $totalAttE->sum('ix');
                $totalCTFinalE = $totalAttE->sum('ct');
                $totalCHFinalE = $totalAttE->sum('ch');
                $totalCBFinalE = $totalAttE->sum('cb');
                $totalCLFinalE = $totalAttE->sum('cl');

                $staffTotalE = DB::table('users')
                    ->where('dept', 'II/E')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalE = DB::table('users')
                    ->where('dept', 'II/E')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalE = DB::table('users')
                    ->where('dept', 'II/E')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalE = DB::table('users')
                    ->where('dept', 'II/E')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalE = DB::table('users')
                    ->where('dept', 'II/E')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttE = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(absen_regs.desc = 'CL') as cl"),
                        // DB::raw("SUM(absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/E')
                    ->whereDate('absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hE = $empAttE->sum('h');
                    $total_lE = $empAttE->sum('l');
                    $total_taE = $empAttE->sum('ta');
                    $total_dE = $empAttE->sum('d');
                    $total_mE = $empAttE->sum('m');
                    $total_mxE = $empAttE->sum('mx');
                    $total_sE = $empAttE->sum('s');
                    $total_sxE = $empAttE->sum('sx');
                    $total_iE = $empAttE->sum('i');
                    $total_ipE = $empAttE->sum('ip');
                    $total_ixE = $empAttE->sum('ix');
                    $total_ctE = $empAttE->sum('ct');
                    $total_chE = $empAttE->sum('ch');
                    $total_cbE = $empAttE->sum('cb');
                    $total_clE = $empAttE->sum('cl');

            $mandorE = User::where('dept', 'II/E')
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $dataE = [];

            $totalRegularTotal1E = 0;
            $totalFlTotal1E = 0;

            $totalHTotalRegE = 0;
            $totalTATotalRegE = 0;
            $totalDTotalRegE = 0;
            $totalLTotalRegE = 0;
            $totalMTotalRegE = 0;
            $totalMXTotalRegE = 0;
            $totalSTotalRegE = 0;
            $totalSXTotalRegE = 0;
            $totalITotalRegE = 0;
            $totalIPTotalRegE = 0;
            $totalIXTotalRegE = 0;
            $totalCTTotalRegE = 0;
            $totalCHTotalRegE = 0;
            $totalCBTotalRegE = 0;
            $totalCLTotalRegE = 0;

            $totalHTotalFlE = 0;
            $totalTATotalFlE = 0;
            $totalDTotalFlE = 0;
            $totalLTotalFlE = 0;
            $totalMTotalFlE = 0;
            $totalMXTotalFlE = 0;
            $totalSTotalFlE = 0;
            $totalSXTotalFlE = 0;
            $totalITotalFlE = 0;
            $totalIPTotalFlE = 0;
            $totalIXTotalFlE = 0;
            $totalCTTotalFlE = 0;
            $totalCHTotalFlE = 0;
            $totalCBTotalFlE = 0;
            $totalCLTotalFlE = 0;

            foreach ($mandorE as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1E = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'II/E')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1E += $regularTotal1E;

                $flTotal1E = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'II/E')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1E += $flTotal1E;

                $empReg1E = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1E = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1E = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->get();

                $totalAttregFinalE = $regAtt1E->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalRegE = $regAtt1E->sum('h');
                $totalTAFinalRegE = $regAtt1E->sum('ta');
                $totalDFinalRegE = $regAtt1E->sum('d');
                $totalLFinalRegE = $regAtt1E->sum('l');
                $totalMFinalRegE = $regAtt1E->sum('m');
                $totalMXFinalRegE = $regAtt1E->sum('mx');
                $totalSFinalRegE = $regAtt1E->sum('s');
                $totalSXFinalRegE = $regAtt1E->sum('sx');
                $totalIFinalRegE = $regAtt1E->sum('i');
                $totalIPFinalRegE = $regAtt1E->sum('ip');
                $totalIXFinalRegE = $regAtt1E->sum('ix');
                $totalCTFinalRegE = $regAtt1E->sum('ct');
                $totalCHFinalRegE = $regAtt1E->sum('ch');
                $totalCBFinalRegE = $regAtt1E->sum('cb');
                $totalCLFinalRegE = $regAtt1E->sum('cl');

                $totalHTotalRegE += $totalHFinalRegE;
                $totalTATotalRegE += $totalTAFinalRegE;
                $totalDTotalRegE += $totalDFinalRegE;
                $totalLTotalRegE += $totalLFinalRegE;
                $totalMTotalRegE += $totalMFinalRegE;
                $totalMXTotalRegE += $totalMXFinalRegE;
                $totalSTotalRegE += $totalSFinalRegE;
                $totalSXTotalRegE += $totalSXFinalRegE;
                $totalITotalRegE += $totalIFinalRegE;
                $totalIPTotalRegE += $totalIPFinalRegE;
                $totalIXTotalRegE += $totalIXFinalRegE;
                $totalCTTotalRegE += $totalCTFinalRegE;
                $totalCHTotalRegE += $totalCHFinalRegE;
                $totalCBTotalRegE += $totalCBFinalRegE;
                $totalCLTotalRegE += $totalCLFinalRegE;

                $flAtt1E = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinalE = $flAtt1E->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFlE = $flAtt1E->sum('h');
                $totalTAFinalFlE = $flAtt1E->sum('ta');
                $totalDFinalFlE = $flAtt1E->sum('d');
                $totalLFinalFlE = $flAtt1E->sum('l');
                $totalMFinalFlE = $flAtt1E->sum('m');
                $totalMXFinalFlE = $flAtt1E->sum('mx');
                $totalSFinalFlE = $flAtt1E->sum('s');
                $totalSXFinalFlE = $flAtt1E->sum('sx');
                $totalIFinalFlE = $flAtt1E->sum('i');
                $totalIPFinalFlE = $flAtt1E->sum('ip');
                $totalIXFinalFlE = $flAtt1E->sum('ix');
                $totalCTFinalFlE = $flAtt1E->sum('ct');
                $totalCHFinalFlE = $flAtt1E->sum('ch');
                $totalCBFinalFlE = $flAtt1E->sum('cb');
                $totalCLFinalFlE = $flAtt1E->sum('cl');

                $totalHTotalFlE += $totalHFinalFlE;
                $totalTATotalFlE += $totalTAFinalFlE;
                $totalDTotalFlE += $totalDFinalFlE;
                $totalLTotalFlE += $totalLFinalFlE;
                $totalMTotalFlE += $totalMFinalFlE;
                $totalMXTotalFlE += $totalMXFinalFlE;
                $totalSTotalFlE += $totalSFinalFlE;
                $totalSXTotalFlE += $totalSXFinalFlE;
                $totalITotalFlE += $totalIFinalFlE;
                $totalIPTotalFlE += $totalIPFinalFlE;
                $totalIXTotalFlE += $totalIXFinalFlE;
                $totalCTTotalFlE += $totalCTFinalFlE;
                $totalCHTotalFlE += $totalCHFinalFlE;
                $totalCBTotalFlE += $totalCBFinalFlE;
                $totalCLTotalFlE += $totalCLFinalFlE;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1E' => $regularTotal1E,
                    'flTotal1E' => $flTotal1E,
                    'totalHFinalRegE' => $totalHFinalRegE,
                    'totalTAFinalRegE' => $totalTAFinalRegE,
                    'totalDFinalRegE' => $totalDFinalRegE,
                    'totalLFinalRegE' => $totalLFinalRegE,
                    'totalMFinalRegE' => $totalMFinalRegE,
                    'totalMXFinalRegE' => $totalMXFinalRegE,
                    'totalSFinalRegE' => $totalSFinalRegE,
                    'totalSXFinalRegE' => $totalSXFinalRegE,
                    'totalIFinalRegE' => $totalIFinalRegE,
                    'totalIPFinalRegE' => $totalIPFinalRegE,
                    'totalIXFinalRegE' => $totalIXFinalRegE,
                    'totalCTFinalRegE' => $totalCTFinalRegE,
                    'totalCHFinalRegE' => $totalCHFinalRegE,
                    'totalCBFinalRegE' => $totalCBFinalRegE,
                    'totalCLFinalRegE' => $totalCLFinalRegE,
                    'totalHFinalFlE' => $totalHFinalFlE,
                    'totalTAFinalFlE' => $totalTAFinalFlE,
                    'totalDFinalFlE' => $totalDFinalFlE,
                    'totalLFinalFlE' => $totalLFinalFlE,
                    'totalMFinalFlE' => $totalMFinalFlE,
                    'totalMXFinalFlE' => $totalMXFinalFlE,
                    'totalSFinalFlE' => $totalSFinalFlE,
                    'totalSXFinalFlE' => $totalSXFinalFlE,
                    'totalIFinalFlE' => $totalIFinalFlE,
                    'totalIPFinalFlE' => $totalIPFinalFlE,
                    'totalIXFinalFlE' => $totalIXFinalFlE,
                    'totalCTFinalFlE' => $totalCTFinalFlE,
                    'totalCHFinalFlE' => $totalCHFinalFlE,
                    'totalCBFinalFlE' => $totalCBFinalFlE,
                    'totalCLFinalFlE' => $totalCLFinalFlE,
                    'staffAttE' => $staffAttE,
                    'monAttE' => $monAttE,
                    'regAttE' => $regAttE,
                    'flAttE' => $flAttE,
                    'bskpAttE' => $bskpAttE,
                    'staffTotalE' => $staffTotalE,
                    'monthlyTotalE' => $monthlyTotalE,
                    'regularTotalE' => $regularTotalE,
                    'flTotalE' => $flTotalE,
                    'bskpTotalE' => $bskpTotalE,
                    'totalHFinalE' => $totalHFinalE,
                    'totalTAFinalE' => $totalTAFinalE,
                    'totalDFinalE' => $totalDFinalE,
                    'totalLFinalE' => $totalLFinalE,
                    'totalMFinalE' => $totalMFinalE,
                    'totalMXFinalE' => $totalMXFinalE,
                    'totalSFinalE' => $totalSFinalE,
                    'totalSXFinalE' => $totalSXFinalE,
                    'totalIFinalE' => $totalIFinalE,
                    'totalIPFinalE' => $totalIPFinalE,
                    'totalIXFinalE' => $totalIXFinalE,
                    'totalCTFinalE' => $totalCTFinalE,
                    'totalCHFinalE' => $totalCHFinalE,
                    'totalCBFinalE' => $totalCBFinalE,
                    'totalCLFinalE' => $totalCLFinalE,
                ];

                $dataE[] = $item;
            }

            usort($dataE, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            // I/C
            $staffAttC = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'I/C')
                ->where('users.status', 'Staff')
                ->whereDate('absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttC = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/C')
                    ->where('users.status', 'Monthly')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttC = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/C')
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttC = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/C')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttC = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/C')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttC = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/C')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinalC = $totalAttC->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalC = $totalAttC->sum('h');
                $totalTAFinalC = $totalAttC->sum('ta');
                $totalDFinalC = $totalAttC->sum('d');
                $totalLFinalC = $totalAttC->sum('l');
                $totalMFinalC = $totalAttC->sum('m');
                $totalMXFinalC = $totalAttC->sum('mx');
                $totalSFinalC = $totalAttC->sum('s');
                $totalSXFinalC = $totalAttC->sum('sx');
                $totalIFinalC = $totalAttC->sum('i');
                $totalIPFinalC = $totalAttC->sum('ip');
                $totalIXFinalC = $totalAttC->sum('ix');
                $totalCTFinalC = $totalAttC->sum('ct');
                $totalCHFinalC = $totalAttC->sum('ch');
                $totalCBFinalC = $totalAttC->sum('cb');
                $totalCLFinalC = $totalAttC->sum('cl');

                $staffTotalC = DB::table('users')
                    ->where('dept', 'I/C')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalC = DB::table('users')
                    ->where('dept', 'I/C')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalC = DB::table('users')
                    ->where('dept', 'I/C')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalC = DB::table('users')
                    ->where('dept', 'I/C')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalC = DB::table('users')
                    ->where('dept', 'I/C')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttC = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(absen_regs.desc = 'CL') as cl"),
                        // DB::raw("SUM(absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/C')
                    ->whereDate('absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hC = $empAttC->sum('h');
                    $total_lC = $empAttC->sum('l');
                    $total_taC = $empAttC->sum('ta');
                    $total_dC = $empAttC->sum('d');
                    $total_mC = $empAttC->sum('m');
                    $total_mxC = $empAttC->sum('mx');
                    $total_sC = $empAttC->sum('s');
                    $total_sxC = $empAttC->sum('sx');
                    $total_iC = $empAttC->sum('i');
                    $total_ipC = $empAttC->sum('ip');
                    $total_ixC = $empAttC->sum('ix');
                    $total_ctC = $empAttC->sum('ct');
                    $total_chC = $empAttC->sum('ch');
                    $total_cbC = $empAttC->sum('cb');
                    $total_clC = $empAttC->sum('cl');

            $mandorC = User::where('dept', 'I/C')
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $dataC = [];

            $totalRegularTotal1C = 0;
            $totalFlTotal1C = 0;

            $totalHTotalRegC = 0;
            $totalTATotalRegC = 0;
            $totalDTotalRegC = 0;
            $totalLTotalRegC = 0;
            $totalMTotalRegC = 0;
            $totalMXTotalRegC = 0;
            $totalSTotalRegC = 0;
            $totalSXTotalRegC = 0;
            $totalITotalRegC = 0;
            $totalIPTotalRegC = 0;
            $totalIXTotalRegC = 0;
            $totalCTTotalRegC = 0;
            $totalCHTotalRegC = 0;
            $totalCBTotalRegC = 0;
            $totalCLTotalRegC = 0;

            $totalHTotalFlC = 0;
            $totalTATotalFlC = 0;
            $totalDTotalFlC = 0;
            $totalLTotalFlC = 0;
            $totalMTotalFlC = 0;
            $totalMXTotalFlC = 0;
            $totalSTotalFlC = 0;
            $totalSXTotalFlC = 0;
            $totalITotalFlC = 0;
            $totalIPTotalFlC = 0;
            $totalIXTotalFlC = 0;
            $totalCTTotalFlC = 0;
            $totalCHTotalFlC = 0;
            $totalCBTotalFlC = 0;
            $totalCLTotalFlC = 0;

            foreach ($mandorC as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1C = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'I/C')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1C += $regularTotal1C;

                $flTotal1C = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'I/C')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1C += $flTotal1C;

                $empReg1C = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1C = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1C = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->get();

                $totalAttregFinalC = $regAtt1C->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalRegC = $regAtt1C->sum('h');
                $totalTAFinalRegC = $regAtt1C->sum('ta');
                $totalDFinalRegC = $regAtt1C->sum('d');
                $totalLFinalRegC = $regAtt1C->sum('l');
                $totalMFinalRegC = $regAtt1C->sum('m');
                $totalMXFinalRegC = $regAtt1C->sum('mx');
                $totalSFinalRegC = $regAtt1C->sum('s');
                $totalSXFinalRegC = $regAtt1C->sum('sx');
                $totalIFinalRegC = $regAtt1C->sum('i');
                $totalIPFinalRegC = $regAtt1C->sum('ip');
                $totalIXFinalRegC = $regAtt1C->sum('ix');
                $totalCTFinalRegC = $regAtt1C->sum('ct');
                $totalCHFinalRegC = $regAtt1C->sum('ch');
                $totalCBFinalRegC = $regAtt1C->sum('cb');
                $totalCLFinalRegC = $regAtt1C->sum('cl');

                $totalHTotalRegC += $totalHFinalRegC;
                $totalTATotalRegC += $totalTAFinalRegC;
                $totalDTotalRegC += $totalDFinalRegC;
                $totalLTotalRegC += $totalLFinalRegC;
                $totalMTotalRegC += $totalMFinalRegC;
                $totalMXTotalRegC += $totalMXFinalRegC;
                $totalSTotalRegC += $totalSFinalRegC;
                $totalSXTotalRegC += $totalSXFinalRegC;
                $totalITotalRegC += $totalIFinalRegC;
                $totalIPTotalRegC += $totalIPFinalRegC;
                $totalIXTotalRegC += $totalIXFinalRegC;
                $totalCTTotalRegC += $totalCTFinalRegC;
                $totalCHTotalRegC += $totalCHFinalRegC;
                $totalCBTotalRegC += $totalCBFinalRegC;
                $totalCLTotalRegC += $totalCLFinalRegC;

                $flAtt1C = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinalC = $flAtt1C->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFlC = $flAtt1C->sum('h');
                $totalTAFinalFlC = $flAtt1C->sum('ta');
                $totalDFinalFlC = $flAtt1C->sum('d');
                $totalLFinalFlC = $flAtt1C->sum('l');
                $totalMFinalFlC = $flAtt1C->sum('m');
                $totalMXFinalFlC = $flAtt1C->sum('mx');
                $totalSFinalFlC = $flAtt1C->sum('s');
                $totalSXFinalFlC = $flAtt1C->sum('sx');
                $totalIFinalFlC = $flAtt1C->sum('i');
                $totalIPFinalFlC = $flAtt1C->sum('ip');
                $totalIXFinalFlC = $flAtt1C->sum('ix');
                $totalCTFinalFlC = $flAtt1C->sum('ct');
                $totalCHFinalFlC = $flAtt1C->sum('ch');
                $totalCBFinalFlC = $flAtt1C->sum('cb');
                $totalCLFinalFlC = $flAtt1C->sum('cl');

                $totalHTotalFlC += $totalHFinalFlC;
                $totalTATotalFlC += $totalTAFinalFlC;
                $totalDTotalFlC += $totalDFinalFlC;
                $totalLTotalFlC += $totalLFinalFlC;
                $totalMTotalFlC += $totalMFinalFlC;
                $totalMXTotalFlC += $totalMXFinalFlC;
                $totalSTotalFlC += $totalSFinalFlC;
                $totalSXTotalFlC += $totalSXFinalFlC;
                $totalITotalFlC += $totalIFinalFlC;
                $totalIPTotalFlC += $totalIPFinalFlC;
                $totalIXTotalFlC += $totalIXFinalFlC;
                $totalCTTotalFlC += $totalCTFinalFlC;
                $totalCHTotalFlC += $totalCHFinalFlC;
                $totalCBTotalFlC += $totalCBFinalFlC;
                $totalCLTotalFlC += $totalCLFinalFlC;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1C' => $regularTotal1C,
                    'flTotal1C' => $flTotal1C,
                    'totalHFinalRegC' => $totalHFinalRegC,
                    'totalTAFinalRegC' => $totalTAFinalRegC,
                    'totalDFinalRegC' => $totalDFinalRegC,
                    'totalLFinalRegC' => $totalLFinalRegC,
                    'totalMFinalRegC' => $totalMFinalRegC,
                    'totalMXFinalRegC' => $totalMXFinalRegC,
                    'totalSFinalRegC' => $totalSFinalRegC,
                    'totalSXFinalRegC' => $totalSXFinalRegC,
                    'totalIFinalRegC' => $totalIFinalRegC,
                    'totalIPFinalRegC' => $totalIPFinalRegC,
                    'totalIXFinalRegC' => $totalIXFinalRegC,
                    'totalCTFinalRegC' => $totalCTFinalRegC,
                    'totalCHFinalRegC' => $totalCHFinalRegC,
                    'totalCBFinalRegC' => $totalCBFinalRegC,
                    'totalCLFinalRegC' => $totalCLFinalRegC,
                    'totalHFinalFlC' => $totalHFinalFlC,
                    'totalTAFinalFlC' => $totalTAFinalFlC,
                    'totalDFinalFlC' => $totalDFinalFlC,
                    'totalLFinalFlC' => $totalLFinalFlC,
                    'totalMFinalFlC' => $totalMFinalFlC,
                    'totalMXFinalFlC' => $totalMXFinalFlC,
                    'totalSFinalFlC' => $totalSFinalFlC,
                    'totalSXFinalFlC' => $totalSXFinalFlC,
                    'totalIFinalFlC' => $totalIFinalFlC,
                    'totalIPFinalFlC' => $totalIPFinalFlC,
                    'totalIXFinalFlC' => $totalIXFinalFlC,
                    'totalCTFinalFlC' => $totalCTFinalFlC,
                    'totalCHFinalFlC' => $totalCHFinalFlC,
                    'totalCBFinalFlC' => $totalCBFinalFlC,
                    'totalCLFinalFlC' => $totalCLFinalFlC,
                    'staffAttC' => $staffAttC,
                    'monAttC' => $monAttC,
                    'regAttC' => $regAttC,
                    'flAttC' => $flAttC,
                    'bskpAttC' => $bskpAttC,
                    'staffTotalC' => $staffTotalC,
                    'monthlyTotalC' => $monthlyTotalC,
                    'regularTotalC' => $regularTotalC,
                    'flTotalC' => $flTotalC,
                    'bskpTotalC' => $bskpTotalC,
                    'totalHFinalC' => $totalHFinalC,
                    'totalTAFinalC' => $totalTAFinalC,
                    'totalDFinalC' => $totalDFinalC,
                    'totalLFinalC' => $totalLFinalC,
                    'totalMFinalC' => $totalMFinalC,
                    'totalMXFinalC' => $totalMXFinalC,
                    'totalSFinalC' => $totalSFinalC,
                    'totalSXFinalC' => $totalSXFinalC,
                    'totalIFinalC' => $totalIFinalC,
                    'totalIPFinalC' => $totalIPFinalC,
                    'totalIXFinalC' => $totalIXFinalC,
                    'totalCTFinalC' => $totalCTFinalC,
                    'totalCHFinalC' => $totalCHFinalC,
                    'totalCBFinalC' => $totalCBFinalC,
                    'totalCLFinalC' => $totalCLFinalC,
                ];

                $dataC[] = $item;
            }

            usort($dataC, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            // I/A
            $staffAttA = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'I/A')
                ->where('users.status', 'Staff')
                ->whereDate('absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttA = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/A')
                    ->where('users.status', 'Monthly')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttA = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/A')
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttA = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/A')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttA = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/A')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttA = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/A')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinal = $totalAttA->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalA = $totalAttA->sum('h');
                $totalTAFinalA = $totalAttA->sum('ta');
                $totalDFinalA = $totalAttA->sum('d');
                $totalLFinalA = $totalAttA->sum('l');
                $totalMFinalA = $totalAttA->sum('m');
                $totalMXFinalA = $totalAttA->sum('mx');
                $totalSFinalA = $totalAttA->sum('s');
                $totalSXFinalA = $totalAttA->sum('sx');
                $totalIFinalA = $totalAttA->sum('i');
                $totalIPFinalA = $totalAttA->sum('ip');
                $totalIXFinalA = $totalAttA->sum('ix');
                $totalCTFinalA = $totalAttA->sum('ct');
                $totalCHFinalA = $totalAttA->sum('ch');
                $totalCBFinalA = $totalAttA->sum('cb');
                $totalCLFinalA = $totalAttA->sum('cl');

                $staffTotalA = DB::table('users')
                    ->where('dept', 'I/A')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalA = DB::table('users')
                    ->where('dept', 'I/A')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalA = DB::table('users')
                    ->where('dept', 'I/A')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalA = DB::table('users')
                    ->where('dept', 'I/A')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalA = DB::table('users')
                    ->where('dept', 'I/A')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttA = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(absen_regs.desc = 'CL') as cl"),
                        // DB::raw("SUM(absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/A')
                    ->whereDate('absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hA = $empAttA->sum('h');
                    $total_lA = $empAttA->sum('l');
                    $total_taA = $empAttA->sum('ta');
                    $total_dA = $empAttA->sum('d');
                    $total_mA = $empAttA->sum('m');
                    $total_mxA = $empAttA->sum('mx');
                    $total_sA = $empAttA->sum('s');
                    $total_sxA = $empAttA->sum('sx');
                    $total_iA = $empAttA->sum('i');
                    $total_ipA = $empAttA->sum('ip');
                    $total_ixA = $empAttA->sum('ix');
                    $total_ctA = $empAttA->sum('ct');
                    $total_chA = $empAttA->sum('ch');
                    $total_cbA = $empAttA->sum('cb');
                    $total_clA = $empAttA->sum('cl');

            $mandorA = User::where('dept', 'I/A')
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $dataA = [];

            $totalRegularTotal1A = 0;
            $totalFlTotal1A = 0;

            $totalHTotalRegA = 0;
            $totalTATotalRegA = 0;
            $totalDTotalRegA = 0;
            $totalLTotalRegA = 0;
            $totalMTotalRegA = 0;
            $totalMXTotalRegA = 0;
            $totalSTotalRegA = 0;
            $totalSXTotalRegA = 0;
            $totalITotalRegA = 0;
            $totalIPTotalRegA = 0;
            $totalIXTotalRegA = 0;
            $totalCTTotalRegA = 0;
            $totalCHTotalRegA = 0;
            $totalCBTotalRegA = 0;
            $totalCLTotalRegA = 0;

            $totalHTotalFlA = 0;
            $totalTATotalFlA = 0;
            $totalDTotalFlA = 0;
            $totalLTotalFlA = 0;
            $totalMTotalFlA = 0;
            $totalMXTotalFlA = 0;
            $totalSTotalFlA = 0;
            $totalSXTotalFlA = 0;
            $totalITotalFlA = 0;
            $totalIPTotalFlA = 0;
            $totalIXTotalFlA = 0;
            $totalCTTotalFlA = 0;
            $totalCHTotalFlA = 0;
            $totalCBTotalFlA = 0;
            $totalCLTotalFlA = 0;

            foreach ($mandorA as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1A = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'I/A')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1A += $regularTotal1A;

                $flTotal1A = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'I/A')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1A += $flTotal1A;

                $empReg1A = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1A = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1A = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->get();

                $totalAttregFinalA = $regAtt1A->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalRegA = $regAtt1A->sum('h');
                $totalTAFinalRegA = $regAtt1A->sum('ta');
                $totalDFinalRegA = $regAtt1A->sum('d');
                $totalLFinalRegA = $regAtt1A->sum('l');
                $totalMFinalRegA = $regAtt1A->sum('m');
                $totalMXFinalRegA = $regAtt1A->sum('mx');
                $totalSFinalRegA = $regAtt1A->sum('s');
                $totalSXFinalRegA = $regAtt1A->sum('sx');
                $totalIFinalRegA = $regAtt1A->sum('i');
                $totalIPFinalRegA = $regAtt1A->sum('ip');
                $totalIXFinalRegA = $regAtt1A->sum('ix');
                $totalCTFinalRegA = $regAtt1A->sum('ct');
                $totalCHFinalRegA = $regAtt1A->sum('ch');
                $totalCBFinalRegA = $regAtt1A->sum('cb');
                $totalCLFinalRegA = $regAtt1A->sum('cl');

                $totalHTotalRegA += $totalHFinalRegA;
                $totalTATotalRegA += $totalTAFinalRegA;
                $totalDTotalRegA += $totalDFinalRegA;
                $totalLTotalRegA += $totalLFinalRegA;
                $totalMTotalRegA += $totalMFinalRegA;
                $totalMXTotalRegA += $totalMXFinalRegA;
                $totalSTotalRegA += $totalSFinalRegA;
                $totalSXTotalRegA += $totalSXFinalRegA;
                $totalITotalRegA += $totalIFinalRegA;
                $totalIPTotalRegA += $totalIPFinalRegA;
                $totalIXTotalRegA += $totalIXFinalRegA;
                $totalCTTotalRegA += $totalCTFinalRegA;
                $totalCHTotalRegA += $totalCHFinalRegA;
                $totalCBTotalRegA += $totalCBFinalRegA;
                $totalCLTotalRegA += $totalCLFinalRegA;

                $flAtt1A = DB::table('absen_regs')
                    ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(absen_regs.desc = 'CL') as cl"))
                    // ->addSelect(DB::raw("SUM(absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinalA = $flAtt1A->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFlA = $flAtt1A->sum('h');
                $totalTAFinalFlA = $flAtt1A->sum('ta');
                $totalDFinalFlA = $flAtt1A->sum('d');
                $totalLFinalFlA = $flAtt1A->sum('l');
                $totalMFinalFlA = $flAtt1A->sum('m');
                $totalMXFinalFlA = $flAtt1A->sum('mx');
                $totalSFinalFlA = $flAtt1A->sum('s');
                $totalSXFinalFlA = $flAtt1A->sum('sx');
                $totalIFinalFlA = $flAtt1A->sum('i');
                $totalIPFinalFlA = $flAtt1A->sum('ip');
                $totalIXFinalFlA = $flAtt1A->sum('ix');
                $totalCTFinalFlA = $flAtt1A->sum('ct');
                $totalCHFinalFlA = $flAtt1A->sum('ch');
                $totalCBFinalFlA = $flAtt1A->sum('cb');
                $totalCLFinalFlA = $flAtt1A->sum('cl');

                $totalHTotalFlA += $totalHFinalFlA;
                $totalTATotalFlA += $totalTAFinalFlA;
                $totalDTotalFlA += $totalDFinalFlA;
                $totalLTotalFlA += $totalLFinalFlA;
                $totalMTotalFlA += $totalMFinalFlA;
                $totalMXTotalFlA += $totalMXFinalFlA;
                $totalSTotalFlA += $totalSFinalFlA;
                $totalSXTotalFlA += $totalSXFinalFlA;
                $totalITotalFlA += $totalIFinalFlA;
                $totalIPTotalFlA += $totalIPFinalFlA;
                $totalIXTotalFlA += $totalIXFinalFlA;
                $totalCTTotalFlA += $totalCTFinalFlA;
                $totalCHTotalFlA += $totalCHFinalFlA;
                $totalCBTotalFlA += $totalCBFinalFlA;
                $totalCLTotalFlA += $totalCLFinalFlA;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1A' => $regularTotal1A,
                    'flTotal1A' => $flTotal1A,
                    'totalHFinalRegA' => $totalHFinalRegA,
                    'totalTAFinalRegA' => $totalTAFinalRegA,
                    'totalDFinalRegA' => $totalDFinalRegA,
                    'totalLFinalRegA' => $totalLFinalRegA,
                    'totalMFinalRegA' => $totalMFinalRegA,
                    'totalMXFinalRegA' => $totalMXFinalRegA,
                    'totalSFinalRegA' => $totalSFinalRegA,
                    'totalSXFinalRegA' => $totalSXFinalRegA,
                    'totalIFinalRegA' => $totalIFinalRegA,
                    'totalIPFinalRegA' => $totalIPFinalRegA,
                    'totalIXFinalRegA' => $totalIXFinalRegA,
                    'totalCTFinalRegA' => $totalCTFinalRegA,
                    'totalCHFinalRegA' => $totalCHFinalRegA,
                    'totalCBFinalRegA' => $totalCBFinalRegA,
                    'totalCLFinalRegA' => $totalCLFinalRegA,
                    'totalHFinalFlA' => $totalHFinalFlA,
                    'totalTAFinalFlA' => $totalTAFinalFlA,
                    'totalDFinalFlA' => $totalDFinalFlA,
                    'totalLFinalFlA' => $totalLFinalFlA,
                    'totalMFinalFlA' => $totalMFinalFlA,
                    'totalMXFinalFlA' => $totalMXFinalFlA,
                    'totalSFinalFlA' => $totalSFinalFlA,
                    'totalSXFinalFlA' => $totalSXFinalFlA,
                    'totalIFinalFlA' => $totalIFinalFlA,
                    'totalIPFinalFlA' => $totalIPFinalFlA,
                    'totalIXFinalFlA' => $totalIXFinalFlA,
                    'totalCTFinalFlA' => $totalCTFinalFlA,
                    'totalCHFinalFlA' => $totalCHFinalFlA,
                    'totalCBFinalFlA' => $totalCBFinalFlA,
                    'totalCLFinalFlA' => $totalCLFinalFlA,
                    'staffAttA' => $staffAttA,
                    'monAttA' => $monAttA,
                    'regAttA' => $regAttA,
                    'flAttA' => $flAttA,
                    'bskpAttA' => $bskpAttA,
                    'staffTotalA' => $staffTotalA,
                    'monthlyTotalA' => $monthlyTotalA,
                    'regularTotalA' => $regularTotalA,
                    'flTotalA' => $flTotalA,
                    'bskpTotalA' => $bskpTotalA,
                    'totalHFinalA' => $totalHFinalA,
                    'totalTAFinalA' => $totalTAFinalA,
                    'totalDFinalA' => $totalDFinalA,
                    'totalLFinalA' => $totalLFinalA,
                    'totalMFinalA' => $totalMFinalA,
                    'totalMXFinalA' => $totalMXFinalA,
                    'totalSFinalA' => $totalSFinalA,
                    'totalSXFinalA' => $totalSXFinalA,
                    'totalIFinalA' => $totalIFinalA,
                    'totalIPFinalA' => $totalIPFinalA,
                    'totalIXFinalA' => $totalIXFinalA,
                    'totalCTFinalA' => $totalCTFinalA,
                    'totalCHFinalA' => $totalCHFinalA,
                    'totalCBFinalA' => $totalCBFinalA,
                    'totalCLFinalA' => $totalCLFinalA,
                ];

                $dataA[] = $item;
            }

            usort($dataA, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            // II/D
            $staffAttD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'II/D')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttD = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/D')
                    ->where('users.status', 'Monthly')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttD = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/D')
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttD = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/D')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttD = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/D')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttD = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/D')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinal = $totalAttD->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalD = $totalAttD->sum('hadir');
                $totalTAFinalD = $totalAttD->sum('ta');
                $totalDFinalD = $totalAttD->sum('d');
                $totalLFinalD = $totalAttD->sum('l');
                $totalMFinalD = $totalAttD->sum('m');
                $totalMXFinalD = $totalAttD->sum('mx');
                $totalSFinalD = $totalAttD->sum('s');
                $totalSXFinalD = $totalAttD->sum('sx');
                $totalIFinalD = $totalAttD->sum('i');
                $totalIPFinalD = $totalAttD->sum('ip');
                $totalIXFinalD = $totalAttD->sum('ix');
                $totalCTFinalD = $totalAttD->sum('ct');
                $totalCHFinalD = $totalAttD->sum('ch');
                $totalCBFinalD = $totalAttD->sum('cb');
                $totalCLFinalD = $totalAttD->sum('cl');

                $staffTotalD = DB::table('users')
                    ->where('dept', 'II/D')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalD = DB::table('users')
                    ->where('dept', 'II/D')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalD = DB::table('users')
                    ->where('dept', 'II/D')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalD = DB::table('users')
                    ->where('dept', 'II/D')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalD = DB::table('users')
                    ->where('dept', 'II/D')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttD = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                        DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'II/D')
                    ->whereDate('test_absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hD = $empAttD->sum('hadir');
                    $total_lD = $empAttD->sum('l');
                    $total_taD = $empAttD->sum('ta');
                    $total_dD = $empAttD->sum('d');
                    $total_mD = $empAttD->sum('m');
                    $total_mxD = $empAttD->sum('mx');
                    $total_sD = $empAttD->sum('s');
                    $total_sxD = $empAttD->sum('sx');
                    $total_iD = $empAttD->sum('i');
                    $total_ipD = $empAttD->sum('ip');
                    $total_ixD = $empAttD->sum('ix');
                    $total_ctD = $empAttD->sum('ct');
                    $total_chD = $empAttD->sum('ch');
                    $total_cbD = $empAttD->sum('cb');
                    $total_clD = $empAttD->sum('cl');

            $mandorD = User::where('dept', 'II/D')
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $dataD = [];

            $totalRegularTotal1D = 0;
            $totalFlTotal1D = 0;

            $totalHTotalRegD = 0;
            $totalTATotalRegD = 0;
            $totalDTotalRegD = 0;
            $totalLTotalRegD = 0;
            $totalMTotalRegD = 0;
            $totalMXTotalRegD = 0;
            $totalSTotalRegD = 0;
            $totalSXTotalRegD = 0;
            $totalITotalRegD = 0;
            $totalIPTotalRegD = 0;
            $totalIXTotalRegD = 0;
            $totalCTTotalRegD = 0;
            $totalCHTotalRegD = 0;
            $totalCBTotalRegD = 0;
            $totalCLTotalRegD = 0;

            $totalHTotalFlD = 0;
            $totalTATotalFlD = 0;
            $totalDTotalFlD = 0;
            $totalLTotalFlD = 0;
            $totalMTotalFlD = 0;
            $totalMXTotalFlD = 0;
            $totalSTotalFlD = 0;
            $totalSXTotalFlD = 0;
            $totalITotalFlD = 0;
            $totalIPTotalFlD = 0;
            $totalIXTotalFlD = 0;
            $totalCTTotalFlD = 0;
            $totalCHTotalFlD = 0;
            $totalCBTotalFlD = 0;
            $totalCLTotalFlD = 0;

            foreach ($mandorD as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1D = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'II/D')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1D += $regularTotal1D;

                $flTotal1D = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'II/D')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1D += $flTotal1D;

                $empReg1D = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1D = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1D = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->get();

                $totalAttregFinalD = $regAtt1D->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalRegD = $regAtt1D->sum('hadir');
                $totalTAFinalRegD = $regAtt1D->sum('ta');
                $totalDFinalRegD = $regAtt1D->sum('d');
                $totalLFinalRegD = $regAtt1D->sum('l');
                $totalMFinalRegD = $regAtt1D->sum('m');
                $totalMXFinalRegD = $regAtt1D->sum('mx');
                $totalSFinalRegD = $regAtt1D->sum('s');
                $totalSXFinalRegD = $regAtt1D->sum('sx');
                $totalIFinalRegD = $regAtt1D->sum('i');
                $totalIPFinalRegD = $regAtt1D->sum('ip');
                $totalIXFinalRegD = $regAtt1D->sum('ix');
                $totalCTFinalRegD = $regAtt1D->sum('ct');
                $totalCHFinalRegD = $regAtt1D->sum('ch');
                $totalCBFinalRegD = $regAtt1D->sum('cb');
                $totalCLFinalRegD = $regAtt1D->sum('cl');

                $totalHTotalRegD += $totalHFinalRegD;
                $totalTATotalRegD += $totalTAFinalRegD;
                $totalDTotalRegD += $totalDFinalRegD;
                $totalLTotalRegD += $totalLFinalRegD;
                $totalMTotalRegD += $totalMFinalRegD;
                $totalMXTotalRegD += $totalMXFinalRegD;
                $totalSTotalRegD += $totalSFinalRegD;
                $totalSXTotalRegD += $totalSXFinalRegD;
                $totalITotalRegD += $totalIFinalRegD;
                $totalIPTotalRegD += $totalIPFinalRegD;
                $totalIXTotalRegD += $totalIXFinalRegD;
                $totalCTTotalRegD += $totalCTFinalRegD;
                $totalCHTotalRegD += $totalCHFinalRegD;
                $totalCBTotalRegD += $totalCBFinalRegD;
                $totalCLTotalRegD += $totalCLFinalRegD;

                $flAtt1D = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinalD = $flAtt1D->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFlD = $flAtt1D->sum('hadir');
                $totalTAFinalFlD = $flAtt1D->sum('ta');
                $totalDFinalFlD = $flAtt1D->sum('d');
                $totalLFinalFlD = $flAtt1D->sum('l');
                $totalMFinalFlD = $flAtt1D->sum('m');
                $totalMXFinalFlD = $flAtt1D->sum('mx');
                $totalSFinalFlD = $flAtt1D->sum('s');
                $totalSXFinalFlD = $flAtt1D->sum('sx');
                $totalIFinalFlD = $flAtt1D->sum('i');
                $totalIPFinalFlD = $flAtt1D->sum('ip');
                $totalIXFinalFlD = $flAtt1D->sum('ix');
                $totalCTFinalFlD = $flAtt1D->sum('ct');
                $totalCHFinalFlD = $flAtt1D->sum('ch');
                $totalCBFinalFlD = $flAtt1D->sum('cb');
                $totalCLFinalFlD = $flAtt1D->sum('cl');

                $totalHTotalFlD += $totalHFinalFlD;
                $totalTATotalFlD += $totalTAFinalFlD;
                $totalDTotalFlD += $totalDFinalFlD;
                $totalLTotalFlD += $totalLFinalFlD;
                $totalMTotalFlD += $totalMFinalFlD;
                $totalMXTotalFlD += $totalMXFinalFlD;
                $totalSTotalFlD += $totalSFinalFlD;
                $totalSXTotalFlD += $totalSXFinalFlD;
                $totalITotalFlD += $totalIFinalFlD;
                $totalIPTotalFlD += $totalIPFinalFlD;
                $totalIXTotalFlD += $totalIXFinalFlD;
                $totalCTTotalFlD += $totalCTFinalFlD;
                $totalCHTotalFlD += $totalCHFinalFlD;
                $totalCBTotalFlD += $totalCBFinalFlD;
                $totalCLTotalFlD += $totalCLFinalFlD;

                $item = [
                    'mandor' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1D' => $regularTotal1D,
                    'flTotal1D' => $flTotal1D,
                    'totalHFinalRegD' => $totalHFinalRegD,
                    'totalTAFinalRegD' => $totalTAFinalRegD,
                    'totalDFinalRegD' => $totalDFinalRegD,
                    'totalLFinalRegD' => $totalLFinalRegD,
                    'totalMFinalRegD' => $totalMFinalRegD,
                    'totalMXFinalRegD' => $totalMXFinalRegD,
                    'totalSFinalRegD' => $totalSFinalRegD,
                    'totalSXFinalRegD' => $totalSXFinalRegD,
                    'totalIFinalRegD' => $totalIFinalRegD,
                    'totalIPFinalRegD' => $totalIPFinalRegD,
                    'totalIXFinalRegD' => $totalIXFinalRegD,
                    'totalCTFinalRegD' => $totalCTFinalRegD,
                    'totalCHFinalRegD' => $totalCHFinalRegD,
                    'totalCBFinalRegD' => $totalCBFinalRegD,
                    'totalCLFinalRegD' => $totalCLFinalRegD,
                    'totalHFinalFlD' => $totalHFinalFlD,
                    'totalTAFinalFlD' => $totalTAFinalFlD,
                    'totalDFinalFlD' => $totalDFinalFlD,
                    'totalLFinalFlD' => $totalLFinalFlD,
                    'totalMFinalFlD' => $totalMFinalFlD,
                    'totalMXFinalFlD' => $totalMXFinalFlD,
                    'totalSFinalFlD' => $totalSFinalFlD,
                    'totalSXFinalFlD' => $totalSXFinalFlD,
                    'totalIFinalFlD' => $totalIFinalFlD,
                    'totalIPFinalFlD' => $totalIPFinalFlD,
                    'totalIXFinalFlD' => $totalIXFinalFlD,
                    'totalCTFinalFlD' => $totalCTFinalFlD,
                    'totalCHFinalFlD' => $totalCHFinalFlD,
                    'totalCBFinalFlD' => $totalCBFinalFlD,
                    'totalCLFinalFlD' => $totalCLFinalFlD,
                    'staffAttD' => $staffAttD,
                    'monAttD' => $monAttD,
                    'regAttD' => $regAttD,
                    'flAttD' => $flAttD,
                    'bskpAttD' => $bskpAttD,
                    'staffTotalD' => $staffTotalD,
                    'monthlyTotalD' => $monthlyTotalD,
                    'regularTotalD' => $regularTotalD,
                    'flTotalD' => $flTotalD,
                    'bskpTotalD' => $bskpTotalD,
                    'totalHFinalD' => $totalHFinalD,
                    'totalTAFinalD' => $totalTAFinalD,
                    'totalDFinalD' => $totalDFinalD,
                    'totalLFinalD' => $totalLFinalD,
                    'totalMFinalD' => $totalMFinalD,
                    'totalMXFinalD' => $totalMXFinalD,
                    'totalSFinalD' => $totalSFinalD,
                    'totalSXFinalD' => $totalSXFinalD,
                    'totalIFinalD' => $totalIFinalD,
                    'totalIPFinalD' => $totalIPFinalD,
                    'totalIXFinalD' => $totalIXFinalD,
                    'totalCTFinalD' => $totalCTFinalD,
                    'totalCHFinalD' => $totalCHFinalD,
                    'totalCBFinalD' => $totalCBFinalD,
                    'totalCLFinalD' => $totalCLFinalD,
                ];

                $dataD[] = $item;
            }

            usort($dataD, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });


            // I/B

            $staffAttB = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'I/B')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

                $monAttB = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/B')
                    ->where('users.status', 'Monthly')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAttB = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/B')
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAttB = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/B')
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAttB = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.status',
                        'test_absen_regs.desc',
                    )
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/B')
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttB = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/B')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinal = $totalAttB->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalB = $totalAttB->sum('hadir');
                $totalTAFinalB = $totalAttB->sum('ta');
                $totalDFinalB = $totalAttB->sum('d');
                $totalLFinalB = $totalAttB->sum('l');
                $totalMFinalB = $totalAttB->sum('m');
                $totalMXFinalB = $totalAttB->sum('mx');
                $totalSFinalB = $totalAttB->sum('s');
                $totalSXFinalB = $totalAttB->sum('sx');
                $totalIFinalB = $totalAttB->sum('i');
                $totalIPFinalB = $totalAttB->sum('ip');
                $totalIXFinalB = $totalAttB->sum('ix');
                $totalCTFinalB = $totalAttB->sum('ct');
                $totalCHFinalB = $totalAttB->sum('ch');
                $totalCBFinalB = $totalAttB->sum('cb');
                $totalCLFinalB = $totalAttB->sum('cl');

                $staffTotalB = DB::table('users')
                    ->where('dept', 'I/B')
                    ->where('status', 'Staff')
                    ->count('dept');

                $monthlyTotalB = DB::table('users')
                    ->where('dept', 'I/B')
                    ->where('status', 'Monthly')
                    ->count('dept');

                $regularTotalB = DB::table('users')
                    ->where('dept', 'I/B')
                    ->where('status', 'Regular')
                    ->count('dept');

                $flTotalB = DB::table('users')
                    ->where('dept', 'I/B')
                    ->where('status', 'Contract FL')
                    ->count('dept');

                $bskpTotalB = DB::table('users')
                    ->where('dept', 'I/B')
                    ->where('status', 'Contract BSKP')
                    ->count('dept');

                $empAttB = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                        DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                        DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                        DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                        DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                        DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                        DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                        DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                        DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                        DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                        DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                        DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                        DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                        DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                        DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                        DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                    )
                    ->where('users.active', 'yes')
                    ->where('users.dept', 'I/B')
                    ->whereDate('test_absen_regs.date', $date)
                    ->whereNotIn('users.status', ['Contract FL', 'Contract BSKP', 'Regular'])
                    ->groupBy('users.nik', 'users.name')
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $total_hB = $empAttB->sum('hadir');
                    $total_lB = $empAttB->sum('l');
                    $total_taB = $empAttB->sum('ta');
                    $total_dB = $empAttB->sum('d');
                    $total_mB = $empAttB->sum('m');
                    $total_mxB = $empAttB->sum('mx');
                    $total_sB = $empAttB->sum('s');
                    $total_sxB = $empAttB->sum('sx');
                    $total_iB = $empAttB->sum('i');
                    $total_ipB = $empAttB->sum('ip');
                    $total_ixB = $empAttB->sum('ix');
                    $total_ctB = $empAttB->sum('ct');
                    $total_chB = $empAttB->sum('ch');
                    $total_cbB = $empAttB->sum('cb');
                    $total_clB = $empAttB->sum('cl');

            $mandorB = User::where('dept', 'I/B')
            ->where('jabatan', 'Mandor Tapping')
            ->select('nik')
            ->get();

            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $data = [];

            $totalRegularTotal1 = 0;
            $totalFlTotal1 = 0;

            $totalHTotalReg = 0;
            $totalTATotalReg = 0;
            $totalDTotalReg = 0;
            $totalLTotalReg = 0;
            $totalMTotalReg = 0;
            $totalMXTotalReg = 0;
            $totalSTotalReg = 0;
            $totalSXTotalReg = 0;
            $totalITotalReg = 0;
            $totalIPTotalReg = 0;
            $totalIXTotalReg = 0;
            $totalCTTotalReg = 0;
            $totalCHTotalReg = 0;
            $totalCBTotalReg = 0;
            $totalCLTotalReg = 0;

            $totalHTotalFl = 0;
            $totalTATotalFl = 0;
            $totalDTotalFl = 0;
            $totalLTotalFl = 0;
            $totalMTotalFl = 0;
            $totalMXTotalFl = 0;
            $totalSTotalFl = 0;
            $totalSXTotalFl = 0;
            $totalITotalFl = 0;
            $totalIPTotalFl = 0;
            $totalIXTotalFl = 0;
            $totalCTTotalFl = 0;
            $totalCHTotalFl = 0;
            $totalCBTotalFl = 0;
            $totalCLTotalFl = 0;

            foreach ($mandorB as $mandor) {
                $mandorName = User::where('nik', $mandor->nik)->value('name');
                $mandorNames[] = $mandorName;

                $regularTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'I/B')
                    ->where('status', 'Regular')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalRegularTotal1 += $regularTotal1;

                $flTotal1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('dept', 'I/B')
                    ->where('status', 'Contract FL')
                    ->where('users.active', 'yes')
                    ->count('dept');

                $totalFlTotal1 += $flTotal1;

                $empReg1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $empFL1 = DB::table('mandor_tappers')
                    ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                    ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                    ->select(
                        'users.nik',
                        'users.name',
                        'test_absen_regs.desc'
                    )
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract')
                    ->whereDate('test_absen_regs.date', $date)
                    ->where('users.active', 'yes')
                    ->get();

                $regAtt1 = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Regular')
                    ->whereDate('test_absen_regs.date', $date)
                    ->get();

                $totalAttregFinal = $regAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                // dd($totalAttregFinal);

                $totalHFinalReg = $regAtt1->sum('hadir');
                $totalTAFinalReg = $regAtt1->sum('ta');
                $totalDFinalReg = $regAtt1->sum('d');
                $totalLFinalReg = $regAtt1->sum('l');
                $totalMFinalReg = $regAtt1->sum('m');
                $totalMXFinalReg = $regAtt1->sum('mx');
                $totalSFinalReg = $regAtt1->sum('s');
                $totalSXFinalReg = $regAtt1->sum('sx');
                $totalIFinalReg = $regAtt1->sum('i');
                $totalIPFinalReg = $regAtt1->sum('ip');
                $totalIXFinalReg = $regAtt1->sum('ix');
                $totalCTFinalReg = $regAtt1->sum('ct');
                $totalCHFinalReg = $regAtt1->sum('ch');
                $totalCBFinalReg = $regAtt1->sum('cb');
                $totalCLFinalReg = $regAtt1->sum('cl');

                $totalHTotalReg += $totalHFinalReg;
                $totalTATotalReg += $totalTAFinalReg;
                $totalDTotalReg += $totalDFinalReg;
                $totalLTotalReg += $totalLFinalReg;
                $totalMTotalReg += $totalMFinalReg;
                $totalMXTotalReg += $totalMXFinalReg;
                $totalSTotalReg += $totalSFinalReg;
                $totalSXTotalReg += $totalSXFinalReg;
                $totalITotalReg += $totalIFinalReg;
                $totalIPTotalReg += $totalIPFinalReg;
                $totalIXTotalReg += $totalIXFinalReg;
                $totalCTTotalReg += $totalCTFinalReg;
                $totalCHTotalReg += $totalCHFinalReg;
                $totalCBTotalReg += $totalCBFinalReg;
                $totalCLTotalReg += $totalCLFinalReg;

                $flAtt1 = DB::table('test_absen_regs')
                    ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('mandor_tappers.user_id', $mandor->nik)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('test_absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttflFinal = $flAtt1->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinalFl = $flAtt1->sum('hadir');
                $totalTAFinalFl = $flAtt1->sum('ta');
                $totalDFinalFl = $flAtt1->sum('d');
                $totalLFinalFl = $flAtt1->sum('l');
                $totalMFinalFl = $flAtt1->sum('m');
                $totalMXFinalFl = $flAtt1->sum('mx');
                $totalSFinalFl = $flAtt1->sum('s');
                $totalSXFinalFl = $flAtt1->sum('sx');
                $totalIFinalFl = $flAtt1->sum('i');
                $totalIPFinalFl = $flAtt1->sum('ip');
                $totalIXFinalFl = $flAtt1->sum('ix');
                $totalCTFinalFl = $flAtt1->sum('ct');
                $totalCHFinalFl = $flAtt1->sum('ch');
                $totalCBFinalFl = $flAtt1->sum('cb');
                $totalCLFinalFl = $flAtt1->sum('cl');

                $totalHTotalFl += $totalHFinalFl;
                $totalTATotalFl += $totalTAFinalFl;
                $totalDTotalFl += $totalDFinalFl;
                $totalLTotalFl += $totalLFinalFl;
                $totalMTotalFl += $totalMFinalFl;
                $totalMXTotalFl += $totalMXFinalFl;
                $totalSTotalFl += $totalSFinalFl;
                $totalSXTotalFl += $totalSXFinalFl;
                $totalITotalFl += $totalIFinalFl;
                $totalIPTotalFl += $totalIPFinalFl;
                $totalIXTotalFl += $totalIXFinalFl;
                $totalCTTotalFl += $totalCTFinalFl;
                $totalCHTotalFl += $totalCHFinalFl;
                $totalCBTotalFl += $totalCBFinalFl;
                $totalCLTotalFl += $totalCLFinalFl;

                $item = [
                    'mandorB' => $mandor,
                    'mandorName' => $mandorName,
                    'date' => $date,
                    'dept' => $dept,
                    'regularTotal1' => $regularTotal1,
                    'flTotal1' => $flTotal1,
                    'totalHFinalReg' => $totalHFinalReg,
                    'totalTAFinalReg' => $totalTAFinalReg,
                    'totalDFinalReg' => $totalDFinalReg,
                    'totalLFinalReg' => $totalLFinalReg,
                    'totalMFinalReg' => $totalMFinalReg,
                    'totalMXFinalReg' => $totalMXFinalReg,
                    'totalSFinalReg' => $totalSFinalReg,
                    'totalSXFinalReg' => $totalSXFinalReg,
                    'totalIFinalReg' => $totalIFinalReg,
                    'totalIPFinalReg' => $totalIPFinalReg,
                    'totalIXFinalReg' => $totalIXFinalReg,
                    'totalCTFinalReg' => $totalCTFinalReg,
                    'totalCHFinalReg' => $totalCHFinalReg,
                    'totalCBFinalReg' => $totalCBFinalReg,
                    'totalCLFinalReg' => $totalCLFinalReg,
                    'totalHFinalFl' => $totalHFinalFl,
                    'totalTAFinalFl' => $totalTAFinalFl,
                    'totalDFinalFl' => $totalDFinalFl,
                    'totalLFinalFl' => $totalLFinalFl,
                    'totalMFinalFl' => $totalMFinalFl,
                    'totalMXFinalFl' => $totalMXFinalFl,
                    'totalSFinalFl' => $totalSFinalFl,
                    'totalSXFinalFl' => $totalSXFinalFl,
                    'totalIFinalFl' => $totalIFinalFl,
                    'totalIPFinalFl' => $totalIPFinalFl,
                    'totalIXFinalFl' => $totalIXFinalFl,
                    'totalCTFinalFl' => $totalCTFinalFl,
                    'totalCHFinalFl' => $totalCHFinalFl,
                    'totalCBFinalFl' => $totalCBFinalFl,
                    'totalCLFinalFl' => $totalCLFinalFl,
                    'staffAttB' => $staffAttB,
                    'monAttB' => $monAttB,
                    'regAttB' => $regAttB,
                    'flAttB' => $flAttB,
                    'bskpAttB' => $bskpAttB,
                    'staffTotalB' => $staffTotalB,
                    'monthlyTotalB' => $monthlyTotalB,
                    'regularTotalB' => $regularTotalB,
                    'flTotalB' => $flTotalB,
                    'bskpTotalB' => $bskpTotalB,
                    'totalHFinalB' => $totalHFinalB,
                    'totalTAFinalB' => $totalTAFinalB,
                    'totalDFinalB' => $totalDFinalB,
                    'totalLFinalB' => $totalLFinalB,
                    'totalMFinalB' => $totalMFinalB,
                    'totalMXFinalB' => $totalMXFinalB,
                    'totalSFinalB' => $totalSFinalB,
                    'totalSXFinalB' => $totalSXFinalB,
                    'totalIFinalB' => $totalIFinalB,
                    'totalIPFinalB' => $totalIPFinalB,
                    'totalIXFinalB' => $totalIXFinalB,
                    'totalCTFinalB' => $totalCTFinalB,
                    'totalCHFinalB' => $totalCHFinalB,
                    'totalCBFinalB' => $totalCBFinalB,
                    'totalCLFinalB' => $totalCLFinalB,
                ];

                $data[] = $item;
            }

            usort($data, function ($a, $b) {
                return strcmp($a['mandorName'], $b['mandorName']);
            });

            // IT
            $staffAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalIT = $totalAttIT->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalIT = $totalAttIT->sum('hadir');
            $totalTAFinalIT = $totalAttIT->sum('ta');
            $totalDFinalIT = $totalAttIT->sum('d');
            $totalLFinalIT = $totalAttIT->sum('l');
            $totalMFinalIT = $totalAttIT->sum('m');
            $totalMXFinalIT = $totalAttIT->sum('mx');
            $totalSFinalIT = $totalAttIT->sum('s');
            $totalSXFinalIT = $totalAttIT->sum('sx');
            $totalIFinalIT = $totalAttIT->sum('i');
            $totalIPFinalIT = $totalAttIT->sum('ip');
            $totalIXFinalIT = $totalAttIT->sum('ix');
            $totalCTFinalIT = $totalAttIT->sum('ct');
            $totalCHFinalIT = $totalAttIT->sum('ch');
            $totalCBFinalIT = $totalAttIT->sum('cb');
            $totalCLFinalIT = $totalAttIT->sum('cl');

            $staffTotalIT = DB::table('users')
                ->where('dept', 'IT')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalIT = DB::table('users')
                ->where('dept', 'IT')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalIT = DB::table('users')
                ->where('dept', 'IT')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalIT = DB::table('users')
                ->where('dept', 'IT')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalIT = DB::table('users')
                ->where('dept', 'IT')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttIT = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'IT')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hIT = $empAttIT->sum('hadir');
            $total_lIT = $empAttIT->sum('l');
            $total_taIT = $empAttIT->sum('ta');
            $total_dIT = $empAttIT->sum('d');
            $total_mIT = $empAttIT->sum('m');
            $total_mxIT = $empAttIT->sum('mx');
            $total_sIT = $empAttIT->sum('s');
            $total_sxIT = $empAttIT->sum('sx');
            $total_iIT = $empAttIT->sum('i');
            $total_ipIT = $empAttIT->sum('ip');
            $total_ixIT = $empAttIT->sum('ix');
            $total_ctIT = $empAttIT->sum('ct');
            $total_chIT = $empAttIT->sum('ch');
            $total_cbIT = $empAttIT->sum('cb');
            $total_clIT = $empAttIT->sum('cl');

            // HR
            $staffAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalHR = $totalAttHR->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalHR = $totalAttHR->sum('hadir');
            $totalTAFinalHR = $totalAttHR->sum('ta');
            $totalDFinalHR = $totalAttHR->sum('d');
            $totalLFinalHR = $totalAttHR->sum('l');
            $totalMFinalHR = $totalAttHR->sum('m');
            $totalMXFinalHR = $totalAttHR->sum('mx');
            $totalSFinalHR = $totalAttHR->sum('s');
            $totalSXFinalHR = $totalAttHR->sum('sx');
            $totalIFinalHR = $totalAttHR->sum('i');
            $totalIPFinalHR = $totalAttHR->sum('ip');
            $totalIXFinalHR = $totalAttHR->sum('ix');
            $totalCTFinalHR = $totalAttHR->sum('ct');
            $totalCHFinalHR = $totalAttHR->sum('ch');
            $totalCBFinalHR = $totalAttHR->sum('cb');
            $totalCLFinalHR = $totalAttHR->sum('cl');

            $staffTotalHR = DB::table('users')
                ->where('dept', 'HR Legal')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalHR = DB::table('users')
                ->where('dept', 'HR Legal')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalHR = DB::table('users')
                ->where('dept', 'HR Legal')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalHR = DB::table('users')
                ->where('dept', 'HR Legal')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalHR = DB::table('users')
                ->where('dept', 'HR Legal')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttHR = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'HR Legal')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hHR = $empAttHR->sum('hadir');
            $total_lHR = $empAttHR->sum('l');
            $total_taHR = $empAttHR->sum('ta');
            $total_dHR = $empAttHR->sum('d');
            $total_mHR = $empAttHR->sum('m');
            $total_mxHR = $empAttHR->sum('mx');
            $total_sHR = $empAttHR->sum('s');
            $total_sxHR = $empAttHR->sum('sx');
            $total_iHR = $empAttHR->sum('i');
            $total_ipHR = $empAttHR->sum('ip');
            $total_ixHR = $empAttHR->sum('ix');
            $total_ctHR = $empAttHR->sum('ct');
            $total_chHR = $empAttHR->sum('ch');
            $total_cbHR = $empAttHR->sum('cb');
            $total_clHR = $empAttHR->sum('cl');

            // Acc & Fin
            $staffAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalAF = $totalAttAF->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalAF = $totalAttAF->sum('hadir');
            $totalTAFinalAF = $totalAttAF->sum('ta');
            $totalDFinalAF = $totalAttAF->sum('d');
            $totalLFinalAF = $totalAttAF->sum('l');
            $totalMFinalAF = $totalAttAF->sum('m');
            $totalMXFinalAF = $totalAttAF->sum('mx');
            $totalSFinalAF = $totalAttAF->sum('s');
            $totalSXFinalAF = $totalAttAF->sum('sx');
            $totalIFinalAF = $totalAttAF->sum('i');
            $totalIPFinalAF = $totalAttAF->sum('ip');
            $totalIXFinalAF = $totalAttAF->sum('ix');
            $totalCTFinalAF = $totalAttAF->sum('ct');
            $totalCHFinalAF = $totalAttAF->sum('ch');
            $totalCBFinalAF = $totalAttAF->sum('cb');
            $totalCLFinalAF = $totalAttAF->sum('cl');

            $staffTotalAF = DB::table('users')
                ->where('dept', 'Acc & Fin')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalAF = DB::table('users')
                ->where('dept', 'Acc & Fin')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalAF = DB::table('users')
                ->where('dept', 'Acc & Fin')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalAF = DB::table('users')
                ->where('dept', 'Acc & Fin')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalAF = DB::table('users')
                ->where('dept', 'Acc & Fin')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttAF = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'Acc & Fin')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hAF = $empAttAF->sum('hadir');
            $total_lAF = $empAttAF->sum('l');
            $total_taAF = $empAttAF->sum('ta');
            $total_dAF = $empAttAF->sum('d');
            $total_mAF = $empAttAF->sum('m');
            $total_mxAF = $empAttAF->sum('mx');
            $total_sAF = $empAttAF->sum('s');
            $total_sxAF = $empAttAF->sum('sx');
            $total_iAF = $empAttAF->sum('i');
            $total_ipAF = $empAttAF->sum('ip');
            $total_ixAF = $empAttAF->sum('ix');
            $total_ctAF = $empAttAF->sum('ct');
            $total_chAF = $empAttAF->sum('ch');
            $total_cbAF = $empAttAF->sum('cb');
            $total_clAF = $empAttAF->sum('cl');

            // BSKP
            $staffAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalBSKP = $totalAttBSKP->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalBSKP = $totalAttBSKP->sum('hadir');
            $totalTAFinalBSKP = $totalAttBSKP->sum('ta');
            $totalDFinalBSKP = $totalAttBSKP->sum('d');
            $totalLFinalBSKP = $totalAttBSKP->sum('l');
            $totalMFinalBSKP = $totalAttBSKP->sum('m');
            $totalMXFinalBSKP = $totalAttBSKP->sum('mx');
            $totalSFinalBSKP = $totalAttBSKP->sum('s');
            $totalSXFinalBSKP = $totalAttBSKP->sum('sx');
            $totalIFinalBSKP = $totalAttBSKP->sum('i');
            $totalIPFinalBSKP = $totalAttBSKP->sum('ip');
            $totalIXFinalBSKP = $totalAttBSKP->sum('ix');
            $totalCTFinalBSKP = $totalAttBSKP->sum('ct');
            $totalCHFinalBSKP = $totalAttBSKP->sum('ch');
            $totalCBFinalBSKP = $totalAttBSKP->sum('cb');
            $totalCLFinalBSKP = $totalAttBSKP->sum('cl');

            $staffTotalBSKP = DB::table('users')
                ->where('dept', 'BSKP')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalBSKP = DB::table('users')
                ->where('dept', 'BSKP')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalBSKP = DB::table('users')
                ->where('dept', 'BSKP')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalBSKP = DB::table('users')
                ->where('dept', 'BSKP')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalBSKP = DB::table('users')
                ->where('dept', 'BSKP')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttBSKP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hBSKP = $empAttBSKP->sum('hadir');
            $total_lBSKP = $empAttBSKP->sum('l');
            $total_taBSKP = $empAttBSKP->sum('ta');
            $total_dBSKP = $empAttBSKP->sum('d');
            $total_mBSKP = $empAttBSKP->sum('m');
            $total_mxBSKP = $empAttBSKP->sum('mx');
            $total_sBSKP = $empAttBSKP->sum('s');
            $total_sxBSKP = $empAttBSKP->sum('sx');
            $total_iBSKP = $empAttBSKP->sum('i');
            $total_ipBSKP = $empAttBSKP->sum('ip');
            $total_ixBSKP = $empAttBSKP->sum('ix');
            $total_ctBSKP = $empAttBSKP->sum('ct');
            $total_chBSKP = $empAttBSKP->sum('ch');
            $total_cbBSKP = $empAttBSKP->sum('cb');
            $total_clBSKP = $empAttBSKP->sum('cl');

            // FSD
            $staffAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalFSD = $totalAttFSD->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalFSD = $totalAttFSD->sum('hadir');
            $totalTAFinalFSD = $totalAttFSD->sum('ta');
            $totalDFinalFSD = $totalAttFSD->sum('d');
            $totalLFinalFSD = $totalAttFSD->sum('l');
            $totalMFinalFSD = $totalAttFSD->sum('m');
            $totalMXFinalFSD = $totalAttFSD->sum('mx');
            $totalSFinalFSD = $totalAttFSD->sum('s');
            $totalSXFinalFSD = $totalAttFSD->sum('sx');
            $totalIFinalFSD = $totalAttFSD->sum('i');
            $totalIPFinalFSD = $totalAttFSD->sum('ip');
            $totalIXFinalFSD = $totalAttFSD->sum('ix');
            $totalCTFinalFSD = $totalAttFSD->sum('ct');
            $totalCHFinalFSD = $totalAttFSD->sum('ch');
            $totalCBFinalFSD = $totalAttFSD->sum('cb');
            $totalCLFinalFSD = $totalAttFSD->sum('cl');

            $staffTotalFSD = DB::table('users')
                ->where('dept', 'FSD')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalFSD = DB::table('users')
                ->where('dept', 'FSD')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalFSD = DB::table('users')
                ->where('dept', 'FSD')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalFSD = DB::table('users')
                ->where('dept', 'FSD')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalFSD = DB::table('users')
                ->where('dept', 'FSD')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttFSD = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'FSD')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hFSD = $empAttFSD->sum('hadir');
            $total_lFSD = $empAttFSD->sum('l');
            $total_taFSD = $empAttFSD->sum('ta');
            $total_dFSD = $empAttFSD->sum('d');
            $total_mFSD = $empAttFSD->sum('m');
            $total_mxFSD = $empAttFSD->sum('mx');
            $total_sFSD = $empAttFSD->sum('s');
            $total_sxFSD = $empAttFSD->sum('sx');
            $total_iFSD = $empAttFSD->sum('i');
            $total_ipFSD = $empAttFSD->sum('ip');
            $total_ixFSD = $empAttFSD->sum('ix');
            $total_ctFSD = $empAttFSD->sum('ct');
            $total_chFSD = $empAttFSD->sum('ch');
            $total_cbFSD = $empAttFSD->sum('cb');
            $total_clFSD = $empAttFSD->sum('cl');

            // Factory

            // Field
            $staffAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalField = $totalAttField->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalField = $totalAttField->sum('hadir');
            $totalTAFinalField = $totalAttField->sum('ta');
            $totalDFinalField = $totalAttField->sum('d');
            $totalLFinalField = $totalAttField->sum('l');
            $totalMFinalField = $totalAttField->sum('m');
            $totalMXFinalField = $totalAttField->sum('mx');
            $totalSFinalField = $totalAttField->sum('s');
            $totalSXFinalField = $totalAttField->sum('sx');
            $totalIFinalField = $totalAttField->sum('i');
            $totalIPFinalField = $totalAttField->sum('ip');
            $totalIXFinalField = $totalAttField->sum('ix');
            $totalCTFinalField = $totalAttField->sum('ct');
            $totalCHFinalField = $totalAttField->sum('ch');
            $totalCBFinalField = $totalAttField->sum('cb');
            $totalCLFinalField = $totalAttField->sum('cl');

            $staffTotalField = DB::table('users')
                ->where('dept', 'Field')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalField = DB::table('users')
                ->where('dept', 'Field')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalField = DB::table('users')
                ->where('dept', 'Field')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalField = DB::table('users')
                ->where('dept', 'Field')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalField = DB::table('users')
                ->where('dept', 'Field')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttField = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'Field')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hField = $empAttField->sum('hadir');
            $total_lField = $empAttField->sum('l');
            $total_taField = $empAttField->sum('ta');
            $total_dField = $empAttField->sum('d');
            $total_mField = $empAttField->sum('m');
            $total_mxField = $empAttField->sum('mx');
            $total_sField = $empAttField->sum('s');
            $total_sxField = $empAttField->sum('sx');
            $total_iField = $empAttField->sum('i');
            $total_ipField = $empAttField->sum('ip');
            $total_ixField = $empAttField->sum('ix');
            $total_ctField = $empAttField->sum('ct');
            $total_chField = $empAttField->sum('ch');
            $total_cbField = $empAttField->sum('cb');
            $total_clField = $empAttField->sum('cl');

            // GA
            $staffAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalGA = $totalAttGA->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalGA = $totalAttGA->sum('hadir');
            $totalTAFinalGA = $totalAttGA->sum('ta');
            $totalDFinalGA = $totalAttGA->sum('d');
            $totalLFinalGA = $totalAttGA->sum('l');
            $totalMFinalGA = $totalAttGA->sum('m');
            $totalMXFinalGA = $totalAttGA->sum('mx');
            $totalSFinalGA = $totalAttGA->sum('s');
            $totalSXFinalGA = $totalAttGA->sum('sx');
            $totalIFinalGA = $totalAttGA->sum('i');
            $totalIPFinalGA = $totalAttGA->sum('ip');
            $totalIXFinalGA = $totalAttGA->sum('ix');
            $totalCTFinalGA = $totalAttGA->sum('ct');
            $totalCHFinalGA = $totalAttGA->sum('ch');
            $totalCBFinalGA = $totalAttGA->sum('cb');
            $totalCLFinalGA = $totalAttGA->sum('cl');

            $staffTotalGA = DB::table('users')
                ->where('dept', 'GA')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalGA = DB::table('users')
                ->where('dept', 'GA')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalGA = DB::table('users')
                ->where('dept', 'GA')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalGA = DB::table('users')
                ->where('dept', 'GA')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalGA = DB::table('users')
                ->where('dept', 'GA')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttGA = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'GA')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hGA = $empAttGA->sum('hadir');
            $total_lGA = $empAttGA->sum('l');
            $total_taGA = $empAttGA->sum('ta');
            $total_dGA = $empAttGA->sum('d');
            $total_mGA = $empAttGA->sum('m');
            $total_mxGA = $empAttGA->sum('mx');
            $total_sGA = $empAttGA->sum('s');
            $total_sxGA = $empAttGA->sum('sx');
            $total_iGA = $empAttGA->sum('i');
            $total_ipGA = $empAttGA->sum('ip');
            $total_ixGA = $empAttGA->sum('ix');
            $total_ctGA = $empAttGA->sum('ct');
            $total_chGA = $empAttGA->sum('ch');
            $total_cbGA = $empAttGA->sum('cb');
            $total_clGA = $empAttGA->sum('cl');

            // HSE & DP
            $staffAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalHSEDP = $totalAttHSEDP->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalHSEDP = $totalAttHSEDP->sum('hadir');
            $totalTAFinalHSEDP = $totalAttHSEDP->sum('ta');
            $totalDFinalHSEDP = $totalAttHSEDP->sum('d');
            $totalLFinalHSEDP = $totalAttHSEDP->sum('l');
            $totalMFinalHSEDP = $totalAttHSEDP->sum('m');
            $totalMXFinalHSEDP = $totalAttHSEDP->sum('mx');
            $totalSFinalHSEDP = $totalAttHSEDP->sum('s');
            $totalSXFinalHSEDP = $totalAttHSEDP->sum('sx');
            $totalIFinalHSEDP = $totalAttHSEDP->sum('i');
            $totalIPFinalHSEDP = $totalAttHSEDP->sum('ip');
            $totalIXFinalHSEDP = $totalAttHSEDP->sum('ix');
            $totalCTFinalHSEDP = $totalAttHSEDP->sum('ct');
            $totalCHFinalHSEDP = $totalAttHSEDP->sum('ch');
            $totalCBFinalHSEDP = $totalAttHSEDP->sum('cb');
            $totalCLFinalHSEDP = $totalAttHSEDP->sum('cl');

            $staffTotalHSEDP = DB::table('users')
                ->where('dept', 'HSE & DP')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalHSEDP = DB::table('users')
                ->where('dept', 'HSE & DP')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalHSEDP = DB::table('users')
                ->where('dept', 'HSE & DP')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalHSEDP = DB::table('users')
                ->where('dept', 'HSE & DP')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalHSEDP = DB::table('users')
                ->where('dept', 'HSE & DP')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttHSEDP = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'HSE & DP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hHSEDP = $empAttHSEDP->sum('hadir');
            $total_lHSEDP = $empAttHSEDP->sum('l');
            $total_taHSEDP = $empAttHSEDP->sum('ta');
            $total_dHSEDP = $empAttHSEDP->sum('d');
            $total_mHSEDP = $empAttHSEDP->sum('m');
            $total_mxHSEDP = $empAttHSEDP->sum('mx');
            $total_sHSEDP = $empAttHSEDP->sum('s');
            $total_sxHSEDP = $empAttHSEDP->sum('sx');
            $total_iHSEDP = $empAttHSEDP->sum('i');
            $total_ipHSEDP = $empAttHSEDP->sum('ip');
            $total_ixHSEDP = $empAttHSEDP->sum('ix');
            $total_ctHSEDP = $empAttHSEDP->sum('ct');
            $total_chHSEDP = $empAttHSEDP->sum('ch');
            $total_cbHSEDP = $empAttHSEDP->sum('cb');
            $total_clHSEDP = $empAttHSEDP->sum('cl');

            // I/A
            // I/B
            // I/C
            // II/D
            // II/E
            // II/F

            // IT

            // QA & QM
            $staffAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalQAQM = $totalAttQAQM->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalQAQM = $totalAttQAQM->sum('hadir');
            $totalTAFinalQAQM = $totalAttQAQM->sum('ta');
            $totalDFinalQAQM = $totalAttQAQM->sum('d');
            $totalLFinalQAQM = $totalAttQAQM->sum('l');
            $totalMFinalQAQM = $totalAttQAQM->sum('m');
            $totalMXFinalQAQM = $totalAttQAQM->sum('mx');
            $totalSFinalQAQM = $totalAttQAQM->sum('s');
            $totalSXFinalQAQM = $totalAttQAQM->sum('sx');
            $totalIFinalQAQM = $totalAttQAQM->sum('i');
            $totalIPFinalQAQM = $totalAttQAQM->sum('ip');
            $totalIXFinalQAQM = $totalAttQAQM->sum('ix');
            $totalCTFinalQAQM = $totalAttQAQM->sum('ct');
            $totalCHFinalQAQM = $totalAttQAQM->sum('ch');
            $totalCBFinalQAQM = $totalAttQAQM->sum('cb');
            $totalCLFinalQAQM = $totalAttQAQM->sum('cl');

            $staffTotalQAQM = DB::table('users')
                ->where('dept', 'QA & QM')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalQAQM = DB::table('users')
                ->where('dept', 'QA & QM')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalQAQM = DB::table('users')
                ->where('dept', 'QA & QM')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalQAQM = DB::table('users')
                ->where('dept', 'QA & QM')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalQAQM = DB::table('users')
                ->where('dept', 'QA & QM')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttQAQM = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'QA & QM')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hQAQM = $empAttQAQM->sum('hadir');
            $total_lQAQM = $empAttQAQM->sum('l');
            $total_taQAQM = $empAttQAQM->sum('ta');
            $total_dQAQM = $empAttQAQM->sum('d');
            $total_mQAQM = $empAttQAQM->sum('m');
            $total_mxQAQM = $empAttQAQM->sum('mx');
            $total_sQAQM = $empAttQAQM->sum('s');
            $total_sxQAQM = $empAttQAQM->sum('sx');
            $total_iQAQM = $empAttQAQM->sum('i');
            $total_ipQAQM = $empAttQAQM->sum('ip');
            $total_ixQAQM = $empAttQAQM->sum('ix');
            $total_ctQAQM = $empAttQAQM->sum('ct');
            $total_chQAQM = $empAttQAQM->sum('ch');
            $total_cbQAQM = $empAttQAQM->sum('cb');
            $total_clQAQM = $empAttQAQM->sum('cl');

            // Security
            $staffAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalSec = $totalAttSec->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalSec = $totalAttSec->sum('hadir');
            $totalTAFinalSec = $totalAttSec->sum('ta');
            $totalDFinalSec = $totalAttSec->sum('d');
            $totalLFinalSec = $totalAttSec->sum('l');
            $totalMFinalSec = $totalAttSec->sum('m');
            $totalMXFinalSec = $totalAttSec->sum('mx');
            $totalSFinalSec = $totalAttSec->sum('s');
            $totalSXFinalSec = $totalAttSec->sum('sx');
            $totalIFinalSec = $totalAttSec->sum('i');
            $totalIPFinalSec = $totalAttSec->sum('ip');
            $totalIXFinalSec = $totalAttSec->sum('ix');
            $totalCTFinalSec = $totalAttSec->sum('ct');
            $totalCHFinalSec = $totalAttSec->sum('ch');
            $totalCBFinalSec = $totalAttSec->sum('cb');
            $totalCLFinalSec = $totalAttSec->sum('cl');

            $staffTotalSec = DB::table('users')
                ->where('dept', 'Security')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalSec = DB::table('users')
                ->where('dept', 'Security')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalSec = DB::table('users')
                ->where('dept', 'Security')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalSec = DB::table('users')
                ->where('dept', 'Security')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalSec = DB::table('users')
                ->where('dept', 'Security')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttSec = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'Security')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hSec = $empAttSec->sum('hadir');
            $total_lSec = $empAttSec->sum('l');
            $total_taSec = $empAttSec->sum('ta');
            $total_dSec = $empAttSec->sum('d');
            $total_mSec = $empAttSec->sum('m');
            $total_mxSec = $empAttSec->sum('mx');
            $total_sSec = $empAttSec->sum('s');
            $total_sxSec = $empAttSec->sum('sx');
            $total_iSec = $empAttSec->sum('i');
            $total_ipSec = $empAttSec->sum('ip');
            $total_ixSec = $empAttSec->sum('ix');
            $total_ctSec = $empAttSec->sum('ct');
            $total_chSec = $empAttSec->sum('ch');
            $total_cbSec = $empAttSec->sum('cb');
            $total_clSec = $empAttSec->sum('cl');

            // Workshop
            $staffAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinalWs = $totalAttWs->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinalWs = $totalAttWs->sum('hadir');
            $totalTAFinalWs = $totalAttWs->sum('ta');
            $totalDFinalWs = $totalAttWs->sum('d');
            $totalLFinalWs = $totalAttWs->sum('l');
            $totalMFinalWs = $totalAttWs->sum('m');
            $totalMXFinalWs = $totalAttWs->sum('mx');
            $totalSFinalWs = $totalAttWs->sum('s');
            $totalSXFinalWs = $totalAttWs->sum('sx');
            $totalIFinalWs = $totalAttWs->sum('i');
            $totalIPFinalWs = $totalAttWs->sum('ip');
            $totalIXFinalWs = $totalAttWs->sum('ix');
            $totalCTFinalWs = $totalAttWs->sum('ct');
            $totalCHFinalWs = $totalAttWs->sum('ch');
            $totalCBFinalWs = $totalAttWs->sum('cb');
            $totalCLFinalWs = $totalAttWs->sum('cl');

            $staffTotalWs = DB::table('users')
                ->where('dept', 'Workshop')
                ->where('active', 'yes')
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotalWs = DB::table('users')
                ->where('dept', 'Workshop')
                ->where('active', 'yes')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotalWs = DB::table('users')
                ->where('dept', 'Workshop')
                ->where('active', 'yes')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotalWs = DB::table('users')
                ->where('dept', 'Workshop')
                ->where('active', 'yes')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotalWs = DB::table('users')
                ->where('dept', 'Workshop')
                ->where('active', 'yes')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAttWs = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', 'Workshop')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();

            $total_hWs = $empAttWs->sum('hadir');
            $total_lWs = $empAttWs->sum('l');
            $total_taWs = $empAttWs->sum('ta');
            $total_dWs = $empAttWs->sum('d');
            $total_mWs = $empAttWs->sum('m');
            $total_mxWs = $empAttWs->sum('mx');
            $total_sWs = $empAttWs->sum('s');
            $total_sxWs = $empAttWs->sum('sx');
            $total_iWs = $empAttWs->sum('i');
            $total_ipWs = $empAttWs->sum('ip');
            $total_ixWs = $empAttWs->sum('ix');
            $total_ctWs = $empAttWs->sum('ct');
            $total_chWs = $empAttWs->sum('ch');
            $total_cbWs = $empAttWs->sum('cb');
            $total_clWs = $empAttWs->sum('cl');

            return view(
                'admin.pages.summary-per-dept.summary-per-dept-result-anydept',
                [
                    'dept' => $dept,
                    'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime,
                    'date' => $date,
                    'staffAttIT' => $staffAttIT,
                    'monAttIT' => $monAttIT,
                    'regAttIT' => $regAttIT,
                    'flAttIT' => $flAttIT,
                    'bskpAttIT' => $bskpAttIT,
                    'staffTotalIT' => $staffTotalIT,
                    'monthlyTotalIT' => $monthlyTotalIT,
                    'regularTotalIT' => $regularTotalIT,
                    'flTotalIT' => $flTotalIT,
                    'bskpTotalIT' => $bskpTotalIT,
                    'totalHFinalIT' => $totalHFinalIT,
                    'totalTAFinalIT' => $totalTAFinalIT,
                    'totalDFinalIT' => $totalDFinalIT,
                    'totalLFinalIT' => $totalLFinalIT,
                    'totalMFinalIT' => $totalMFinalIT,
                    'totalMXFinalIT' => $totalMXFinalIT,
                    'totalSFinalIT' => $totalSFinalIT,
                    'totalSXFinalIT' => $totalSXFinalIT,
                    'totalIFinalIT' => $totalIFinalIT,
                    'totalIPFinalIT' => $totalIPFinalIT,
                    'totalIXFinalIT' => $totalIXFinalIT,
                    'totalCTFinalIT' => $totalCTFinalIT,
                    'totalCHFinalIT' => $totalCHFinalIT,
                    'totalCBFinalIT' => $totalCBFinalIT,
                    'totalCLFinalIT' => $totalCLFinalIT,
                    'empAttIT' => $empAttIT,
                    'total_hIT' => $total_hIT,
                    'total_lIT' => $total_lIT,
                    'total_taIT' => $total_taIT,
                    'total_dIT' => $total_dIT,
                    'total_mIT' => $total_mIT,
                    'total_mxIT' => $total_mxIT,
                    'total_sIT' => $total_sIT,
                    'total_sxIT' => $total_sxIT,
                    'total_iIT' => $total_iIT,
                    'total_ipIT' => $total_ipIT,
                    'total_ixIT' => $total_ixIT,
                    'total_ctIT' => $total_ctIT,
                    'total_chIT' => $total_chIT,
                    'total_cbIT' => $total_cbIT,
                    'total_clIT' => $total_clIT,
                    'staffAttHR' => $staffAttHR,
                    'monAttHR' => $monAttHR,
                    'regAttHR' => $regAttHR,
                    'flAttHR' => $flAttHR,
                    'bskpAttHR' => $bskpAttHR,
                    'staffTotalHR' => $staffTotalHR,
                    'monthlyTotalHR' => $monthlyTotalHR,
                    'regularTotalHR' => $regularTotalHR,
                    'flTotalHR' => $flTotalHR,
                    'bskpTotalHR' => $bskpTotalHR,
                    'totalHFinalHR' => $totalHFinalHR,
                    'totalTAFinalHR' => $totalTAFinalHR,
                    'totalDFinalHR' => $totalDFinalHR,
                    'totalLFinalHR' => $totalLFinalHR,
                    'totalMFinalHR' => $totalMFinalHR,
                    'totalMXFinalHR' => $totalMXFinalHR,
                    'totalSFinalHR' => $totalSFinalHR,
                    'totalSXFinalHR' => $totalSXFinalHR,
                    'totalIFinalHR' => $totalIFinalHR,
                    'totalIPFinalHR' => $totalIPFinalHR,
                    'totalIXFinalHR' => $totalIXFinalHR,
                    'totalCTFinalHR' => $totalCTFinalHR,
                    'totalCHFinalHR' => $totalCHFinalHR,
                    'totalCBFinalHR' => $totalCBFinalHR,
                    'totalCLFinalHR' => $totalCLFinalHR,
                    'empAttHR' => $empAttHR,
                    'total_hHR' => $total_hHR,
                    'total_lHR' => $total_lHR,
                    'total_taHR' => $total_taHR,
                    'total_dHR' => $total_dHR,
                    'total_mHR' => $total_mHR,
                    'total_mxHR' => $total_mxHR,
                    'total_sHR' => $total_sHR,
                    'total_sxHR' => $total_sxHR,
                    'total_iHR' => $total_iHR,
                    'total_ipHR' => $total_ipHR,
                    'total_ixHR' => $total_ixHR,
                    'total_ctHR' => $total_ctHR,
                    'total_chHR' => $total_chHR,
                    'total_cbHR' => $total_cbHR,
                    'total_clHR' => $total_clHR,
                    'staffAttAF' => $staffAttAF,
                    'monAttAF' => $monAttAF,
                    'regAttAF' => $regAttAF,
                    'flAttAF' => $flAttAF,
                    'bskpAttAF' => $bskpAttAF,
                    'staffTotalAF' => $staffTotalAF,
                    'monthlyTotalAF' => $monthlyTotalAF,
                    'regularTotalAF' => $regularTotalAF,
                    'flTotalAF' => $flTotalAF,
                    'bskpTotalAF' => $bskpTotalAF,
                    'totalHFinalAF' => $totalHFinalAF,
                    'totalTAFinalAF' => $totalTAFinalAF,
                    'totalDFinalAF' => $totalDFinalAF,
                    'totalLFinalAF' => $totalLFinalAF,
                    'totalMFinalAF' => $totalMFinalAF,
                    'totalMXFinalAF' => $totalMXFinalAF,
                    'totalSFinalAF' => $totalSFinalAF,
                    'totalSXFinalAF' => $totalSXFinalAF,
                    'totalIFinalAF' => $totalIFinalAF,
                    'totalIPFinalAF' => $totalIPFinalAF,
                    'totalIXFinalAF' => $totalIXFinalAF,
                    'totalCTFinalAF' => $totalCTFinalAF,
                    'totalCHFinalAF' => $totalCHFinalAF,
                    'totalCBFinalAF' => $totalCBFinalAF,
                    'totalCLFinalAF' => $totalCLFinalAF,
                    'empAttAF' => $empAttAF,
                    'total_hAF' => $total_hAF,
                    'total_lAF' => $total_lAF,
                    'total_taAF' => $total_taAF,
                    'total_dAF' => $total_dAF,
                    'total_mAF' => $total_mAF,
                    'total_mxAF' => $total_mxAF,
                    'total_sAF' => $total_sAF,
                    'total_sxAF' => $total_sxAF,
                    'total_iAF' => $total_iAF,
                    'total_ipAF' => $total_ipAF,
                    'total_ixAF' => $total_ixAF,
                    'total_ctAF' => $total_ctAF,
                    'total_chAF' => $total_chAF,
                    'total_cbAF' => $total_cbAF,
                    'total_clAF' => $total_clAF,
                    'staffAttBSKP' => $staffAttBSKP,
                    'monAttBSKP' => $monAttBSKP,
                    'regAttBSKP' => $regAttBSKP,
                    'flAttBSKP' => $flAttBSKP,
                    'bskpAttBSKP' => $bskpAttBSKP,
                    'staffTotalBSKP' => $staffTotalBSKP,
                    'monthlyTotalBSKP' => $monthlyTotalBSKP,
                    'regularTotalBSKP' => $regularTotalBSKP,
                    'flTotalBSKP' => $flTotalBSKP,
                    'bskpTotalBSKP' => $bskpTotalBSKP,
                    'totalHFinalBSKP' => $totalHFinalBSKP,
                    'totalTAFinalBSKP' => $totalTAFinalBSKP,
                    'totalDFinalBSKP' => $totalDFinalBSKP,
                    'totalLFinalBSKP' => $totalLFinalBSKP,
                    'totalMFinalBSKP' => $totalMFinalBSKP,
                    'totalMXFinalBSKP' => $totalMXFinalBSKP,
                    'totalSFinalBSKP' => $totalSFinalBSKP,
                    'totalSXFinalBSKP' => $totalSXFinalBSKP,
                    'totalIFinalBSKP' => $totalIFinalBSKP,
                    'totalIPFinalBSKP' => $totalIPFinalBSKP,
                    'totalIXFinalBSKP' => $totalIXFinalBSKP,
                    'totalCTFinalBSKP' => $totalCTFinalBSKP,
                    'totalCHFinalBSKP' => $totalCHFinalBSKP,
                    'totalCBFinalBSKP' => $totalCBFinalBSKP,
                    'totalCLFinalBSKP' => $totalCLFinalBSKP,
                    'empAttBSKP' => $empAttBSKP,
                    'total_hBSKP' => $total_hBSKP,
                    'total_lBSKP' => $total_lBSKP,
                    'total_taBSKP' => $total_taBSKP,
                    'total_dBSKP' => $total_dBSKP,
                    'total_mBSKP' => $total_mBSKP,
                    'total_mxBSKP' => $total_mxBSKP,
                    'total_sBSKP' => $total_sBSKP,
                    'total_sxBSKP' => $total_sxBSKP,
                    'total_iBSKP' => $total_iBSKP,
                    'total_ipBSKP' => $total_ipBSKP,
                    'total_ixBSKP' => $total_ixBSKP,
                    'total_ctBSKP' => $total_ctBSKP,
                    'total_chBSKP' => $total_chBSKP,
                    'total_cbBSKP' => $total_cbBSKP,
                    'total_clBSKP' => $total_clBSKP,
                    'staffAttField' => $staffAttField,
                    'monAttField' => $monAttField,
                    'regAttField' => $regAttField,
                    'flAttField' => $flAttField,
                    'bskpAttField' => $bskpAttField,
                    'staffTotalField' => $staffTotalField,
                    'monthlyTotalField' => $monthlyTotalField,
                    'regularTotalField' => $regularTotalField,
                    'flTotalField' => $flTotalField,
                    'bskpTotalField' => $bskpTotalField,
                    'totalHFinalField' => $totalHFinalField,
                    'totalTAFinalField' => $totalTAFinalField,
                    'totalDFinalField' => $totalDFinalField,
                    'totalLFinalField' => $totalLFinalField,
                    'totalMFinalField' => $totalMFinalField,
                    'totalMXFinalField' => $totalMXFinalField,
                    'totalSFinalField' => $totalSFinalField,
                    'totalSXFinalField' => $totalSXFinalField,
                    'totalIFinalField' => $totalIFinalField,
                    'totalIPFinalField' => $totalIPFinalField,
                    'totalIXFinalField' => $totalIXFinalField,
                    'totalCTFinalField' => $totalCTFinalField,
                    'totalCHFinalField' => $totalCHFinalField,
                    'totalCBFinalField' => $totalCBFinalField,
                    'totalCLFinalField' => $totalCLFinalField,
                    'empAttField' => $empAttField,
                    'total_hField' => $total_hField,
                    'total_lField' => $total_lField,
                    'total_taField' => $total_taField,
                    'total_dField' => $total_dField,
                    'total_mField' => $total_mField,
                    'total_mxField' => $total_mxField,
                    'total_sField' => $total_sField,
                    'total_sxField' => $total_sxField,
                    'total_iField' => $total_iField,
                    'total_ipField' => $total_ipField,
                    'total_ixField' => $total_ixField,
                    'total_ctField' => $total_ctField,
                    'total_chField' => $total_chField,
                    'total_cbField' => $total_cbField,
                    'total_clField' => $total_clField,
                    'staffAttGA' => $staffAttGA,
                    'monAttGA' => $monAttGA,
                    'regAttGA' => $regAttGA,
                    'flAttGA' => $flAttGA,
                    'bskpAttGA' => $bskpAttGA,
                    'staffTotalGA' => $staffTotalGA,
                    'monthlyTotalGA' => $monthlyTotalGA,
                    'regularTotalGA' => $regularTotalGA,
                    'flTotalGA' => $flTotalGA,
                    'bskpTotalGA' => $bskpTotalGA,
                    'totalHFinalGA' => $totalHFinalGA,
                    'totalTAFinalGA' => $totalTAFinalGA,
                    'totalDFinalGA' => $totalDFinalGA,
                    'totalLFinalGA' => $totalLFinalGA,
                    'totalMFinalGA' => $totalMFinalGA,
                    'totalMXFinalGA' => $totalMXFinalGA,
                    'totalSFinalGA' => $totalSFinalGA,
                    'totalSXFinalGA' => $totalSXFinalGA,
                    'totalIFinalGA' => $totalIFinalGA,
                    'totalIPFinalGA' => $totalIPFinalGA,
                    'totalIXFinalGA' => $totalIXFinalGA,
                    'totalCTFinalGA' => $totalCTFinalGA,
                    'totalCHFinalGA' => $totalCHFinalGA,
                    'totalCBFinalGA' => $totalCBFinalGA,
                    'totalCLFinalGA' => $totalCLFinalGA,
                    'empAttGA' => $empAttGA,
                    'total_hGA' => $total_hGA,
                    'total_lGA' => $total_lGA,
                    'total_taGA' => $total_taGA,
                    'total_dGA' => $total_dGA,
                    'total_mGA' => $total_mGA,
                    'total_mxGA' => $total_mxGA,
                    'total_sGA' => $total_sGA,
                    'total_sxGA' => $total_sxGA,
                    'total_iGA' => $total_iGA,
                    'total_ipGA' => $total_ipGA,
                    'total_ixGA' => $total_ixGA,
                    'total_ctGA' => $total_ctGA,
                    'total_chGA' => $total_chGA,
                    'total_cbGA' => $total_cbGA,
                    'total_clGA' => $total_clGA,
                    'staffAttHSEDP' => $staffAttHSEDP,
                    'monAttHSEDP' => $monAttHSEDP,
                    'regAttHSEDP' => $regAttHSEDP,
                    'flAttHSEDP' => $flAttHSEDP,
                    'bskpAttHSEDP' => $bskpAttHSEDP,
                    'staffTotalHSEDP' => $staffTotalHSEDP,
                    'monthlyTotalHSEDP' => $monthlyTotalHSEDP,
                    'regularTotalHSEDP' => $regularTotalHSEDP,
                    'flTotalHSEDP' => $flTotalHSEDP,
                    'bskpTotalHSEDP' => $bskpTotalHSEDP,
                    'totalHFinalHSEDP' => $totalHFinalHSEDP,
                    'totalTAFinalHSEDP' => $totalTAFinalHSEDP,
                    'totalDFinalHSEDP' => $totalDFinalHSEDP,
                    'totalLFinalHSEDP' => $totalLFinalHSEDP,
                    'totalMFinalHSEDP' => $totalMFinalHSEDP,
                    'totalMXFinalHSEDP' => $totalMXFinalHSEDP,
                    'totalSFinalHSEDP' => $totalSFinalHSEDP,
                    'totalSXFinalHSEDP' => $totalSXFinalHSEDP,
                    'totalIFinalHSEDP' => $totalIFinalHSEDP,
                    'totalIPFinalHSEDP' => $totalIPFinalHSEDP,
                    'totalIXFinalHSEDP' => $totalIXFinalHSEDP,
                    'totalCTFinalHSEDP' => $totalCTFinalHSEDP,
                    'totalCHFinalHSEDP' => $totalCHFinalHSEDP,
                    'totalCBFinalHSEDP' => $totalCBFinalHSEDP,
                    'totalCLFinalHSEDP' => $totalCLFinalHSEDP,
                    'empAttHSEDP' => $empAttHSEDP,
                    'total_hHSEDP' => $total_hHSEDP,
                    'total_lHSEDP' => $total_lHSEDP,
                    'total_taHSEDP' => $total_taHSEDP,
                    'total_dHSEDP' => $total_dHSEDP,
                    'total_mHSEDP' => $total_mHSEDP,
                    'total_mxHSEDP' => $total_mxHSEDP,
                    'total_sHSEDP' => $total_sHSEDP,
                    'total_sxHSEDP' => $total_sxHSEDP,
                    'total_iHSEDP' => $total_iHSEDP,
                    'total_ipHSEDP' => $total_ipHSEDP,
                    'total_ixHSEDP' => $total_ixHSEDP,
                    'total_ctHSEDP' => $total_ctHSEDP,
                    'total_chHSEDP' => $total_chHSEDP,
                    'total_cbHSEDP' => $total_cbHSEDP,
                    'total_clHSEDP' => $total_clHSEDP,
                    'staffAttQAQM' => $staffAttQAQM,
                    'monAttQAQM' => $monAttQAQM,
                    'regAttQAQM' => $regAttQAQM,
                    'flAttQAQM' => $flAttQAQM,
                    'bskpAttQAQM' => $bskpAttQAQM,
                    'staffTotalQAQM' => $staffTotalQAQM,
                    'monthlyTotalQAQM' => $monthlyTotalQAQM,
                    'regularTotalQAQM' => $regularTotalQAQM,
                    'flTotalQAQM' => $flTotalQAQM,
                    'bskpTotalQAQM' => $bskpTotalQAQM,
                    'totalHFinalQAQM' => $totalHFinalQAQM,
                    'totalTAFinalQAQM' => $totalTAFinalQAQM,
                    'totalDFinalQAQM' => $totalDFinalQAQM,
                    'totalLFinalQAQM' => $totalLFinalQAQM,
                    'totalMFinalQAQM' => $totalMFinalQAQM,
                    'totalMXFinalQAQM' => $totalMXFinalQAQM,
                    'totalSFinalQAQM' => $totalSFinalQAQM,
                    'totalSXFinalQAQM' => $totalSXFinalQAQM,
                    'totalIFinalQAQM' => $totalIFinalQAQM,
                    'totalIPFinalQAQM' => $totalIPFinalQAQM,
                    'totalIXFinalQAQM' => $totalIXFinalQAQM,
                    'totalCTFinalQAQM' => $totalCTFinalQAQM,
                    'totalCHFinalQAQM' => $totalCHFinalQAQM,
                    'totalCBFinalQAQM' => $totalCBFinalQAQM,
                    'totalCLFinalQAQM' => $totalCLFinalQAQM,
                    'empAttQAQM' => $empAttQAQM,
                    'total_hQAQM' => $total_hQAQM,
                    'total_lQAQM' => $total_lQAQM,
                    'total_taQAQM' => $total_taQAQM,
                    'total_dQAQM' => $total_dQAQM,
                    'total_mQAQM' => $total_mQAQM,
                    'total_mxQAQM' => $total_mxQAQM,
                    'total_sQAQM' => $total_sQAQM,
                    'total_sxQAQM' => $total_sxQAQM,
                    'total_iQAQM' => $total_iQAQM,
                    'total_ipQAQM' => $total_ipQAQM,
                    'total_ixQAQM' => $total_ixQAQM,
                    'total_ctQAQM' => $total_ctQAQM,
                    'total_chQAQM' => $total_chQAQM,
                    'total_cbQAQM' => $total_cbQAQM,
                    'total_clQAQM' => $total_clQAQM,
                    'staffAttSec' => $staffAttSec,
                    'monAttSec' => $monAttSec,
                    'regAttSec' => $regAttSec,
                    'flAttSec' => $flAttSec,
                    'bskpAttSec' => $bskpAttSec,
                    'staffTotalSec' => $staffTotalSec,
                    'monthlyTotalSec' => $monthlyTotalSec,
                    'regularTotalSec' => $regularTotalSec,
                    'flTotalSec' => $flTotalSec,
                    'bskpTotalSec' => $bskpTotalSec,
                    'totalHFinalSec' => $totalHFinalSec,
                    'totalTAFinalSec' => $totalTAFinalSec,
                    'totalDFinalSec' => $totalDFinalSec,
                    'totalLFinalSec' => $totalLFinalSec,
                    'totalMFinalSec' => $totalMFinalSec,
                    'totalMXFinalSec' => $totalMXFinalSec,
                    'totalSFinalSec' => $totalSFinalSec,
                    'totalSXFinalSec' => $totalSXFinalSec,
                    'totalIFinalSec' => $totalIFinalSec,
                    'totalIPFinalSec' => $totalIPFinalSec,
                    'totalIXFinalSec' => $totalIXFinalSec,
                    'totalCTFinalSec' => $totalCTFinalSec,
                    'totalCHFinalSec' => $totalCHFinalSec,
                    'totalCBFinalSec' => $totalCBFinalSec,
                    'totalCLFinalSec' => $totalCLFinalSec,
                    'empAttSec' => $empAttSec,
                    'total_hSec' => $total_hSec,
                    'total_lSec' => $total_lSec,
                    'total_taSec' => $total_taSec,
                    'total_dSec' => $total_dSec,
                    'total_mSec' => $total_mSec,
                    'total_mxSec' => $total_mxSec,
                    'total_sSec' => $total_sSec,
                    'total_sxSec' => $total_sxSec,
                    'total_iSec' => $total_iSec,
                    'total_ipSec' => $total_ipSec,
                    'total_ixSec' => $total_ixSec,
                    'total_ctSec' => $total_ctSec,
                    'total_chSec' => $total_chSec,
                    'total_cbSec' => $total_cbSec,
                    'total_clSec' => $total_clSec,
                    'staffAttWs' => $staffAttWs,
                    'monAttWs' => $monAttWs,
                    'regAttWs' => $regAttWs,
                    'flAttWs' => $flAttWs,
                    'bskpAttWs' => $bskpAttWs,
                    'staffTotalWs' => $staffTotalWs,
                    'monthlyTotalWs' => $monthlyTotalWs,
                    'regularTotalWs' => $regularTotalWs,
                    'flTotalWs' => $flTotalWs,
                    'bskpTotalWs' => $bskpTotalWs,
                    'totalHFinalWs' => $totalHFinalWs,
                    'totalTAFinalWs' => $totalTAFinalWs,
                    'totalDFinalWs' => $totalDFinalWs,
                    'totalLFinalWs' => $totalLFinalWs,
                    'totalMFinalWs' => $totalMFinalWs,
                    'totalMXFinalWs' => $totalMXFinalWs,
                    'totalSFinalWs' => $totalSFinalWs,
                    'totalSXFinalWs' => $totalSXFinalWs,
                    'totalIFinalWs' => $totalIFinalWs,
                    'totalIPFinalWs' => $totalIPFinalWs,
                    'totalIXFinalWs' => $totalIXFinalWs,
                    'totalCTFinalWs' => $totalCTFinalWs,
                    'totalCHFinalWs' => $totalCHFinalWs,
                    'totalCBFinalWs' => $totalCBFinalWs,
                    'totalCLFinalWs' => $totalCLFinalWs,
                    'empAttWs' => $empAttWs,
                    'total_hWs' => $total_hWs,
                    'total_lWs' => $total_lWs,
                    'total_taWs' => $total_taWs,
                    'total_dWs' => $total_dWs,
                    'total_mWs' => $total_mWs,
                    'total_mxWs' => $total_mxWs,
                    'total_sWs' => $total_sWs,
                    'total_sxWs' => $total_sxWs,
                    'total_iWs' => $total_iWs,
                    'total_ipWs' => $total_ipWs,
                    'total_ixWs' => $total_ixWs,
                    'total_ctWs' => $total_ctWs,
                    'total_chWs' => $total_chWs,
                    'total_cbWs' => $total_cbWs,
                    'total_clWs' => $total_clWs,
                    'staffAttFSD' => $staffAttFSD,
                    'monAttFSD' => $monAttFSD,
                    'regAttFSD' => $regAttFSD,
                    'flAttFSD' => $flAttFSD,
                    'bskpAttFSD' => $bskpAttFSD,
                    'staffTotalFSD' => $staffTotalFSD,
                    'monthlyTotalFSD' => $monthlyTotalFSD,
                    'regularTotalFSD' => $regularTotalFSD,
                    'flTotalFSD' => $flTotalFSD,
                    'bskpTotalFSD' => $bskpTotalFSD,
                    'totalHFinalFSD' => $totalHFinalFSD,
                    'totalTAFinalFSD' => $totalTAFinalFSD,
                    'totalDFinalFSD' => $totalDFinalFSD,
                    'totalLFinalFSD' => $totalLFinalFSD,
                    'totalMFinalFSD' => $totalMFinalFSD,
                    'totalMXFinalFSD' => $totalMXFinalFSD,
                    'totalSFinalFSD' => $totalSFinalFSD,
                    'totalSXFinalFSD' => $totalSXFinalFSD,
                    'totalIFinalFSD' => $totalIFinalFSD,
                    'totalIPFinalFSD' => $totalIPFinalFSD,
                    'totalIXFinalFSD' => $totalIXFinalFSD,
                    'totalCTFinalFSD' => $totalCTFinalFSD,
                    'totalCHFinalFSD' => $totalCHFinalFSD,
                    'totalCBFinalFSD' => $totalCBFinalFSD,
                    'totalCLFinalFSD' => $totalCLFinalFSD,
                    'empAttFSD' => $empAttFSD,
                    'total_hFSD' => $total_hFSD,
                    'total_lFSD' => $total_lFSD,
                    'total_taFSD' => $total_taFSD,
                    'total_dFSD' => $total_dFSD,
                    'total_mFSD' => $total_mFSD,
                    'total_mxFSD' => $total_mxFSD,
                    'total_sFSD' => $total_sFSD,
                    'total_sxFSD' => $total_sxFSD,
                    'total_iFSD' => $total_iFSD,
                    'total_ipFSD' => $total_ipFSD,
                    'total_ixFSD' => $total_ixFSD,
                    'total_ctFSD' => $total_ctFSD,
                    'total_chFSD' => $total_chFSD,
                    'total_cbFSD' => $total_cbFSD,
                    'total_clFSD' => $total_clFSD,
                    'data' => $data,
                    'totalRegularTotal1' => $totalRegularTotal1,
                    'totalFlTotal1' => $totalFlTotal1,
                    'totalHTotalReg' => $totalHTotalReg,
                    'totalTATotalReg' => $totalTATotalReg,
                    'totalDTotalReg' => $totalDTotalReg,
                    'totalLTotalReg' => $totalLTotalReg,
                    'totalMTotalReg' => $totalMTotalReg,
                    'totalMXTotalReg' => $totalMXTotalReg,
                    'totalSTotalReg' => $totalSTotalReg,
                    'totalSXTotalReg' => $totalSXTotalReg,
                    'totalITotalReg' => $totalITotalReg,
                    'totalIPTotalReg' => $totalIPTotalReg,
                    'totalIXTotalReg' => $totalIXTotalReg,
                    'totalCTTotalReg' => $totalCTTotalReg,
                    'totalCHTotalReg' => $totalCHTotalReg,
                    'totalCBTotalReg' => $totalCBTotalReg,
                    'totalCLTotalReg' => $totalCLTotalReg,
                    'totalHTotalFl' => $totalHTotalFl,
                    'totalTATotalFl' => $totalTATotalFl,
                    'totalDTotalFl' => $totalDTotalFl,
                    'totalLTotalFl' => $totalLTotalFl,
                    'totalMTotalFl' => $totalMTotalFl,
                    'totalMXTotalFl' => $totalMXTotalFl,
                    'totalSTotalFl' => $totalSTotalFl,
                    'totalSXTotalFl' => $totalSXTotalFl,
                    'totalITotalFl' => $totalITotalFl,
                    'totalIPTotalFl' => $totalIPTotalFl,
                    'totalIXTotalFl' => $totalIXTotalFl,
                    'totalCTTotalFl' => $totalCTTotalFl,
                    'totalCHTotalFl' => $totalCHTotalFl,
                    'totalCBTotalFl' => $totalCBTotalFl,
                    'totalCLTotalFl' => $totalCLTotalFl,
                    'staffAttB' => $staffAttB,
                    'monAttB' => $monAttB,
                    'regAttB' => $regAttB,
                    'flAttB' => $flAttB,
                    'bskpAttB' => $bskpAttB,
                    'staffTotalB' => $staffTotalB,
                    'monthlyTotalB' => $monthlyTotalB,
                    'regularTotalB' => $regularTotalB,
                    'flTotalB' => $flTotalB,
                    'bskpTotalB' => $bskpTotalB,
                    'totalHFinalB' => $totalHFinalB,
                    'totalTAFinalB' => $totalTAFinalB,
                    'totalDFinalB' => $totalDFinalB,
                    'totalLFinalB' => $totalLFinalB,
                    'totalMFinalB' => $totalMFinalB,
                    'totalMXFinalB' => $totalMXFinalB,
                    'totalSFinalB' => $totalSFinalB,
                    'totalSXFinalB' => $totalSXFinalB,
                    'totalIFinalB' => $totalIFinalB,
                    'totalIPFinalB' => $totalIPFinalB,
                    'totalIXFinalB' => $totalIXFinalB,
                    'totalCTFinalB' => $totalCTFinalB,
                    'totalCHFinalB' => $totalCHFinalB,
                    'totalCBFinalB' => $totalCBFinalB,
                    'totalCLFinalB' => $totalCLFinalB,
                    'empAttB' => $empAttB,
                    'total_hB' => $total_hB,
                    'total_lB' => $total_lB,
                    'total_taB' => $total_taB,
                    'total_dB' => $total_dB,
                    'total_mB' => $total_mB,
                    'total_mxB' => $total_mxB,
                    'total_sB' => $total_sB,
                    'total_sxB' => $total_sxB,
                    'total_iB' => $total_iB,
                    'total_ipB' => $total_ipB,
                    'total_ixB' => $total_ixB,
                    'total_ctB' => $total_ctB,
                    'total_chB' => $total_chB,
                    'total_cbB' => $total_cbB,
                    'total_clB' => $total_clB,
                    'dataD' => $dataD,
                    'totalRegularTotal1D' => $totalRegularTotal1D,
                    'totalFlTotal1D' => $totalFlTotal1D,
                    'totalHTotalRegD' => $totalHTotalRegD,
                    'totalTATotalRegD' => $totalTATotalRegD,
                    'totalDTotalRegD' => $totalDTotalRegD,
                    'totalLTotalRegD' => $totalLTotalRegD,
                    'totalMTotalRegD' => $totalMTotalRegD,
                    'totalMXTotalRegD' => $totalMXTotalRegD,
                    'totalSTotalRegD' => $totalSTotalRegD,
                    'totalSXTotalRegD' => $totalSXTotalRegD,
                    'totalITotalRegD' => $totalITotalRegD,
                    'totalIPTotalRegD' => $totalIPTotalRegD,
                    'totalIXTotalRegD' => $totalIXTotalRegD,
                    'totalCTTotalRegD' => $totalCTTotalRegD,
                    'totalCHTotalRegD' => $totalCHTotalRegD,
                    'totalCBTotalRegD' => $totalCBTotalRegD,
                    'totalCLTotalRegD' => $totalCLTotalRegD,
                    'totalHTotalFlD' => $totalHTotalFlD,
                    'totalTATotalFlD' => $totalTATotalFlD,
                    'totalDTotalFlD' => $totalDTotalFlD,
                    'totalLTotalFlD' => $totalLTotalFlD,
                    'totalMTotalFlD' => $totalMTotalFlD,
                    'totalMXTotalFlD' => $totalMXTotalFlD,
                    'totalSTotalFlD' => $totalSTotalFlD,
                    'totalSXTotalFlD' => $totalSXTotalFlD,
                    'totalITotalFlD' => $totalITotalFlD,
                    'totalIPTotalFlD' => $totalIPTotalFlD,
                    'totalIXTotalFlD' => $totalIXTotalFlD,
                    'totalCTTotalFlD' => $totalCTTotalFlD,
                    'totalCHTotalFlD' => $totalCHTotalFlD,
                    'totalCBTotalFlD' => $totalCBTotalFlD,
                    'totalCLTotalFlD' => $totalCLTotalFlD,
                    'staffAttD' => $staffAttD,
                    'monAttD' => $monAttD,
                    'regAttD' => $regAttD,
                    'flAttD' => $flAttD,
                    'bskpAttD' => $bskpAttD,
                    'staffTotalD' => $staffTotalD,
                    'monthlyTotalD' => $monthlyTotalD,
                    'regularTotalD' => $regularTotalD,
                    'flTotalD' => $flTotalD,
                    'bskpTotalD' => $bskpTotalD,
                    'totalHFinalD' => $totalHFinalD,
                    'totalTAFinalD' => $totalTAFinalD,
                    'totalDFinalD' => $totalDFinalD,
                    'totalLFinalD' => $totalLFinalD,
                    'totalMFinalD' => $totalMFinalD,
                    'totalMXFinalD' => $totalMXFinalD,
                    'totalSFinalD' => $totalSFinalD,
                    'totalSXFinalD' => $totalSXFinalD,
                    'totalIFinalD' => $totalIFinalD,
                    'totalIPFinalD' => $totalIPFinalD,
                    'totalIXFinalD' => $totalIXFinalD,
                    'totalCTFinalD' => $totalCTFinalD,
                    'totalCHFinalD' => $totalCHFinalD,
                    'totalCBFinalD' => $totalCBFinalD,
                    'totalCLFinalD' => $totalCLFinalD,
                    'empAttD' => $empAttD,
                    'total_hD' => $total_hD,
                    'total_lD' => $total_lD,
                    'total_taD' => $total_taD,
                    'total_dD' => $total_dD,
                    'total_mD' => $total_mD,
                    'total_mxD' => $total_mxD,
                    'total_sD' => $total_sD,
                    'total_sxD' => $total_sxD,
                    'total_iD' => $total_iD,
                    'total_ipD' => $total_ipD,
                    'total_ixD' => $total_ixD,
                    'total_ctD' => $total_ctD,
                    'total_chD' => $total_chD,
                    'total_cbD' => $total_cbD,
                    'total_clD' => $total_clD,
                    'dataA' => $dataA,
                    'totalRegularTotal1A' => $totalRegularTotal1A,
                    'totalFlTotal1A' => $totalFlTotal1A,
                    'totalHTotalRegA' => $totalHTotalRegA,
                    'totalTATotalRegA' => $totalTATotalRegA,
                    'totalDTotalRegA' => $totalDTotalRegA,
                    'totalLTotalRegA' => $totalLTotalRegA,
                    'totalMTotalRegA' => $totalMTotalRegA,
                    'totalMXTotalRegA' => $totalMXTotalRegA,
                    'totalSTotalRegA' => $totalSTotalRegA,
                    'totalSXTotalRegA' => $totalSXTotalRegA,
                    'totalITotalRegA' => $totalITotalRegA,
                    'totalIPTotalRegA' => $totalIPTotalRegA,
                    'totalIXTotalRegA' => $totalIXTotalRegA,
                    'totalCTTotalRegA' => $totalCTTotalRegA,
                    'totalCHTotalRegA' => $totalCHTotalRegA,
                    'totalCBTotalRegA' => $totalCBTotalRegA,
                    'totalCLTotalRegA' => $totalCLTotalRegA,
                    'totalHTotalFlA' => $totalHTotalFlA,
                    'totalTATotalFlA' => $totalTATotalFlA,
                    'totalDTotalFlA' => $totalDTotalFlA,
                    'totalLTotalFlA' => $totalLTotalFlA,
                    'totalMTotalFlA' => $totalMTotalFlA,
                    'totalMXTotalFlA' => $totalMXTotalFlA,
                    'totalSTotalFlA' => $totalSTotalFlA,
                    'totalSXTotalFlA' => $totalSXTotalFlA,
                    'totalITotalFlA' => $totalITotalFlA,
                    'totalIPTotalFlA' => $totalIPTotalFlA,
                    'totalIXTotalFlA' => $totalIXTotalFlA,
                    'totalCTTotalFlA' => $totalCTTotalFlA,
                    'totalCHTotalFlA' => $totalCHTotalFlA,
                    'totalCBTotalFlA' => $totalCBTotalFlA,
                    'totalCLTotalFlA' => $totalCLTotalFlA,
                    'staffAttA' => $staffAttA,
                    'monAttA' => $monAttA,
                    'regAttA' => $regAttA,
                    'flAttA' => $flAttA,
                    'bskpAttA' => $bskpAttA,
                    'staffTotalA' => $staffTotalA,
                    'monthlyTotalA' => $monthlyTotalA,
                    'regularTotalA' => $regularTotalA,
                    'flTotalA' => $flTotalA,
                    'bskpTotalA' => $bskpTotalA,
                    'totalHFinalA' => $totalHFinalA,
                    'totalTAFinalA' => $totalTAFinalA,
                    'totalDFinalA' => $totalDFinalA,
                    'totalLFinalA' => $totalLFinalA,
                    'totalMFinalA' => $totalMFinalA,
                    'totalMXFinalA' => $totalMXFinalA,
                    'totalSFinalA' => $totalSFinalA,
                    'totalSXFinalA' => $totalSXFinalA,
                    'totalIFinalA' => $totalIFinalA,
                    'totalIPFinalA' => $totalIPFinalA,
                    'totalIXFinalA' => $totalIXFinalA,
                    'totalCTFinalA' => $totalCTFinalA,
                    'totalCHFinalA' => $totalCHFinalA,
                    'totalCBFinalA' => $totalCBFinalA,
                    'totalCLFinalA' => $totalCLFinalA,
                    'empAttA' => $empAttA,
                    'total_hA' => $total_hA,
                    'total_lA' => $total_lA,
                    'total_taA' => $total_taA,
                    'total_dA' => $total_dA,
                    'total_mA' => $total_mA,
                    'total_mxA' => $total_mxA,
                    'total_sA' => $total_sA,
                    'total_sxA' => $total_sxA,
                    'total_iA' => $total_iA,
                    'total_ipA' => $total_ipA,
                    'total_ixA' => $total_ixA,
                    'total_ctA' => $total_ctA,
                    'total_chA' => $total_chA,
                    'total_cbA' => $total_cbA,
                    'total_clA' => $total_clA,
                    'dataC' => $dataC,
                    'totalRegularTotal1C' => $totalRegularTotal1C,
                    'totalFlTotal1C' => $totalFlTotal1C,
                    'totalHTotalRegC' => $totalHTotalRegC,
                    'totalTATotalRegC' => $totalTATotalRegC,
                    'totalDTotalRegC' => $totalDTotalRegC,
                    'totalLTotalRegC' => $totalLTotalRegC,
                    'totalMTotalRegC' => $totalMTotalRegC,
                    'totalMXTotalRegC' => $totalMXTotalRegC,
                    'totalSTotalRegC' => $totalSTotalRegC,
                    'totalSXTotalRegC' => $totalSXTotalRegC,
                    'totalITotalRegC' => $totalITotalRegC,
                    'totalIPTotalRegC' => $totalIPTotalRegC,
                    'totalIXTotalRegC' => $totalIXTotalRegC,
                    'totalCTTotalRegC' => $totalCTTotalRegC,
                    'totalCHTotalRegC' => $totalCHTotalRegC,
                    'totalCBTotalRegC' => $totalCBTotalRegC,
                    'totalCLTotalRegC' => $totalCLTotalRegC,
                    'totalHTotalFlC' => $totalHTotalFlC,
                    'totalTATotalFlC' => $totalTATotalFlC,
                    'totalDTotalFlC' => $totalDTotalFlC,
                    'totalLTotalFlC' => $totalLTotalFlC,
                    'totalMTotalFlC' => $totalMTotalFlC,
                    'totalMXTotalFlC' => $totalMXTotalFlC,
                    'totalSTotalFlC' => $totalSTotalFlC,
                    'totalSXTotalFlC' => $totalSXTotalFlC,
                    'totalITotalFlC' => $totalITotalFlC,
                    'totalIPTotalFlC' => $totalIPTotalFlC,
                    'totalIXTotalFlC' => $totalIXTotalFlC,
                    'totalCTTotalFlC' => $totalCTTotalFlC,
                    'totalCHTotalFlC' => $totalCHTotalFlC,
                    'totalCBTotalFlC' => $totalCBTotalFlC,
                    'totalCLTotalFlC' => $totalCLTotalFlC,
                    'staffAttC' => $staffAttC,
                    'monAttC' => $monAttC,
                    'regAttC' => $regAttC,
                    'flAttC' => $flAttC,
                    'bskpAttC' => $bskpAttC,
                    'staffTotalC' => $staffTotalC,
                    'monthlyTotalC' => $monthlyTotalC,
                    'regularTotalC' => $regularTotalC,
                    'flTotalC' => $flTotalC,
                    'bskpTotalC' => $bskpTotalC,
                    'totalHFinalC' => $totalHFinalC,
                    'totalTAFinalC' => $totalTAFinalC,
                    'totalDFinalC' => $totalDFinalC,
                    'totalLFinalC' => $totalLFinalC,
                    'totalMFinalC' => $totalMFinalC,
                    'totalMXFinalC' => $totalMXFinalC,
                    'totalSFinalC' => $totalSFinalC,
                    'totalSXFinalC' => $totalSXFinalC,
                    'totalIFinalC' => $totalIFinalC,
                    'totalIPFinalC' => $totalIPFinalC,
                    'totalIXFinalC' => $totalIXFinalC,
                    'totalCTFinalC' => $totalCTFinalC,
                    'totalCHFinalC' => $totalCHFinalC,
                    'totalCBFinalC' => $totalCBFinalC,
                    'totalCLFinalC' => $totalCLFinalC,
                    'empAttC' => $empAttC,
                    'total_hC' => $total_hC,
                    'total_lC' => $total_lC,
                    'total_taC' => $total_taC,
                    'total_dC' => $total_dC,
                    'total_mC' => $total_mC,
                    'total_mxC' => $total_mxC,
                    'total_sC' => $total_sC,
                    'total_sxC' => $total_sxC,
                    'total_iC' => $total_iC,
                    'total_ipC' => $total_ipC,
                    'total_ixC' => $total_ixC,
                    'total_ctC' => $total_ctC,
                    'total_chC' => $total_chC,
                    'total_cbC' => $total_cbC,
                    'total_clC' => $total_clC,
                    'dataE' => $dataE,
                    'totalRegularTotal1E' => $totalRegularTotal1E,
                    'totalFlTotal1E' => $totalFlTotal1E,
                    'totalHTotalRegE' => $totalHTotalRegE,
                    'totalTATotalRegE' => $totalTATotalRegE,
                    'totalDTotalRegE' => $totalDTotalRegE,
                    'totalLTotalRegE' => $totalLTotalRegE,
                    'totalMTotalRegE' => $totalMTotalRegE,
                    'totalMXTotalRegE' => $totalMXTotalRegE,
                    'totalSTotalRegE' => $totalSTotalRegE,
                    'totalSXTotalRegE' => $totalSXTotalRegE,
                    'totalITotalRegE' => $totalITotalRegE,
                    'totalIPTotalRegE' => $totalIPTotalRegE,
                    'totalIXTotalRegE' => $totalIXTotalRegE,
                    'totalCTTotalRegE' => $totalCTTotalRegE,
                    'totalCHTotalRegE' => $totalCHTotalRegE,
                    'totalCBTotalRegE' => $totalCBTotalRegE,
                    'totalCLTotalRegE' => $totalCLTotalRegE,
                    'totalHTotalFlE' => $totalHTotalFlE,
                    'totalTATotalFlE' => $totalTATotalFlE,
                    'totalDTotalFlE' => $totalDTotalFlE,
                    'totalLTotalFlE' => $totalLTotalFlE,
                    'totalMTotalFlE' => $totalMTotalFlE,
                    'totalMXTotalFlE' => $totalMXTotalFlE,
                    'totalSTotalFlE' => $totalSTotalFlE,
                    'totalSXTotalFlE' => $totalSXTotalFlE,
                    'totalITotalFlE' => $totalITotalFlE,
                    'totalIPTotalFlE' => $totalIPTotalFlE,
                    'totalIXTotalFlE' => $totalIXTotalFlE,
                    'totalCTTotalFlE' => $totalCTTotalFlE,
                    'totalCHTotalFlE' => $totalCHTotalFlE,
                    'totalCBTotalFlE' => $totalCBTotalFlE,
                    'totalCLTotalFlE' => $totalCLTotalFlE,
                    'staffAttE' => $staffAttE,
                    'monAttE' => $monAttE,
                    'regAttE' => $regAttE,
                    'flAttE' => $flAttE,
                    'bskpAttE' => $bskpAttE,
                    'staffTotalE' => $staffTotalE,
                    'monthlyTotalE' => $monthlyTotalE,
                    'regularTotalE' => $regularTotalE,
                    'flTotalE' => $flTotalE,
                    'bskpTotalE' => $bskpTotalE,
                    'totalHFinalE' => $totalHFinalE,
                    'totalTAFinalE' => $totalTAFinalE,
                    'totalDFinalE' => $totalDFinalE,
                    'totalLFinalE' => $totalLFinalE,
                    'totalMFinalE' => $totalMFinalE,
                    'totalMXFinalE' => $totalMXFinalE,
                    'totalSFinalE' => $totalSFinalE,
                    'totalSXFinalE' => $totalSXFinalE,
                    'totalIFinalE' => $totalIFinalE,
                    'totalIPFinalE' => $totalIPFinalE,
                    'totalIXFinalE' => $totalIXFinalE,
                    'totalCTFinalE' => $totalCTFinalE,
                    'totalCHFinalE' => $totalCHFinalE,
                    'totalCBFinalE' => $totalCBFinalE,
                    'totalCLFinalE' => $totalCLFinalE,
                    'empAttE' => $empAttE,
                    'total_hE' => $total_hE,
                    'total_lE' => $total_lE,
                    'total_taE' => $total_taE,
                    'total_dE' => $total_dE,
                    'total_mE' => $total_mE,
                    'total_mxE' => $total_mxE,
                    'total_sE' => $total_sE,
                    'total_sxE' => $total_sxE,
                    'total_iE' => $total_iE,
                    'total_ipE' => $total_ipE,
                    'total_ixE' => $total_ixE,
                    'total_ctE' => $total_ctE,
                    'total_chE' => $total_chE,
                    'total_cbE' => $total_cbE,
                    'total_clE' => $total_clE,
                    'dataF' => $dataF,
                    'totalRegularTotal1F' => $totalRegularTotal1F,
                    'totalFlTotal1F' => $totalFlTotal1F,
                    'totalHTotalRegF' => $totalHTotalRegF,
                    'totalTATotalRegF' => $totalTATotalRegF,
                    'totalDTotalRegF' => $totalDTotalRegF,
                    'totalLTotalRegF' => $totalLTotalRegF,
                    'totalMTotalRegF' => $totalMTotalRegF,
                    'totalMXTotalRegF' => $totalMXTotalRegF,
                    'totalSTotalRegF' => $totalSTotalRegF,
                    'totalSXTotalRegF' => $totalSXTotalRegF,
                    'totalITotalRegF' => $totalITotalRegF,
                    'totalIPTotalRegF' => $totalIPTotalRegF,
                    'totalIXTotalRegF' => $totalIXTotalRegF,
                    'totalCTTotalRegF' => $totalCTTotalRegF,
                    'totalCHTotalRegF' => $totalCHTotalRegF,
                    'totalCBTotalRegF' => $totalCBTotalRegF,
                    'totalCLTotalRegF' => $totalCLTotalRegF,
                    'totalHTotalFlF' => $totalHTotalFlF,
                    'totalTATotalFlF' => $totalTATotalFlF,
                    'totalDTotalFlF' => $totalDTotalFlF,
                    'totalLTotalFlF' => $totalLTotalFlF,
                    'totalMTotalFlF' => $totalMTotalFlF,
                    'totalMXTotalFlF' => $totalMXTotalFlF,
                    'totalSTotalFlF' => $totalSTotalFlF,
                    'totalSXTotalFlF' => $totalSXTotalFlF,
                    'totalITotalFlF' => $totalITotalFlF,
                    'totalIPTotalFlF' => $totalIPTotalFlF,
                    'totalIXTotalFlF' => $totalIXTotalFlF,
                    'totalCTTotalFlF' => $totalCTTotalFlF,
                    'totalCHTotalFlF' => $totalCHTotalFlF,
                    'totalCBTotalFlF' => $totalCBTotalFlF,
                    'totalCLTotalFlF' => $totalCLTotalFlF,
                    'staffAttF' => $staffAttF,
                    'monAttF' => $monAttF,
                    'regAttF' => $regAttF,
                    'flAttF' => $flAttF,
                    'bskpAttF' => $bskpAttF,
                    'staffTotalF' => $staffTotalF,
                    'monthlyTotalF' => $monthlyTotalF,
                    'regularTotalF' => $regularTotalF,
                    'flTotalF' => $flTotalF,
                    'bskpTotalF' => $bskpTotalF,
                    'totalHFinalF' => $totalHFinalF,
                    'totalTAFinalF' => $totalTAFinalF,
                    'totalDFinalF' => $totalDFinalF,
                    'totalLFinalF' => $totalLFinalF,
                    'totalMFinalF' => $totalMFinalF,
                    'totalMXFinalF' => $totalMXFinalF,
                    'totalSFinalF' => $totalSFinalF,
                    'totalSXFinalF' => $totalSXFinalF,
                    'totalIFinalF' => $totalIFinalF,
                    'totalIPFinalF' => $totalIPFinalF,
                    'totalIXFinalF' => $totalIXFinalF,
                    'totalCTFinalF' => $totalCTFinalF,
                    'totalCHFinalF' => $totalCHFinalF,
                    'totalCBFinalF' => $totalCBFinalF,
                    'totalCLFinalF' => $totalCLFinalF,
                    'empAttF' => $empAttF,
                    'total_hF' => $total_hF,
                    'total_lF' => $total_lF,
                    'total_taF' => $total_taF,
                    'total_dF' => $total_dF,
                    'total_mF' => $total_mF,
                    'total_mxF' => $total_mxF,
                    'total_sF' => $total_sF,
                    'total_sxF' => $total_sxF,
                    'total_iF' => $total_iF,
                    'total_ipF' => $total_ipF,
                    'total_ixF' => $total_ixF,
                    'total_ctF' => $total_ctF,
                    'total_chF' => $total_chF,
                    'total_cbF' => $total_cbF,
                    'total_clF' => $total_clF,
                    'dataFac' => $dataFac,
                    'totalRegularTotal1Fac' => $totalRegularTotal1Fac,
                    'totalFlTotal1Fac' => $totalFlTotal1Fac,
                    'totalHTotalRegFac' => $totalHTotalRegFac,
                    'totalTATotalRegFac' => $totalTATotalRegFac,
                    'totalDTotalRegFac' => $totalDTotalRegFac,
                    'totalLTotalRegFac' => $totalLTotalRegFac,
                    'totalMTotalRegFac' => $totalMTotalRegFac,
                    'totalMXTotalRegFac' => $totalMXTotalRegFac,
                    'totalSTotalRegFac' => $totalSTotalRegFac,
                    'totalSXTotalRegFac' => $totalSXTotalRegFac,
                    'totalITotalRegFac' => $totalITotalRegFac,
                    'totalIPTotalRegFac' => $totalIPTotalRegFac,
                    'totalIXTotalRegFac' => $totalIXTotalRegFac,
                    'totalCTTotalRegFac' => $totalCTTotalRegFac,
                    'totalCHTotalRegFac' => $totalCHTotalRegFac,
                    'totalCBTotalRegFac' => $totalCBTotalRegFac,
                    'totalCLTotalRegFac' => $totalCLTotalRegFac,
                    'totalHTotalFlFac' => $totalHTotalFlFac,
                    'totalTATotalFlFac' => $totalTATotalFlFac,
                    'totalDTotalFlFac' => $totalDTotalFlFac,
                    'totalLTotalFlFac' => $totalLTotalFlFac,
                    'totalMTotalFlFac' => $totalMTotalFlFac,
                    'totalMXTotalFlFac' => $totalMXTotalFlFac,
                    'totalSTotalFlFac' => $totalSTotalFlFac,
                    'totalSXTotalFlFac' => $totalSXTotalFlFac,
                    'totalITotalFlFac' => $totalITotalFlFac,
                    'totalIPTotalFlFac' => $totalIPTotalFlFac,
                    'totalIXTotalFlFac' => $totalIXTotalFlFac,
                    'totalCTTotalFlFac' => $totalCTTotalFlFac,
                    'totalCHTotalFlFac' => $totalCHTotalFlFac,
                    'totalCBTotalFlFac' => $totalCBTotalFlFac,
                    'totalCLTotalFlFac' => $totalCLTotalFlFac,
                    'staffAttFac' => $staffAttFac,
                    'monAttFac' => $monAttFac,
                    'regAttFac' => $regAttFac,
                    'flAttFac' => $flAttFac,
                    'bskpAttFac' => $bskpAttFac,
                    'staffTotalFac' => $staffTotalFac,
                    'monthlyTotalFac' => $monthlyTotalFac,
                    'regularTotalFac' => $regularTotalFac,
                    'flTotalFac' => $flTotalFac,
                    'bskpTotalFac' => $bskpTotalFac,
                    'totalHFinalFac' => $totalHFinalFac,
                    'totalTAFinalFac' => $totalTAFinalFac,
                    'totalDFinalFac' => $totalDFinalFac,
                    'totalLFinalFac' => $totalLFinalFac,
                    'totalMFinalFac' => $totalMFinalFac,
                    'totalMXFinalFac' => $totalMXFinalFac,
                    'totalSFinalFac' => $totalSFinalFac,
                    'totalSXFinalFac' => $totalSXFinalFac,
                    'totalIFinalFac' => $totalIFinalFac,
                    'totalIPFinalFac' => $totalIPFinalFac,
                    'totalIXFinalFac' => $totalIXFinalFac,
                    'totalCTFinalFac' => $totalCTFinalFac,
                    'totalCHFinalFac' => $totalCHFinalFac,
                    'totalCBFinalFac' => $totalCBFinalFac,
                    'totalCLFinalFac' => $totalCLFinalFac,
                    'empAttFac' => $empAttFac,
                    'total_hFac' => $total_hFac,
                    'total_lFac' => $total_lFac,
                    'total_taFac' => $total_taFac,
                    'total_dFac' => $total_dFac,
                    'total_mFac' => $total_mFac,
                    'total_mxFac' => $total_mxFac,
                    'total_sFac' => $total_sFac,
                    'total_sxFac' => $total_sxFac,
                    'total_iFac' => $total_iFac,
                    'total_ipFac' => $total_ipFac,
                    'total_ixFac' => $total_ixFac,
                    'total_ctFac' => $total_ctFac,
                    'total_chFac' => $total_chFac,
                    'total_cbFac' => $total_cbFac,
                    'total_clFac' => $total_clFac,
                ]
            );
        } else {
            $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
            $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

            $staffAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->where('users.status', 'Staff')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $monAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->where('users.status', 'Monthly')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $regAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->where('users.status', 'Regular')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $flAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->where('users.status', 'Contract FL')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $bskpAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                )
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->where('users.status', 'Contract BSKP')
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'H') as h"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'L') as l"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'D') as d"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'M') as m"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'S') as s"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'I') as i"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"))
                ->addSelect(DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.status')
                ->get();

            $totalAttFinal = $totalAtt->sum(function ($item) {
                return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
            });

            $totalHFinal = $totalAtt->sum('hadir');
            $totalTAFinal = $totalAtt->sum('ta');
            $totalDFinal = $totalAtt->sum('d');
            $totalLFinal = $totalAtt->sum('l');
            $totalMFinal = $totalAtt->sum('m');
            $totalMXFinal = $totalAtt->sum('mx');
            $totalSFinal = $totalAtt->sum('s');
            $totalSXFinal = $totalAtt->sum('sx');
            $totalIFinal = $totalAtt->sum('i');
            $totalIPFinal = $totalAtt->sum('ip');
            $totalIXFinal = $totalAtt->sum('ix');
            $totalCTFinal = $totalAtt->sum('ct');
            $totalCHFinal = $totalAtt->sum('ch');
            $totalCBFinal = $totalAtt->sum('cb');
            $totalCLFinal = $totalAtt->sum('cl');

            $staffTotal = DB::table('users')
                ->where('dept', $dept)
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotal = DB::table('users')
                ->where('dept', $dept)
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotal = DB::table('users')
                ->where('dept', $dept)
                ->where('status', 'Regular')
                ->count('dept');

            $flTotal = DB::table('users')
                ->where('dept', $dept)
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotal = DB::table('users')
                ->where('dept', $dept)
                ->where('status', 'Contract BSKP')
                ->count('dept');

            $empAtt = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    DB::raw("SUM(test_absen_regs.desc = 'H') as h"),
                    DB::raw("SUM(test_absen_regs.desc = 'L') as l"),
                    DB::raw("SUM(test_absen_regs.desc = 'TA') as ta"),
                    DB::raw("SUM(test_absen_regs.desc = 'D') as d"),
                    DB::raw("SUM(test_absen_regs.desc = 'M') as m"),
                    DB::raw("SUM(test_absen_regs.desc = 'MX') as mx"),
                    DB::raw("SUM(test_absen_regs.desc = 'S') as s"),
                    DB::raw("SUM(test_absen_regs.desc = 'SX') as sx"),
                    DB::raw("SUM(test_absen_regs.desc = 'I') as i"),
                    DB::raw("SUM(test_absen_regs.desc = 'IP') as ip"),
                    DB::raw("SUM(test_absen_regs.desc = 'IX') as ix"),
                    DB::raw("SUM(test_absen_regs.desc = 'CT') as ct"),
                    DB::raw("SUM(test_absen_regs.desc = 'CH') as ch"),
                    DB::raw("SUM(test_absen_regs.desc = 'CB') as cb"),
                    DB::raw("SUM(test_absen_regs.desc = 'CL') as cl"),
                    DB::raw("SUM(test_absen_regs.hadir = '1') as hadir")
                )
                ->where('users.active', 'yes')
                ->where('users.dept', $dept)
                ->whereDate('test_absen_regs.date', $date)
                ->groupBy('users.nik', 'users.name')
                ->get();

            $total_h = $empAtt->sum('hadir');
            $total_l = $empAtt->sum('l');
            $total_ta = $empAtt->sum('ta');
            $total_d = $empAtt->sum('d');
            $total_m = $empAtt->sum('m');
            $total_mx = $empAtt->sum('mx');
            $total_s = $empAtt->sum('s');
            $total_sx = $empAtt->sum('sx');
            $total_i = $empAtt->sum('i');
            $total_ip = $empAtt->sum('ip');
            $total_ix = $empAtt->sum('ix');
            $total_ct = $empAtt->sum('ct');
            $total_ch = $empAtt->sum('ch');
            $total_cb = $empAtt->sum('cb');
            $total_cl = $empAtt->sum('cl');

            return view(
                'admin.pages.summary-per-dept.summary-per-dept-result-admin-only',
                [
                    'dept' => $dept,
                    'staffAtt' => $staffAtt,
                    'monAtt' => $monAtt,
                    'regAtt' => $regAtt,
                    'flAtt' => $flAtt,
                    'bskpAtt' => $bskpAtt,
                    'date' => $date,
                    'staffTotal' => $staffTotal,
                    'monthlyTotal' => $monthlyTotal,
                    'regularTotal' => $regularTotal,
                    'flTotal' => $flTotal,
                    'bskpTotal' => $bskpTotal,
                    'totalHFinal' => $totalHFinal,
                    'totalTAFinal' => $totalTAFinal,
                    'totalDFinal' => $totalDFinal,
                    'totalLFinal' => $totalLFinal,
                    'totalMFinal' => $totalMFinal,
                    'totalMXFinal' => $totalMXFinal,
                    'totalSFinal' => $totalSFinal,
                    'totalSXFinal' => $totalSXFinal,
                    'totalIFinal' => $totalIFinal,
                    'totalIPFinal' => $totalIPFinal,
                    'totalIXFinal' => $totalIXFinal,
                    'totalCTFinal' => $totalCTFinal,
                    'totalCHFinal' => $totalCHFinal,
                    'totalCBFinal' => $totalCBFinal,
                    'totalCLFinal' => $totalCLFinal,
                    'empAtt' => $empAtt,
                    'total_h' => $total_h,
                    'total_l' => $total_l,
                    'total_ta' => $total_ta,
                    'total_d' => $total_d,
                    'total_m' => $total_m,
                    'total_mx' => $total_mx,
                    'total_s' => $total_s,
                    'total_sx' => $total_sx,
                    'total_i' => $total_i,
                    'total_ip' => $total_ip,
                    'total_ix' => $total_ix,
                    'total_ct' => $total_ct,
                    'total_ch' => $total_ch,
                    'total_cb' => $total_cb,
                    'total_cl' => $total_cl,
                    'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                ]
            );
        }
    }

}

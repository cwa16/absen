<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\AbsenReg;
use App\Models\User;
use Redirect;
use App\Exports\AbsenExport;
use Maatwebsite\Excel\Facades\Excel;

class FilterDashboardController extends Controller
{
    public function filterTodateAtt(Request $request)
    {
      $todayL = Carbon::now();
      $today = Carbon::parse($todayL)->format('Y-m-d');
      $monthly = User::where('status', 'Monthly')->whereHas('absen', function($query) use ($today) {
        $query->where('date', '=', $today);
      })->count();

      $dept = \Auth::user()->dept;

      $staff = User::where('status', 'Staff')->whereHas('absen', function($query) use ($today) {
        $query->where('date', '=', $today);
      })->count();

      $manager = User::where('status', 'Manager')->whereHas('absen', function($query) use ($today) {
        $query->where('date', '=', $today);
      })->count();

      $regular = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
      })->count();

      $reg_L_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_H_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_TA_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_MX_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_D_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_E_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_I_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_S_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_C_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_IX_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_SX_dept = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'SX');
      })->count();


      $reg_L = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_L_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_L_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_L_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_L_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_L_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'L');
      })->count();

      $reg_D = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_D_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_D_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_D_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_D_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_D_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'D');
      })->count();

      $reg_A = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'A');
      })->count();

      $reg_A_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'A');
      })->count();

      $reg_A_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'A');
      })->count();

      $reg_A_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'A');
      })->count();

      $reg_A_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'A');
      })->count();

      $reg_A_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'A');
      })->count();

      $reg_H = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_H_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_H_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_H_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_H_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_H_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'H');
      })->count();

      $reg_E = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_E_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_E_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_E_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_E_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_E_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'E');
      })->count();

      $reg_TA = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_TA_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_TA_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_TA_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_TA_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_TA_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'M');
      })->count();

      $reg_MX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_MX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_MX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_MX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_MX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_MX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'MX');
      })->count();

      $reg_I = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_I_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_I_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_I_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_I_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_I_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'I');
      })->count();

      $reg_S = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_S_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_S_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_S_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_S_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_S_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'S');
      })->count();

      $reg_C = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_C_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_C_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_C_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_C_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_C_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'C');
      })->count();

      $reg_IX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_IX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_IX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_IX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_IX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_IX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'IX');
      })->count();

      $reg_SX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'SX');
      })->count();

      $reg_SX_B = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'SX');
      })->count();

      $reg_SX_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'SX');
      })->count();

      $reg_SX_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'SX');
      })->count();

      $reg_SX_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function($query) use ($today) {
        $query->where('date', '=', $today);
        $query->where('desc', '=', 'SX');
      })->count();

      $reg_SX_F = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function($query) use ($today) {
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
      $per_monthly = ($monthly/$budget_monthly)*100;
      $per_staff = ($staff/$budget_staff)*100;
      $per_manager = ($manager/$budget_manager)*100;
      $per_regular = ($regular/$budget_regular)*100;

      $budget_total = $budget_monthly+$budget_staff+$budget_manager+$budget_regular;
      $act_total = $monthly+$staff+$manager+$regular;
      $per_total = ($act_total/$budget_total)*100;

      // tanggal
      $date = Carbon::parse(Carbon::now())->translatedformat('l M, Y');

      // latest
      $latest1 = AbsenReg::latest()->first();
      $latest = ($latest1 == null) ? 0 : Carbon::parse($latest1->created_at)->format('d M Y H:s') ;
      // $latest = Carbon::parse($latest1->created_at)->format('d M Y H:s');

      // total karyawan
      $t_kary = User::count();

      // total dept kehadiran
      $t_dept = ($reg_H_dept == 0) ? 0 : ($reg_H_dept/$budget_dept)*100;

      // todate
      $month = Carbon::parse(Carbon::now())->format('m');
      $day1 = range(1, Carbon::now()->month($month)->daysInMonth);
      $day = (implode(",",$day1));
      // $day = json_encode($day1);

      foreach ($day1 as $key => $value) {
        $reg_h_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'H');
        })->count();

        $reg_a_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'M');
        })->count();

        $reg_mx_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'MX');
        })->count();

        $reg_l_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'L');
        })->count();

        $reg_d_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'D');
        })->count();

        $reg_e_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'E');
        })->count();

        $reg_i_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'I');
        })->count();

        $reg_s_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'S');
        })->count();

        $reg_c_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'C');
        })->count();

        $reg_ix_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'IX');
        })->count();

        $reg_sx_day_array[$key] = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($value) {
          $query->whereDay('date', '=', $value);
          $query->where('desc', '=', 'SX');
        })->count();


      }

      $reg_h_day  = (implode(",",$reg_h_day_array));
      $reg_a_day  = (implode(",",$reg_a_day_array));
      $reg_mx_day  = (implode(",",$reg_mx_day_array));
      $reg_l_day  = (implode(",",$reg_l_day_array));
      $reg_d_day  = (implode(",",$reg_d_day_array));
      $reg_e_day  = (implode(",",$reg_e_day_array));
      $reg_i_day  = (implode(",",$reg_i_day_array));
      $reg_s_day  = (implode(",",$reg_s_day_array));
      $reg_c_day  = (implode(",",$reg_c_day_array));
      $reg_ix_day = (implode(",",$reg_ix_day_array));
      $reg_sx_day = (implode(",",$reg_sx_day_array));
      // dd($reg_a_day);
      // $reg_h_day = (json_encode($reg_h_day_array));

      // todate regular
      $reg_months = $todayL->startOfMonth();
      $reg_month = Carbon::parse($reg_months)->format('Y-m-d');

      $to_reg_h = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'H')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'M')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'MX')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'L')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'D')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'E')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'I')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'S')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'C')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'IX')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
                  ->where('desc', 'SX')
                  ->whereHas('user', function($query) {
                    $query->where('status', 'Regular');
                  })->count();

      $tot_regs = User::where('status', 'Regular')->count();
      $tot_month = Carbon::now()->month($month)->daysInMonth;
      $tot_reg = $tot_regs*$tot_month;

      $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h/$tot_reg)*100;
      $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a/$tot_reg)*100;
      $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx/$tot_reg)*100;

      $budget_reg_dept = User::where('status', 'Regular')->count();

      // $list_absen_reg = User::where('status', 'Regular')->whereHas('absen_reg', function($query) use ($today) {
      //   $query->where('date', '=', $today);
      //   $query->whereIn('desc', ['M','MX','D','E','I','S','C','IX','SX']);
      // })->get();

      $kondisi = User::where('status', 'Regular')->whereHas('absen_reg')->count();

      $list_absen_reg = AbsenReg::where('date', $today)
                        ->whereIn('desc', ['M','MX','D','E','I','S','C','IX','SX'])
                        ->whereHas('user', function($query) {
                          $query->where('status', 'Regular');
                        })->get();

      $startDay = Carbon::parse(Carbon::now()->startOfMonth())->format('Y-m-d');
      $endDay = Carbon::parse(Carbon::now())->format('Y-m-d');
      $deptSelect = $request->dept;
      $list_absen_reg_todate = User::where('dept', $deptSelect)->where('status', 'Regular')->whereHas('absen_reg', function($q) use($startDay, $endDay) {
                                $q->whereIn('desc', ['M','MX','D','E','I','S','C','IX','SX']);
                                $q->whereBetween('date', [$startDay, $endDay]);
                               })
                               ->whereHas('mandor')
                               ->paginate(10);

      $listDept = User::groupBy('dept')->get();

      return view('admin.pages.dashboard-regular', ['monthly' => $monthly,
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
                                            'kondisi' => $kondisi]);
    }
}

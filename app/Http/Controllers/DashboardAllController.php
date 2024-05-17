<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenReg;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;

class DashboardAllController extends Controller
{
    public function index()
    {
        $departments = DB::table('users')->pluck('dept')->unique();
        $latest1 = AbsenReg::latest()->first();
        $latest = ($latest1 == null) ? 0 : Carbon::parse($latest1->created_at)->format('d M Y H:s');

        return view('admin.pages.testing.dashboard-all', ['departments' => $departments, 'latest' => $latest]);
    }

    public function dashA()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'I/A')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'I/A')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'I/A')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'I/A')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'I/A')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'I/A')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'I/A')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'I/A')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'I/A')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'I/A')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/A');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-a', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function dashB()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'I/B')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'I/B')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'I/B')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'I/B')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'I/B')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'I/B')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'I/B')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'I/B')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'I/B')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'I/B')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/B');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-b', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function dashC()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'I/C')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'I/C')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'I/C')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'I/C')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'I/C')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'I/C')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'I/C')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'I/C')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'I/C')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'I/C')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'I/C');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-c', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function dashD()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'II/D')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'II/D')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'II/D')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'II/D')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'II/D')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'II/D')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'II/D')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'II/D')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'II/D')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'II/D')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/D');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-d', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function dashE()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'II/E')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'II/E')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'II/E')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'II/E')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'II/E')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'II/E')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'II/E')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'II/E')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'II/E')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'II/E')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/E');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-e', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function dashF()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'II/F')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'II/F')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'II/F')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'II/F')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'II/F')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'II/F')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'II/F')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'II/F')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'II/F')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'II/F')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'II/F');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-f', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function bskp()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->count();
            $budget_staff = User::where('status', 'Staff')->count();
            $budget_manager = User::where('status', 'Manager')->count();
            $budget_regular = User::where('status', 'Regular')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->count();

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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'BSKP')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'BSKP')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'BSKP')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'BSKP');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-bskp', ['monthly' => $monthly,
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
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function it()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'IT')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'IT')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'IT')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'IT')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'IT')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'IT')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'IT')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'IT');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'IT')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'IT')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'IT')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'IT');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-it', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function factory()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'Factory')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'Factory')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'Factory')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'Factory')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'Factory')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'Factory')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'Factory')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'Factory')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'Factory')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-factory', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function accfin()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'Acc & Fin')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'Acc & Fin')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'Acc & Fin')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'Acc & Fin')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'Acc & Fin')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'Acc & Fin')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Acc & Fin');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-accfin', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function hrlegal()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'HR & Legal')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'HR & Legal')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'HR & Legal')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'HR & Legal')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'HR & Legal')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'HR & Legal')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'HR & Legal')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'HR & Legal')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'HR & Legal')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HR & Legal');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-hrlegal', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function hsedp()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'HSE & DP')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'HSE & DP')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'HSE & DP')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'HSE & DP')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'HSE & DP')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'HSE & DP')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'HSE & DP')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'HSE & DP')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'HSE & DP')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'HSE & DP');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-hsedp', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function qa()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'QA')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'QA')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'QA')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'QA')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'QA')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'QA')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'QA')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'QA');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'QA')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'QA')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'QA')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QA');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-qa', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function qm()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'QM')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'QM')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'QM')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'QM')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'QM')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'QM')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'QM')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'QM');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'QM')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'QM')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'QM')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'QM');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-qm', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function field()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'Factory')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'Factory')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'Factory')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'Factory')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'Factory')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'Factory')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'Factory')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'Factory')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'Factory')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'Factory')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Factory');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-factory', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function fsd()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'FSD')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'FSD')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'FSD')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'FSD')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'FSD')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'FSD')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'FSD')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'FSD')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'FSD')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'FSD')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'FSD');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-fsd', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function workshop()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'Workshop')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'Workshop')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'Workshop')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'Workshop')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'Workshop')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'Workshop')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'Workshop')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'Workshop')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'Workshop')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Workshop');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-workshop', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }

    public function security()
    {
        $todayL = Carbon::now();
        $today = Carbon::parse($todayL)->subDay(1)->format('Y-m-d');
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $startDay = $now->startOfMonth()->format('Y-m-d');

        $monthly = User::where('status', 'Monthly')->where('dept', 'Security')->whereHas('absen', function ($query) use ($today) {
            $query->where('date', '=', $today);
        })->count();

        $inputAbsen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', 'users.dept', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->groupBy('absen_regs.date', 'users.dept')
            ->get();

            $staff = User::where('status', 'Staff')->where('dept', 'Security')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $manager = User::where('status', 'Manager')->where('dept', 'Security')->whereHas('absen', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $regular = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
            })->count();

            $reg_L_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_H_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_TA_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_D_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_E_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_I_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX_dept = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $reg_L = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_D = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_A = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_H = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_E = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_TA = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_MX = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_I = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_S = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_C = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'C');
            })->count();

            $reg_IX = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_SX = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
                $query->where('date', '=', $today);
                $query->where('desc', '=', 'SX');
            })->count();

            $budget_monthly = User::where('status', 'Monthly')->where('dept', 'Security')->count();
            $budget_staff = User::where('status', 'Staff')->where('dept', 'Security')->count();
            $budget_regular = User::where('status', 'Regular')->where('dept', 'Security')->count();
            $budget_dept = User::where('status', 'Regular')->where('dept', 'Security')->count();

            // persen
        $per_monthly = ($monthly / $budget_monthly) * 100;
        $per_staff = ($staff / $budget_staff) * 100;
        $per_regular = ($regular / $budget_regular) * 100;

        $budget_total = $budget_monthly + $budget_staff + $budget_regular;
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
            $reg_h_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'H');
            })->count();

            $reg_a_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'M');
            })->count();

            $reg_mx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'MX');
            })->count();

            $reg_l_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'L');
            })->count();

            $reg_d_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'D');
            })->count();

            $reg_e_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'E');
            })->count();

            $reg_i_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'I');
            })->count();

            $reg_s_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'S');
            })->count();

            $reg_c_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL']);
            })->count();

            $reg_ix_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
                $query->whereDay('date', '=', $value);
                $query->whereMonth('date', '=', $month);
                $query->where('desc', '=', 'IX');
            })->count();

            $reg_sx_day_array[$key] = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($value, $month) {
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
                $query->where('dept', 'Security');
            })->count();

        $to_reg_a = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'M')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_mx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'MX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_l = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'L')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_d = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'D')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_e = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'E')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_i = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'I')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_s = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'S')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_c = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'C')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_ix = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'IX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $to_reg_sx = AbsenReg::whereBetween('date', [$reg_month, $today])
            ->where('desc', 'SX')
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->count();

        $tot_regs = User::where('status', 'Regular')->where('dept', 'Security')->count();
        $tot_month = Carbon::now()->month($month)->daysInMonth;
        $tot_reg = $tot_regs * $tot_month;
        $per_tot_reg_h = ($to_reg_h == 0) ? 0 : ($to_reg_h / $tot_reg) * 100;
        $per_tot_reg_a = ($to_reg_a == 0) ? 0 : ($to_reg_a / $tot_reg) * 100;
        $per_tot_reg_mx = ($to_reg_mx == 0) ? 0 : ($to_reg_mx / $tot_reg) * 100;

        $budget_reg_dept = User::where('status', 'Regular')->where('dept', 'Security')->count();

        $list_absen_reg = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg', function ($query) use ($today) {
            $query->where('date', '=', $today);
            $query->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX']);
        })->get();

        $kondisi = User::where('status', 'Regular')->where('dept', 'Security')->whereHas('absen_reg')->count();

        $list_absen_reg = AbsenReg::where('date', $today)
            ->whereIn('desc', ['MX', 'M', 'D', 'E', 'I', 'S', 'C', 'IX', 'SX'])
            ->whereHas('user', function ($query) {
                $query->where('status', 'Regular');
                $query->where('dept', 'Security');
            })->get();

        return view('admin.pages.testing.dashall.dashboard-security', ['monthly' => $monthly,
            'staff' => $staff,
            'manager' => $manager,
            'regular' => $regular,
            'budget_monthly' => $budget_monthly,
            'budget_staff' => $budget_staff,
            'budget_regular' => $budget_regular,
            'per_monthly' => $per_monthly,
            'per_staff' => $per_staff,
            'per_regular' => $per_regular,
            'per_total' => $per_total,
            'date' => $date,
            'latest' => $latest,
            't_kary' => $t_kary,
            'reg_h' => $reg_H,
            'reg_l' => $reg_L,
            'reg_d' => $reg_D,
            'reg_a' => $reg_A,
            'reg_mx' => $reg_MX,
            'reg_e' => $reg_E,
            'reg_ta' => $reg_TA,
            'reg_mx' => $reg_MX,
            'reg_i' => $reg_I,
            'reg_s' => $reg_S,
            'reg_c' => $reg_C,
            'reg_ix' => $reg_IX,
            'reg_sx' => $reg_SX,
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
            'kondisi' => $kondisi]);

    }
}

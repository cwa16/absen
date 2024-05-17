<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $now = Carbon::now()->subDays(1);
        $nowDate = Carbon::parse($now)->format('Y-m-d');
        $nowDay = Carbon::parse($now)->format('d');
        $nowMonth = Carbon::parse($now)->format('m');
        $nowYear = Carbon::parse($now)->format('Y');
        $startDay = $now->startOfMonth()->format('Y-m-d');
        $endDay = $now->endOfMonth()->format('Y-m-d');
        $days = CarbonPeriod::create($startDay, $endDay)->count();
        $datex = CarbonPeriod::create($startDay, $endDay)->toArray();
        foreach ($datex as $e) {
            $dates[] = $e->format('d');
        }

        $totalReg = DB::table('users')->where('status', 'Regular')->count();
        $totalRegTodate = $totalReg * $days;

        $H = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'H')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Hdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'H')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Hdata->isEmpty()) {
            $Hget = 0;
        } else {
            foreach ($Hdata as $item) {
                $Hget[] = $item->total;
            }
        }

        $M = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'M')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Mdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'M')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Mdata->isEmpty()) {
            $Mget = 0;
        } else {
            foreach ($Mdata as $item) {
                $Mget[] = $item->total;
            }
        }

        $MX = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'MX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $MXdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'MX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($MXdata->isEmpty()) {
            $MXget = 0;
        } else {
            foreach ($MXdata as $item) {
                $MXget[] = $item->total;
            }
        }

        $L = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'L')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Ldata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'L')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Ldata->isEmpty()) {
            $Lget = 0;
        } else {

            foreach ($Ldata as $item) {
                $Lget[] = $item->total;
            }
        }

        $D = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'D')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Ddata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'D')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Ddata->isEmpty()) {
            $Dget = 0;
        } else {

            foreach ($Ddata as $item) {
                $Dget[] = $item->total;
            }
        }

        $E = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'E')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Edata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'E')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Edata->isEmpty()) {
            $Eget = 0;
        } else {

            foreach ($Edata as $item) {
                $Eget[] = $item->total;
            }
        }

        $I = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'I')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Idata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'I')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Idata->isEmpty()) {
            $Iget = 0;
        } else {

            foreach ($Idata as $item) {
                $Iget[] = $item->total;
            }
        }

        $S = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'S')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Sdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'S')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Sdata->isEmpty()) {
            $Sget = 0;
        } else {

            foreach ($Sdata as $item) {
                $Sget[] = $item->total;
            }
        }

        $C = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->whereIn('absen_regs.desc', ['CT', 'CB', 'CH', 'CS', 'CLL'])
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $Cdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->whereIn('absen_regs.desc', ['CT', 'CB', 'CH', 'CS', 'CLL'])
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($Cdata->isEmpty()) {
            $Cget = 0;
        } else {

            foreach ($Cdata as $item) {
                $Cget[] = $item->total;
            }
        }

        $IX = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'IX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $IXdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'IX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($IXdata->isEmpty()) {
            $IXget = 0;
        } else {

            foreach ($IXdata as $item) {
                $IXget[] = $item->total;
            }
        }

        $SX = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'SX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $SXdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'SX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($SXdata->isEmpty()) {
            $SXget = 0;
        } else {

            foreach ($SXdata as $item) {
                $SXget[] = $item->total;
            }
        }

        $IP = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->where('absen_regs.date', $nowDate)
            ->where('absen_regs.desc', 'IP')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $IPdata = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $endDay])
            ->where('absen_regs.desc', 'IP')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->get();

        if ($IPdata->isEmpty()) {
            $IPget = 0;
        } else {

            foreach ($IPdata as $item) {
                $IPget[] = $item->total;
            }
        }

        $H_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'H')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $M_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'M')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $MX_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'MX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $L_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'L')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $D_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'D')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $E_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'E')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $I_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'I')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $S_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'S')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $C_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->whereIn('absen_regs.desc', ['CT', 'CB', 'CH', 'CS', 'CLL'])
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $IX_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'IX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $SX_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'SX')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        $IP_todate = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('absen_regs.date', DB::raw('COUNT(absen_regs.desc) as total'))
            ->whereBetween('absen_regs.date', [$startDay, $nowDate])
            ->where('absen_regs.desc', 'IP')
            ->where('users.status', 'Regular')
            ->groupBy('absen_regs.date')
            ->first();

        return view('admin.pages.dashboard-regular-admin', [
            'H' => $H,
            'Hget' => $Hget,
            'Mget' => $Mget,
            'MXget' => $MXget,
            'Lget' => $Lget,
            'Dget' => $Dget,
            'Eget' => $Eget,
            'Cget' => $Cget,
            'IXget' => $IXget,
            'SXget' => $SXget,
            'Sget' => $Sget,
            'Iget' => $Iget,
            'IPget' => $IPget,
            'M' => $M,
            'MX' => $MX,
            'L' => $L,
            'D' => $D,
            'E' => $E,
            'I' => $I,
            'S' => $S,
            'C' => $C,
            'IX' => $IX,
            'SX' => $SX,
            'IP' => $IP,
            'totalRegTodate' => $totalRegTodate,
            'H_todate' => $H_todate,
            'M_todate' => $M_todate,
            'MX_todate' => $MX_todate,
            'L_todate' => $L_todate,
            'D_todate' => $D_todate,
            'E_todate' => $E_todate,
            'I_todate' => $I_todate,
            'S_todate' => $S_todate,
            'C_todate' => $C_todate,
            'IX_todate' => $IX_todate,
            'SX_todate' => $SX_todate,
            'IP_todate' => $IP_todate,
            'totalReg' => $totalReg,
            'dates' => $dates
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\TestingAbsen;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\Request;
use PDF;
use App\Models\MandorTapper;
use App\Models\AbsenReg;

class SummaryPerDeptRegController extends Controller
{
    public function index()
    {
        $month = Carbon::now()->format('m');
        $monthLabel = Carbon::now()->format('F Y');
        $yearNow = Carbon::now()->format('Y');
        $dept = \Auth::user()->dept;
        $day1 = range(1, Carbon::now()->month($month)->daysInMonth);
        $day = (implode(",", $day1));
        $cDay = count($day1);
        $colSpan = $cDay;
        $dateP = Carbon::parse(Carbon::now())->format('d-M-Y');

        $firstDay = Carbon::parse(Carbon::now())->firstOfMonth();
        $todateDay = Carbon::parse(Carbon::now());
        $cToDay = $firstDay->diffInDays($todateDay);
        $cToDays = $colSpan - $cToDay;

        if (\Auth::user()->role_app == 'Admin') {
            $emp = User::with([
                'absen_reg' => function ($query) use ($month, $yearNow) {
                    $query->whereMonth('date', $month);
                    $query->whereYear('date', $yearNow);
                },
            ])->get()->groupBy(function ($item) {
                return $item->dept;
            });
            $dept = User::groupBy('dept')->get();
            if (\Auth::user()->role_app == 'Admin') {
                $emp = User::with([
                    'absen_reg' => function ($query) use ($month, $yearNow) {
                        $query->whereMonth('date', $month);
                        $query->whereYear('date', $yearNow);
                    },
                ])->get()->groupBy(function ($item) {
                    return $item->dept;
                });
                $dept = User::groupBy('dept')->get();
            } else {
                $emp = User::where('dept', $dept)->with([
                    'absen_reg' => function ($query) use ($month, $yearNow) {
                        $query->whereMonth('date', $month);
                        $query->whereYear('date', $yearNow);
                    },
                ])->get()->groupBy(function ($item) {
                    return $item->dept;
                });
            }
        }

        return view('admin.pages.attendance-per-dept-reg', ['dateP' => $dateP, 'cToDays' => $cToDays, 'colSpan' => $colSpan, 'day1' => $day1, 'dept' => $dept, 'emp' => $emp, 'monthLabel' => $monthLabel, 'yearNow' => $yearNow, 'month' => $month]);
    }

    // Ini Diubah
    public function index_new()
    {
        // $dateNow = Carbon::now();

        $dateNow = '2024-04-30';
        $date = Carbon::parse($dateNow);
        $firstDay = Carbon::parse($dateNow)->firstOfMonth()->format('Y-m-d');
        $lastDay = Carbon::parse($dateNow)->endOfMonth()->format('Y-m-d');

        // Get the month and year
        $month = $date->format('m');
        // $month = $date->subMonths(1);
        $yearNow = $date->format('Y');
        $month = Carbon::now()->format('m');
        $monthLabel = $date->format('F Y');
        $yearNow = Carbon::now()->format('Y');
        $dept = \Auth::user()->dept;
        $date1 = null;
        $status = User::groupBy('status')->get();
        $day1 = range(1, Carbon::now()->month($month)->daysInMonth);
        $day = (implode(",", $day1));
        $cDay = count($day1);
        $colSpan = $cDay;
        $dateP = $date->format('d-M-Y');

        $period = CarbonPeriod::create('2018-06-14', '2018-06-20');

        $firstDay = $date->firstOfMonth();
        $totalDay = $date->daysInMonth;
        $todateDay = $date;
        $cToDay = $firstDay->diffInDays($todateDay);
        $cToDays = $colSpan - $cToDay;

        $userDept = Auth::user()->dept;

        if ($userDept == 'HR Legal') {
            $emp1 = DB::table('users')
                ->join('test_absen_regs', 'users.nik', '=', 'test_absen_regs.user_id')
                ->leftJoin('master_shifts', 'test_absen_regs.shift', '=', 'master_shifts.id')
                ->select(
                    'users.name',
                    'test_absen_regs.date',
                    'users.nik',
                    'users.jabatan',
                    'users.name',
                    'master_shifts.start_work as shifter',
                    'master_shifts.end_work as shifter_end',
                    'users.status',
                    'users.start_work_user',
                    'users.end_work_user',
                    'test_absen_regs.start_work as masuk',
                    'test_absen_regs.end_work as pulang',
                    'test_absen_regs.desc',
                    DB::raw("SUM(total_hour) as thour"),
                    DB::raw("SUM(total_minute) as tmin"),
                    DB::raw("SUM(overtime_hour) as othour"),
                    DB::raw("SUM(overtime_minute) as otmin"),
                    DB::raw("SUM(late_hour) as latehour"),
                    DB::raw("SUM(late_minute) as latemin"),
                    DB::raw("(SUM(HOUR(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkx"),
                    DB::raw("(SUM(MINUTE(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkm"),
                    DB::raw("(SUM(SECOND(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjks"),
                    DB::raw("(SUM(time_to_sec(timediff(concat(test_absen_regs.date,' ',master_shifts.end_work), concat(test_absen_regs.date,' ',master_shifts.start_work)))/3600)) as shift"),
                    DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(HOUR(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as late"),
                    DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(MINUTE(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as latem"),
                    DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(SECOND(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as lates"),
                )
                ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, test_absen_regs.start_work, test_absen_regs.end_work)/3600) as tjk'))
                // ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, master_shifts.start_work, master_shifts.end_work)/3600) as shift'))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'H' then 1 else 0 end) as h"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'L' then 1 else 0 end) as l"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'TA' then 1 else 0 end) as ta"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'D' then 1 else 0 end) as d"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'M' then 1 else 0 end) as m"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'MX' then 1 else 0 end) as mx"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'S' then 1 else 0 end) as s"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'SX' then 1 else 0 end) as sx"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'I' then 1 else 0 end) as i"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IP' then 1 else 0 end) as ip"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IX' then 1 else 0 end) as ix"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CT' then 1 else 0 end) as ct"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CH' then 1 else 0 end) as ch"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CB' then 1 else 0 end) as cb"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CL' then 1 else 0 end) as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                // ->whereMonth('test_absen_regs.date', $month)
                // ->whereYear('test_absen_regs.date', $yearNow)
                // ->whereBetween('test_absen_regs.date', [$dateNow1, $dateNow])
                ->whereBetween('test_absen_regs.date', [$firstDay, $lastDay])
                ->where('loc_kerja', 'Head Office')
                ->where('active', 'yes')
                ->orderBy('users.nik', 'ASC')
                ->groupBy('users.nik')
                ->get();
        } else {
            $emp1 = DB::table('users')
                ->join('test_absen_regs', 'users.nik', '=', 'test_absen_regs.user_id')
                ->leftJoin('master_shifts', 'test_absen_regs.shift', '=', 'master_shifts.id')
                ->select(
                    'users.name',
                    'test_absen_regs.date',
                    'users.nik',
                    'users.jabatan',
                    'users.name',
                    'master_shifts.start_work as shifter',
                    'master_shifts.end_work as shifter_end',
                    'users.status',
                    'users.start_work_user',
                    'users.end_work_user',
                    'test_absen_regs.start_work as masuk',
                    'test_absen_regs.end_work as pulang',
                    'test_absen_regs.desc',
                    DB::raw("SUM(total_hour) as thour"),
                    DB::raw("SUM(total_minute) as tmin"),
                    DB::raw("SUM(overtime_hour) as othour"),
                    DB::raw("SUM(overtime_minute) as otmin"),
                    DB::raw("SUM(late_hour) as latehour"),
                    DB::raw("SUM(late_minute) as latemin"),
                    DB::raw("(SUM(HOUR(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkx"),
                    DB::raw("(SUM(MINUTE(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkm"),
                    DB::raw("(SUM(SECOND(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjks"),
                    DB::raw("(SUM(time_to_sec(timediff(concat(test_absen_regs.date,' ',master_shifts.end_work), concat(test_absen_regs.date,' ',master_shifts.start_work)))/3600)) as shift"),
                    DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(HOUR(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as late"),
                    DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(MINUTE(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as latem"),
                    DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(SECOND(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as lates"),
                )
                ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, test_absen_regs.start_work, test_absen_regs.end_work)/3600) as tjk'))
                // ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, master_shifts.start_work, master_shifts.end_work)/3600) as shift'))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'H' then 1 else 0 end) as h"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'L' then 1 else 0 end) as l"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'TA' then 1 else 0 end) as ta"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'D' then 1 else 0 end) as d"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'M' then 1 else 0 end) as m"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'MX' then 1 else 0 end) as mx"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'S' then 1 else 0 end) as s"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'SX' then 1 else 0 end) as sx"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'I' then 1 else 0 end) as i"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IP' then 1 else 0 end) as ip"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IX' then 1 else 0 end) as ix"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CT' then 1 else 0 end) as ct"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CH' then 1 else 0 end) as ch"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CB' then 1 else 0 end) as cb"))
                ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CL' then 1 else 0 end) as cl"))
                ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                ->whereMonth('test_absen_regs.date', $month)
                ->whereYear('test_absen_regs.date', $yearNow)
                ->where('dept', $userDept)
                ->orderBy('users.nik', 'ASC')
                ->groupBy('users.nik')
                ->get();
        }


        $tjk = array();
        foreach ($emp1 as $key => $value) {
            $start_init = $value->date . ' ' . $value->shifter;
            $start_inits[] = $value->date . ' ' . $value->shifter;
            $start = new Carbon($start_init);
            $end = new Carbon($value->masuk);
            $late[] = $start->diff($end)->format('%H:%I:%S');
            $late_init[] = $start->diffInHours($end);

            $jam_masuk = new Carbon($value->masuk);
            $jam_pulang = new Carbon($value->pulang);

            $tjk[] += $jam_masuk->diffInHours($jam_pulang);

        }
        // dd($tjk);

        if (\Auth::user()->role_app == 'Admin') {
            $emp = User::with([
                'absen_reg' => function ($query) use ($month, $yearNow) {
                    $query->whereMonth('date', $month);
                    $query->whereYear('date', $yearNow);
                },
            ])->get()->groupBy(function ($item) {
                return $item->dept;
            });
            $dept = User::groupBy('dept')->get();
        } else {
            $emp = User::where('dept', $dept)->with([
                'absen_reg' => function ($query) use ($month, $yearNow) {
                    $query->whereMonth('date', $month);
                    $query->whereYear('date', $yearNow);
                },
            ])->get()->groupBy(function ($item) {
                return $item->dept;
            });
        }

        // if (\Auth::user()->role_app == 'Admin') {
        //     $emp = User::with([
        //         'absen_reg' => function ($query) use ($month, $yearNow) {
        //             $query->whereMonth('date', $month);
        //             $query->whereYear('date', $yearNow);
        //         }
        //     ])->where('dept', 'factory') // Filter for 'factory' department
        //         ->get()
        //         ->groupBy(function ($item) {
        //             return $item->dept;
        //         });
        //     $dept = User::where('dept', 'factory')->groupBy('dept')->get(); // Only get 'factory' department
        // } else {
        //     $emp = User::where('dept', $dept)->with([
        //         'absen_reg' => function ($query) use ($month, $yearNow) {
        //             $query->whereMonth('date', $month);
        //             $query->whereYear('date', $yearNow);
        //         }
        //     ])->where('dept', 'factory') // Filter for 'factory' department
        //         ->get()
        //         ->groupBy(function ($item) {
        //             return $item->dept;
        //         });
        // }


        return view('admin.pages.attendance-per-dept-reg-new', [
            'dateP' => $dateP,
            'cToDays' => $cToDays,
            'colSpan' => $colSpan,
            'day1' => $day1,
            'dept' => $dept,
            'emp' => $emp,
            'monthLabel' => $monthLabel,
            'yearNow' => $yearNow,
            'month' => $month,
            'status' => $status,
            'date1' => $date1,
            'emp1' => $emp1,
            'late' => $late,
            'start_inits' => $start_inits,
            'late_init' => $late_init,
            'totalDay' => $totalDay,
        ]);
    }

    public function index_filter(Request $request)
    {
        $monthLabel = $request->datex;
        $monthF = Carbon::parse($monthLabel);
        $dateP = Carbon::parse($monthLabel)->format('d-M-Y');
        $month = Carbon::parse($monthLabel)->format('m');
        $yearNow = Carbon::parse($monthLabel)->format('Y');
        $depts = $request->dept;
        $date1 = null;
        $dept = User::groupBy('dept')->get();
        $day1 = range(1, $monthF->month($month)->daysInMonth);
        $day = (implode(",", $day1));
        $cDay = count($day1);
        $colSpan = $cDay;

        $firstDay = Carbon::parse(Carbon::now())->firstOfMonth();
        $totalDay = Carbon::parse(Carbon::now())->daysInMonth;
        $todateDay = Carbon::parse(Carbon::now());
        $cToDay = $firstDay->diffInDays($todateDay);
        $cToDays = $colSpan - $cToDay;

        if (Auth::user()->dept == 'BSKP' || Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'HR & Legal') {

            if ($depts == 'null') {
                $emp = User::with([
                    'absen_reg' => function ($query) use ($month, $yearNow) {
                        $query->whereMonth('date', $month);
                        $query->whereYear('date', $yearNow);
                    },
                ])->get()
                    ->groupBy(function ($item, $val) {
                        return $item->dept;
                    });
            } else {
                $emp = User::where('dept', $depts)->with([
                    'absen_reg' => function ($query) use ($month, $yearNow) {
                        $query->whereMonth('date', $month);
                        $query->whereYear('date', $yearNow);
                    },
                ])->get()
                    ->groupBy(function ($item, $val) {
                        return $item->dept;
                    });
            }

        } else {

            $emp = User::where('dept', \Auth::user()->dept)->with([
                'absen_reg' => function ($query) use ($month, $yearNow) {
                    $query->whereMonth('date', $month);
                    $query->whereYear('date', $yearNow);
                },
            ])
                ->latest()->get()
                ->groupBy(function ($item, $val) {
                    return $item->dept;
                });
        }
        return view('admin.pages.attendance-per-dept-reg', ['dateP' => $dateP, 'colSpan' => $colSpan, 'day1' => $day1, 'dept' => $dept, 'emp' => $emp, 'monthLabel' => $monthLabel, 'month' => $month, 'yearNow' => $yearNow, 'date1' => $date1]);
    }

    public function index_filter_new(Request $request)
    {
        $monthLabel = $request->datex1;
        $monthF = Carbon::parse($monthLabel);
        $dateP = Carbon::parse($monthLabel)->format('d-M-Y');
        $month = Carbon::parse($monthLabel)->format('m');
        $yearNow = Carbon::parse($monthLabel)->format('Y');
        $depts = $request->dept;
        $status_req = $request->status;
        $dept = User::groupBy('dept')->get();
        $status = User::groupBy('status')->get();
        $day1 = range(1, $monthF->month($month)->daysInMonth);
        $day = (implode(",", $day1));
        $cDay = count($day1);
        $colSpan = $cDay;

        $date1 = $request->datex1;
        $date2 = $request->datex2;

        $firstDay = Carbon::parse(Carbon::now())->firstOfMonth();
        $totalDay = Carbon::parse(Carbon::now())->daysInMonth;
        $todateDay = Carbon::parse(Carbon::now());
        $cToDay = $firstDay->diffInDays($todateDay);
        $cToDays = $colSpan - $cToDay;

        if (Auth::user()->dept == 'BSKP' || Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'HR & Legal') {

            if ($depts == 'null') {
                $emp1 = DB::table('users')
                    ->join('test_absen_regs', 'users.nik', '=', 'test_absen_regs.user_id')
                    ->leftJoin('master_shifts', 'test_absen_regs.shift', '=', 'master_shifts.id')
                    ->select(
                        'users.name',
                        'test_absen_regs.date',
                        'users.nik',
                        'users.jabatan',
                        'users.name',
                        'master_shifts.start_work as shifter',
                        'master_shifts.end_work as shifter_end',
                        'users.status',
                        'users.start_work_user',
                        'users.end_work_user',
                        'test_absen_regs.start_work as masuk',
                        'test_absen_regs.end_work as pulang',
                        'test_absen_regs.desc',
                        DB::raw("SUM(total_hour) as thour"),
                        DB::raw("SUM(total_minute) as tmin"),
                        DB::raw("SUM(overtime_hour) as othour"),
                        DB::raw("SUM(overtime_minute) as otmin"),
                        DB::raw("SUM(late_hour) as latehour"),
                        DB::raw("SUM(late_minute) as latemin"),
                        DB::raw("(SUM(HOUR(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkx"),
                        DB::raw("(SUM(MINUTE(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkm"),
                        DB::raw("(SUM(SECOND(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjks"),
                        DB::raw("(SUM(time_to_sec(timediff(concat(test_absen_regs.date,' ',master_shifts.end_work), concat(test_absen_regs.date,' ',master_shifts.start_work)))/3600)) as shift"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(HOUR(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as late"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(MINUTE(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as latem"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(SECOND(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as lates"),
                    )
                    ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, test_absen_regs.start_work, test_absen_regs.end_work)/3600) as tjk'))
                    ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, master_shifts.start_work, master_shifts.end_work)/3600) as shift'))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'H' then 1 else 0 end) as h"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'L' then 1 else 0 end) as l"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'TA' then 1 else 0 end) as ta"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'D' then 1 else 0 end) as d"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'M' then 1 else 0 end) as m"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'MX' then 1 else 0 end) as mx"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'S' then 1 else 0 end) as s"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'SX' then 1 else 0 end) as sx"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'I' then 1 else 0 end) as i"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IP' then 1 else 0 end) as ip"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IX' then 1 else 0 end) as ix"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CT' then 1 else 0 end) as ct"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CH' then 1 else 0 end) as ch"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CB' then 1 else 0 end) as cb"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CL' then 1 else 0 end) as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->whereBetween('test_absen_regs.date', [$date1, $date2])
                    ->whereNot('test_absen_regs.shift', null)
                    ->where('users.active', 'yes')
                    ->orderBy('users.nik', 'ASC')
                    ->groupBy('users.nik')
                    ->get();

                $tjk = array();
                foreach ($emp1 as $key => $value) {
                    $start_init = $value->date . ' ' . $value->shifter;
                    $start_inits[] = $value->date . ' ' . $value->shifter;
                    $start = new Carbon($start_init);
                    $end = new Carbon($value->masuk);
                    $late[] = $start->diff($end)->format('%H:%I:%S');
                    $late_init[] = $start->diffInHours($end);

                    $jam_masuk = new Carbon($value->masuk);
                    $jam_pulang = new Carbon($value->pulang);

                    $tjk[] += $jam_masuk->diffInHours($jam_pulang);

                }

            } else if ($depts != null && $status_req == 'null') {
                $emp1 = DB::table('test_absen_regs')
                    ->rightJoin('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('master_shifts', 'users.shift_code', '=', 'master_shifts.id')
                    ->select(
                        'users.name',
                        'test_absen_regs.date',
                        'users.nik',
                        'users.jabatan',
                        'users.name',
                        'master_shifts.start_work as shifter',
                        'master_shifts.end_work as shifter_end',
                        'users.status',
                        'users.start_work_user',
                        'users.end_work_user',
                        'test_absen_regs.start_work as masuk',
                        'test_absen_regs.end_work as pulang',
                        'test_absen_regs.desc',
                        DB::raw("SUM(total_hour) as thour"),
                        DB::raw("SUM(total_minute) as tmin"),
                        DB::raw("SUM(overtime_hour) as othour"),
                        DB::raw("SUM(overtime_minute) as otmin"),
                        DB::raw("SUM(late_hour) as latehour"),
                        DB::raw("SUM(late_minute) as latemin"),
                        DB::raw("(SUM(HOUR(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkx"),
                        DB::raw("(SUM(MINUTE(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkm"),
                        DB::raw("(SUM(SECOND(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjks"),
                        DB::raw("(SUM(time_to_sec(timediff(concat(test_absen_regs.date,' ',master_shifts.end_work), concat(test_absen_regs.date,' ',master_shifts.start_work)))/3600)) as shift"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(HOUR(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as late"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(MINUTE(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as latem"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(SECOND(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as lates"),
                    )
                    ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, test_absen_regs.start_work, test_absen_regs.end_work)/3600) as tjk'))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'H' then 1 else 0 end) as h"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'L' then 1 else 0 end) as l"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'TA' then 1 else 0 end) as ta"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'D' then 1 else 0 end) as d"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'M' then 1 else 0 end) as m"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'MX' then 1 else 0 end) as mx"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'S' then 1 else 0 end) as s"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'SX' then 1 else 0 end) as sx"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'I' then 1 else 0 end) as i"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IP' then 1 else 0 end) as ip"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IX' then 1 else 0 end) as ix"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CT' then 1 else 0 end) as ct"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CH' then 1 else 0 end) as ch"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CB' then 1 else 0 end) as cb"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CL' then 1 else 0 end) as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->whereBetween('test_absen_regs.date', [$date1, $date2])
                    ->where('users.active', 'yes')
                    ->orderBy('users.nik', 'ASC')
                    ->groupBy('users.nik')
                    ->get();
            } else {
                $emp1 = DB::table('test_absen_regs')
                    ->rightJoin('users', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->join('master_shifts', 'users.shift_code', '=', 'master_shifts.id')
                    ->select(
                        'users.name',
                        'test_absen_regs.date',
                        'users.nik',
                        'users.jabatan',
                        'users.name',
                        'master_shifts.start_work as shifter',
                        'master_shifts.end_work as shifter_end',
                        'users.status',
                        'users.start_work_user',
                        'users.end_work_user',
                        'test_absen_regs.start_work as masuk',
                        'test_absen_regs.end_work as pulang',
                        'test_absen_regs.desc',
                        DB::raw("SUM(total_hour) as thour"),
                        DB::raw("SUM(total_minute) as tmin"),
                        DB::raw("SUM(overtime_hour) as othour"),
                        DB::raw("SUM(overtime_minute) as otmin"),
                        DB::raw("SUM(late_hour) as latehour"),
                        DB::raw("SUM(late_minute) as latemin"),
                        DB::raw("(SUM(HOUR(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkx"),
                        DB::raw("(SUM(MINUTE(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkm"),
                        DB::raw("(SUM(SECOND(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjks"),
                        DB::raw("(SUM(time_to_sec(timediff(concat(test_absen_regs.date,' ',master_shifts.end_work), concat(test_absen_regs.date,' ',master_shifts.start_work)))/3600)) as shift"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(HOUR(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as late"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(MINUTE(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as latem"),
                        DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(SECOND(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as lates"),
                    )
                    ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, test_absen_regs.start_work, test_absen_regs.end_work)/3600) as tjk'))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'H' then 1 else 0 end) as h"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'L' then 1 else 0 end) as l"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'TA' then 1 else 0 end) as ta"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'D' then 1 else 0 end) as d"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'M' then 1 else 0 end) as m"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'MX' then 1 else 0 end) as mx"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'S' then 1 else 0 end) as s"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'SX' then 1 else 0 end) as sx"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'I' then 1 else 0 end) as i"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IP' then 1 else 0 end) as ip"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IX' then 1 else 0 end) as ix"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CT' then 1 else 0 end) as ct"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CH' then 1 else 0 end) as ch"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CB' then 1 else 0 end) as cb"))
                    ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CL' then 1 else 0 end) as cl"))
                    ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->whereBetween('test_absen_regs.date', [$date1, $date2])
                    ->where('users.active', 'yes')
                    ->orderBy('users.nik', 'ASC')
                    ->groupBy('users.nik')
                    ->get();

            }
        }
        return view('admin.pages.attendance-per-dept-reg-new', [
            'dateP' => $dateP,
            'colSpan' => $colSpan,
            'day1' => $day1,
            'dept' => $dept,
            'emp1' => $emp1,
            'monthLabel' => $monthLabel,
            'month' => $month,
            'yearNow' => $yearNow,
            'status' => $status,
            'date1' => $date1,
            'date2' => $date2,
            'tjk' => $tjk,
            'start_inits' => $start_inits,
            'late_init' => $late_init,
            'totalDay' => $totalDay,
        ]);
    }

    public function export_pdf(Request $request)
    {
        $dept = $request->dept;
        $month = $request->month;
        $yearNow = $request->year;

        $date = Carbon::createFromDate($yearNow, $month, 1);

        $monthLabel = $date->translatedFormat('F');

        $status = User::groupBy('status')->get();
        $totalDay = Carbon::parse($date)->daysInMonth;

        $emp1 = DB::table('users')
            ->join('test_absen_regs', 'users.nik', '=', 'test_absen_regs.user_id')
            ->leftJoin('master_shifts', 'test_absen_regs.shift', '=', 'master_shifts.id')
            ->select(
                'users.name',
                'test_absen_regs.date',
                'users.nik',
                'users.jabatan',
                'users.name',
                'master_shifts.start_work as shifter',
                'master_shifts.end_work as shifter_end',
                'users.status',
                'users.start_work_user',
                'users.end_work_user',
                'test_absen_regs.start_work as masuk',
                'test_absen_regs.end_work as pulang',
                'test_absen_regs.desc',
                'test_absen_regs.hadir',
                DB::raw("SUM(total_hour) as thour"),
                DB::raw("SUM(total_minute) as tmin"),
                DB::raw("SUM(overtime_hour) as othour"),
                DB::raw("SUM(overtime_minute) as otmin"),
                DB::raw("SUM(late_hour) as latehour"),
                DB::raw("SUM(late_minute) as latemin"),
                DB::raw("(SUM(HOUR(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkx"),
                DB::raw("(SUM(MINUTE(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjkm"),
                DB::raw("(SUM(SECOND(timediff(test_absen_regs.end_work, test_absen_regs.start_work)))) as tjks"),
                DB::raw("(SUM(time_to_sec(timediff(concat(test_absen_regs.date,' ',master_shifts.end_work), concat(test_absen_regs.date,' ',master_shifts.start_work)))/3600)) as shift"),
                DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(HOUR(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as late"),
                DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(MINUTE(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as latem"),
                DB::raw("(SUM(case when test_absen_regs.desc = 'L' then time_to_sec(SECOND(timediff(test_absen_regs.start_work, concat(test_absen_regs.date,' ',master_shifts.start_work)))) else 0 end)) as lates"),
            )
            ->addSelect(DB::raw('SUM(TIMESTAMPDIFF(SECOND, test_absen_regs.start_work, test_absen_regs.end_work)/3600) as tjk'))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'H' then 1 else 0 end) as h"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'L' then 1 else 0 end) as l"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'TA' then 1 else 0 end) as ta"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'D' then 1 else 0 end) as d"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'M' then 1 else 0 end) as m"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'MX' then 1 else 0 end) as mx"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'S' then 1 else 0 end) as s"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'SX' then 1 else 0 end) as sx"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'I' then 1 else 0 end) as i"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IP' then 1 else 0 end) as ip"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'IX' then 1 else 0 end) as ix"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CT' then 1 else 0 end) as ct"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CH' then 1 else 0 end) as ch"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CB' then 1 else 0 end) as cb"))
            ->addSelect(DB::raw("SUM(case when test_absen_regs.desc = 'CL' then 1 else 0 end) as cl"))
            ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
            ->whereMonth('test_absen_regs.date', $month)
            ->whereYear('test_absen_regs.date', $yearNow)
            ->where('users.active', 'yes')
            ->where('users.dept', $dept)
            // ->where('users.loc_kerja', 'Head Office')
            ->orderBy('users.jabatan', 'ASC')
            ->groupBy('users.nik')
            ->get();

        $tjk = array();
        foreach ($emp1 as $key => $value) {
            $start_init = $value->date . ' ' . $value->shifter;
            $start_inits[] = $value->date . ' ' . $value->shifter;
            $start = new Carbon($start_init);
            $end = new Carbon($value->masuk);
            $late[] = $start->diff($end)->format('%H:%I:%S');
            $late_init[] = $start->diffInHours($end);

            $jam_masuk = new Carbon($value->masuk);
            $jam_pulang = new Carbon($value->pulang);

            $tjk[] += $jam_masuk->diffInHours($jam_pulang);

        }
        // dd($tjk);

        // if (\Auth::user()->role_app == 'Admin') {
        //     $emp = User::with(['absen_reg' => function ($query) use ($month, $yearNow) {
        //         $query->whereMonth('date', $month);
        //         $query->whereYear('date', $yearNow);
        //     }])->get()->groupBy(function ($item) {
        //         return $item->dept;
        //     });
        //     $dept = User::groupBy('dept')->get();
        // } else {
        //     $emp = User::where('dept', $dept)->with(['absen_reg' => function ($query) use ($month, $yearNow) {
        //         $query->whereMonth('date', $month);
        //         $query->whereYear('date', $yearNow);
        //     }])->get()->groupBy(function ($item) {
        //         return $item->dept;
        //     });
        // }

        $data = [
            'dept' => $dept,
            'monthLabel' => $monthLabel,
            'yearNow' => $yearNow,
            'month' => $month,
            'status' => $status,
            'emp1' => $emp1,
            'late' => $late,
            'start_inits' => $start_inits,
            'late_init' => $late_init,
            'totalDay' => $totalDay,
        ];

        // F4 = array(0,0,609.4488,935.433)
        $filename = "Laporan Kehadiran Departement - {$dept} - {$monthLabel} {$yearNow}.pdf";
        $pdf = PDF::loadView('admin.pages.testing.attendance-per-dept-print', $data)->setPaper(array(0, 0, 609.4488, 935.433), 'landscape');
        $pdf->set_option("isPhpEnabled", true);
        return $pdf->stream($filename);
    }

    public function filter_print()
    {
        $userDept = Auth::user()->dept;

        $getEmployeesDept = User::pluck('dept')->unique();

        $getEmployeesStatus = User::pluck('status')->unique();

        $month = [];

        for ($m = 1; $m <= 12; $m++) {
            $month[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }

        $yearValue = TestingAbsen::selectRaw('YEAR(date) as year')->distinct()->pluck('year');

        return view('admin.pages.testing.index-per-dept-filter', [
            'getEmployeesDept' => $getEmployeesDept,
            'getEmployeesStatus' => $getEmployeesStatus,
            'month' => $month,
            'yearValue' => $yearValue,
            'userDept' => $userDept
        ]);
    }

    public function filter_dept()
    {
        $userDept = Auth::user()->dept;

        $getEmployeesDept = User::pluck('dept')->unique();

        return view(
            'admin.pages.summary-per-dept.summary-per-dept',
            [
                'getEmployeesDept' => $getEmployeesDept,
                'userDept' => $userDept
            ]
        );
    }

    public function filter_mandor(Request $request)
    {
        $dept = $request->dept;

        if ($dept == 'I/A' || $dept == 'I/B' || $dept == 'I/C' || $dept == 'II/D' || $dept == 'II/E' || $dept == 'II/F') {
            $mandor = User::where('dept', $dept)
                ->select('nik', 'name')
                ->where('jabatan', 'Mandor Tapping')
                ->orderBy('name')
                ->get();
        } else if ($dept == 'Factory') {
            $mandor = User::where('dept', $dept)
                ->select('nik', 'name')
                ->where('jabatan', 'Mandor')
                ->get();
        } else {
            $mandor = User::where('dept', $dept)->select('nik', 'name')->get();
        }

        return view(
            'admin.pages.summary-per-dept.summary-per-dept-mandor',
            [
                'mandor' => $mandor,
                'dept' => $dept
            ]
        );
    }

    public function result(Request $request)
    {
        $dept = $request->dept;
        $mandor = $request->mandor;
        $date = $request->datePick;

        if ($dept == 'I/A' || $dept == 'I/C' || $dept == 'II/E' || $dept == 'II/F') {
            if ($mandor == null) {
                $latestUpdatedAt = AbsenReg::latest('updated_at')->value('updated_at');
                $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

                $staffAtt = DB::table('absen_regs')
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
                    // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', $dept)
                    ->where('users.status', 'Staff')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $monAtt = DB::table('absen_regs')
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
                    // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', $dept)
                    ->where('users.status', 'Monthly')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $regAtt = DB::table('absen_regs')
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
                    // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', $dept)
                    ->where('users.status', 'Regular')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $flAtt = DB::table('absen_regs')
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
                    // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', $dept)
                    ->where('users.status', 'Contract FL')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $bskpAtt = DB::table('absen_regs')
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
                    // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', $dept)
                    ->where('users.status', 'Contract BSKP')
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAtt = DB::table('absen_regs')
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
                    // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                    ->where('users.active', 'yes')
                    ->where('users.dept', $dept)
                    ->whereDate('absen_regs.date', $date)
                    ->groupBy('users.status')
                    ->get();

                $totalAttFinal = $totalAtt->sum(function ($item) {
                    return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                });

                $totalHFinal = $totalAtt->sum('h');
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

                return view(
                    'admin.pages.summary-per-dept.summary-per-dept-result',
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
                        'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                    ]
                );
            } else {
                $latestUpdatedAt = AbsenReg::latest('updated_at')->value('updated_at');
                $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

                $data = [];

                $totalRegularTotal1 = 0;
                $totalFlTotal1 = 0;
                $totalBskpTotal1 = 0;

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

                $totalHTotalBskp = 0;
                $totalTATotalBskp = 0;
                $totalDTotalBskp = 0;
                $totalLTotalBskp = 0;
                $totalMTotalBskp = 0;
                $totalMXTotalBskp = 0;
                $totalSTotalBskp = 0;
                $totalSXTotalBskp = 0;
                $totalITotalBskp = 0;
                $totalIPTotalBskp = 0;
                $totalIXTotalBskp = 0;
                $totalCTTotalBskp = 0;
                $totalCHTotalBskp = 0;
                $totalCBTotalBskp = 0;
                $totalCLTotalBskp = 0;

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
                        ->where('status', 'Contract FL')
                        ->where('users.active', 'yes')
                        ->count('dept');

                    $totalFlTotal1 += $flTotal1;

                    $bskpTotal1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('dept', $dept)
                        ->where('status', 'Contract BSKP')
                        ->where('users.active', 'yes')
                        ->count('dept');

                    $totalBskpTotal1 += $bskpTotal1;

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
                        ->where('users.status', 'Contract FL')
                        ->whereDate('absen_regs.date', $date)
                        ->where('users.active', 'yes')
                        ->get();

                    $empBskp1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->join('absen_regs', 'mandor_tappers.user_sub', '=', 'absen_regs.user_id')
                        ->select(
                            'users.nik',
                            'users.name',
                            'absen_regs.desc'
                        )
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract BSKP')
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
                        // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                        ->where('users.active', 'yes')
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Regular')
                        ->whereDate('absen_regs.date', $date)
                        ->get();

                    $totalAttregFinal = $regAtt1->sum(function ($item) {
                        return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                    });

                    // dd($totalAttregFinal);

                    $totalHFinalReg = $regAtt1->sum('h');
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
                        // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                        ->where('users.active', 'yes')
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract FL')
                        ->whereDate('absen_regs.date', $date)
                        ->groupBy('users.status')
                        ->get();

                    $totalAttflFinal = $flAtt1->sum(function ($item) {
                        return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                    });

                    $totalHFinalFl = $flAtt1->sum('h');
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

                    $bskpAtt1 = DB::table('absen_regs')
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
                        // ->addSelect(DB::raw("SUM(test_absen_regs.hadir = '1') as hadir"))
                        ->where('users.active', 'yes')
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract BSKP')
                        ->whereDate('absen_regs.date', $date)
                        ->groupBy('users.status')
                        ->get();

                    $totalAttbskpFinal = $bskpAtt1->sum(function ($item) {
                        return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                    });

                    $totalHFinalBskp = $bskpAtt1->sum('h');
                    $totalTAFinalBskp = $bskpAtt1->sum('ta');
                    $totalDFinalBskp = $bskpAtt1->sum('d');
                    $totalLFinalBskp = $bskpAtt1->sum('l');
                    $totalMFinalBskp = $bskpAtt1->sum('m');
                    $totalMXFinalBskp = $bskpAtt1->sum('mx');
                    $totalSFinalBskp = $bskpAtt1->sum('s');
                    $totalSXFinalBskp = $bskpAtt1->sum('sx');
                    $totalIFinalBskp = $bskpAtt1->sum('i');
                    $totalIPFinalBskp = $bskpAtt1->sum('ip');
                    $totalIXFinalBskp = $bskpAtt1->sum('ix');
                    $totalCTFinalBskp = $bskpAtt1->sum('ct');
                    $totalCHFinalBskp = $bskpAtt1->sum('ch');
                    $totalCBFinalBskp = $bskpAtt1->sum('cb');
                    $totalCLFinalBskp = $bskpAtt1->sum('cl');

                    $totalHTotalBskp += $totalHFinalBskp;
                    $totalTATotalBskp += $totalTAFinalBskp;
                    $totalDTotalBskp += $totalDFinalBskp;
                    $totalLTotalBskp += $totalLFinalBskp;
                    $totalMTotalBskp += $totalMFinalBskp;
                    $totalMXTotalBskp += $totalMXFinalBskp;
                    $totalSTotalBskp += $totalSFinalBskp;
                    $totalSXTotalBskp += $totalSXFinalBskp;
                    $totalITotalBskp += $totalIFinalBskp;
                    $totalIPTotalBskp += $totalIPFinalBskp;
                    $totalIXTotalBskp += $totalIXFinalBskp;
                    $totalCTTotalBskp += $totalCTFinalBskp;
                    $totalCHTotalBskp += $totalCHFinalBskp;
                    $totalCBTotalBskp += $totalCBFinalBskp;
                    $totalCLTotalBskp += $totalCLFinalBskp;

                    $item = [
                        'mandor' => $mandor,
                        'mandorName' => $mandorName,
                        'regularTotal1' => $regularTotal1,
                        'flTotal1' => $flTotal1,
                        'bskpTotal1' => $bskpTotal1,
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
                        'totalHFinalBskp' => $totalHFinalBskp,
                        'totalTAFinalBskp' => $totalTAFinalBskp,
                        'totalDFinalBskp' => $totalDFinalBskp,
                        'totalLFinalBskp' => $totalLFinalBskp,
                        'totalMFinalBskp' => $totalMFinalBskp,
                        'totalMXFinalBskp' => $totalMXFinalBskp,
                        'totalSFinalBskp' => $totalSFinalBskp,
                        'totalSXFinalBskp' => $totalSXFinalBskp,
                        'totalIFinalBskp' => $totalIFinalBskp,
                        'totalIPFinalBskp' => $totalIPFinalBskp,
                        'totalIXFinalBskp' => $totalIXFinalBskp,
                        'totalCTFinalBskp' => $totalCTFinalBskp,
                        'totalCHFinalBskp' => $totalCHFinalBskp,
                        'totalCBFinalBskp' => $totalCBFinalBskp,
                        'totalCLFinalBskp' => $totalCLFinalBskp,
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
                        'totalBskpTotal1' => $totalBskpTotal1,
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
                        'totalHTotalBskp' => $totalHTotalBskp,
                        'totalTATotalBskp' => $totalTATotalBskp,
                        'totalDTotalBskp' => $totalDTotalBskp,
                        'totalLTotalBskp' => $totalLTotalBskp,
                        'totalMTotalBskp' => $totalMTotalBskp,
                        'totalMXTotalBskp' => $totalMXTotalBskp,
                        'totalSTotalBskp' => $totalSTotalBskp,
                        'totalSXTotalBskp' => $totalSXTotalBskp,
                        'totalITotalBskp' => $totalITotalBskp,
                        'totalIPTotalBskp' => $totalIPTotalBskp,
                        'totalIXTotalBskp' => $totalIXTotalBskp,
                        'totalCTTotalBskp' => $totalCTTotalBskp,
                        'totalCHTotalBskp' => $totalCHTotalBskp,
                        'totalCBTotalBskp' => $totalCBTotalBskp,
                        'totalCLTotalBskp' => $totalCLTotalBskp,
                        'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                    ]
                );
            }
        } elseif ($dept == 'I/B' || $dept == 'II/D') {
            if ($mandor == null) {
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
                    return (int) $item->hadir + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
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

                return view(
                    'admin.pages.summary-per-dept.summary-per-dept-result',
                    [
                        'dept' => $dept,
                        'date' => $date,
                        'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime,
                        'staffAtt' => $staffAtt,
                        'monAtt' => $monAtt,
                        'regAtt' => $regAtt,
                        'flAtt' => $flAtt,
                        'bskpAtt' => $bskpAtt,
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
                    ]
                );
            } else {
                // $latestUpdatedAt = TestingAbsen::latest('updated_at')->value('updated_at');
                // $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

                $latestUpdatedAt = TestingAbsen::whereDate('updated_at', $date)->latest('updated_at')->value('updated_at');
                $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

                $data = [];

                $totalRegularTotal1 = 0;
                $totalFlTotal1 = 0;
                $totalBskpTotal1 = 0;

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

                $totalHTotalBskp = 0;
                $totalTATotalBskp = 0;
                $totalDTotalBskp = 0;
                $totalLTotalBskp = 0;
                $totalMTotalBskp = 0;
                $totalMXTotalBskp = 0;
                $totalSTotalBskp = 0;
                $totalSXTotalBskp = 0;
                $totalITotalBskp = 0;
                $totalIPTotalBskp = 0;
                $totalIXTotalBskp = 0;
                $totalCTTotalBskp = 0;
                $totalCHTotalBskp = 0;
                $totalCBTotalBskp = 0;
                $totalCLTotalBskp = 0;

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
                        ->where('status', 'Contract FL')
                        ->where('users.active', 'yes')
                        ->count('dept');

                    $totalFlTotal1 += $flTotal1;

                    $bskpTotal1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('dept', $dept)
                        ->where('status', 'Contract BSKP')
                        ->where('users.active', 'yes')
                        ->count('dept');

                    $totalBskpTotal1 += $bskpTotal1;

                    $empReg1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                        ->select(
                            'users.nik',
                            'users.name',
                            'test_absen_regs.desc'
                        )
                        ->where('mandor_tappers.user_id', $mandor)
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
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract FL')
                        ->whereDate('test_absen_regs.date', $date)
                        ->where('users.active', 'yes')
                        ->get();

                    $empBskp1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                        ->select(
                            'users.nik',
                            'users.name',
                            'test_absen_regs.desc'
                        )
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract BSKP')
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
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Regular')
                        ->whereDate('test_absen_regs.date', $date)
                        ->get();

                    $totalAttregFinal = $regAtt1->sum(function ($item) {
                        return (int) $item->hadir + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
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
                        ->where('mandor_tappers.user_id', $mandor)
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

                    $bskpAtt1 = DB::table('test_absen_regs')
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
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract BSKP')
                        ->whereDate('test_absen_regs.date', $date)
                        ->groupBy('users.status')
                        ->get();

                    $totalAttbskpFinal = $bskpAtt1->sum(function ($item) {
                        return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                    });

                    $totalHFinalBskp = $bskpAtt1->sum('hadir');
                    $totalTAFinalBskp = $bskpAtt1->sum('ta');
                    $totalDFinalBskp = $bskpAtt1->sum('d');
                    $totalLFinalBskp = $bskpAtt1->sum('l');
                    $totalMFinalBskp = $bskpAtt1->sum('m');
                    $totalMXFinalBskp = $bskpAtt1->sum('mx');
                    $totalSFinalBskp = $bskpAtt1->sum('s');
                    $totalSXFinalBskp = $bskpAtt1->sum('sx');
                    $totalIFinalBskp = $bskpAtt1->sum('i');
                    $totalIPFinalBskp = $bskpAtt1->sum('ip');
                    $totalIXFinalBskp = $bskpAtt1->sum('ix');
                    $totalCTFinalBskp = $bskpAtt1->sum('ct');
                    $totalCHFinalBskp = $bskpAtt1->sum('ch');
                    $totalCBFinalBskp = $bskpAtt1->sum('cb');
                    $totalCLFinalBskp = $bskpAtt1->sum('cl');

                    $totalHTotalBskp += $totalHFinalBskp;
                    $totalTATotalBskp += $totalTAFinalBskp;
                    $totalDTotalBskp += $totalDFinalBskp;
                    $totalLTotalBskp += $totalLFinalBskp;
                    $totalMTotalBskp += $totalMFinalBskp;
                    $totalMXTotalBskp += $totalMXFinalBskp;
                    $totalSTotalBskp += $totalSFinalBskp;
                    $totalSXTotalBskp += $totalSXFinalBskp;
                    $totalITotalBskp += $totalIFinalBskp;
                    $totalIPTotalBskp += $totalIPFinalBskp;
                    $totalIXTotalBskp += $totalIXFinalBskp;
                    $totalCTTotalBskp += $totalCTFinalBskp;
                    $totalCHTotalBskp += $totalCHFinalBskp;
                    $totalCBTotalBskp += $totalCBFinalBskp;
                    $totalCLTotalBskp += $totalCLFinalBskp;

                    $item = [
                        'mandor' => $mandor,
                        'mandorName' => $mandorName,
                        'regularTotal1' => $regularTotal1,
                        'flTotal1' => $flTotal1,
                        'bskpTotal1' => $bskpTotal1,
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
                        'totalHFinalBskp' => $totalHFinalBskp,
                        'totalTAFinalBskp' => $totalTAFinalBskp,
                        'totalDFinalBskp' => $totalDFinalBskp,
                        'totalLFinalBskp' => $totalLFinalBskp,
                        'totalMFinalBskp' => $totalMFinalBskp,
                        'totalMXFinalBskp' => $totalMXFinalBskp,
                        'totalSFinalBskp' => $totalSFinalBskp,
                        'totalSXFinalBskp' => $totalSXFinalBskp,
                        'totalIFinalBskp' => $totalIFinalBskp,
                        'totalIPFinalBskp' => $totalIPFinalBskp,
                        'totalIXFinalBskp' => $totalIXFinalBskp,
                        'totalCTFinalBskp' => $totalCTFinalBskp,
                        'totalCHFinalBskp' => $totalCHFinalBskp,
                        'totalCBFinalBskp' => $totalCBFinalBskp,
                        'totalCLFinalBskp' => $totalCLFinalBskp,
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
                        'totalBskpTotal1' => $totalBskpTotal1,
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
                        'totalHTotalBskp' => $totalHTotalBskp,
                        'totalTATotalBskp' => $totalTATotalBskp,
                        'totalDTotalBskp' => $totalDTotalBskp,
                        'totalLTotalBskp' => $totalLTotalBskp,
                        'totalMTotalBskp' => $totalMTotalBskp,
                        'totalMXTotalBskp' => $totalMXTotalBskp,
                        'totalSTotalBskp' => $totalSTotalBskp,
                        'totalSXTotalBskp' => $totalSXTotalBskp,
                        'totalITotalBskp' => $totalITotalBskp,
                        'totalIPTotalBskp' => $totalIPTotalBskp,
                        'totalIXTotalBskp' => $totalIXTotalBskp,
                        'totalCTTotalBskp' => $totalCTTotalBskp,
                        'totalCHTotalBskp' => $totalCHTotalBskp,
                        'totalCBTotalBskp' => $totalCBTotalBskp,
                        'totalCLTotalBskp' => $totalCLTotalBskp,
                        'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                    ]
                );
            }
        } elseif ($dept == 'Factory') {
            if ($mandor == null) {
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

                return view(
                    'admin.pages.summary-per-dept.summary-per-dept-result',
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
                        'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                    ]
                );
            } else {
                $latestUpdatedAt = TestingAbsen::whereDate('updated_at', $date)->latest('updated_at')->value('updated_at');

                $latestUpdatedAtDateTime = Carbon::parse($latestUpdatedAt)->format('H:i');

                $data = [];

                $totalRegularTotal1 = 0;
                $totalFlTotal1 = 0;
                $totalBskpTotal1 = 0;

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

                $totalHTotalBskp = 0;
                $totalTATotalBskp = 0;
                $totalDTotalBskp = 0;
                $totalLTotalBskp = 0;
                $totalMTotalBskp = 0;
                $totalMXTotalBskp = 0;
                $totalSTotalBskp = 0;
                $totalSXTotalBskp = 0;
                $totalITotalBskp = 0;
                $totalIPTotalBskp = 0;
                $totalIXTotalBskp = 0;
                $totalCTTotalBskp = 0;
                $totalCHTotalBskp = 0;
                $totalCBTotalBskp = 0;
                $totalCLTotalBskp = 0;

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
                        ->where('status', 'Contract FL')
                        ->where('users.active', 'yes')
                        ->count('dept');

                    $totalFlTotal1 += $flTotal1;

                    $bskpTotal1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('dept', $dept)
                        ->where('status', 'Contract BSKP')
                        ->where('users.active', 'yes')
                        ->count('dept');

                    $totalBskpTotal1 += $bskpTotal1;

                    $empReg1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                        ->select(
                            'users.nik',
                            'users.name',
                            'test_absen_regs.desc'
                        )
                        ->where('mandor_tappers.user_id', $mandor)
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
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract FL')
                        ->whereDate('test_absen_regs.date', $date)
                        ->where('users.active', 'yes')
                        ->get();

                    $empBskp1 = DB::table('mandor_tappers')
                        ->join('users', 'mandor_tappers.user_sub', '=', 'users.nik')
                        ->join('test_absen_regs', 'mandor_tappers.user_sub', '=', 'test_absen_regs.user_id')
                        ->select(
                            'users.nik',
                            'users.name',
                            'test_absen_regs.desc'
                        )
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract BSKP')
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
                        ->where('mandor_tappers.user_id', $mandor)
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
                        ->where('mandor_tappers.user_id', $mandor)
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

                    $bskpAtt1 = DB::table('test_absen_regs')
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
                        ->where('mandor_tappers.user_id', $mandor)
                        ->where('users.status', 'Contract BSKP')
                        ->whereDate('test_absen_regs.date', $date)
                        ->groupBy('users.status')
                        ->get();

                    $totalAttbskpFinal = $bskpAtt1->sum(function ($item) {
                        return (int) $item->h + (int) $item->l + (int) $item->ta + (int) $item->d + (int) $item->m + (int) $item->mx + (int) $item->s + (int) $item->sx + (int) $item->i + (int) $item->ip + (int) $item->ix + (int) $item->ct + (int) $item->ch + (int) $item->cb + (int) $item->cl;
                    });

                    $totalHFinalBskp = $bskpAtt1->sum('hadir');
                    $totalTAFinalBskp = $bskpAtt1->sum('ta');
                    $totalDFinalBskp = $bskpAtt1->sum('d');
                    $totalLFinalBskp = $bskpAtt1->sum('l');
                    $totalMFinalBskp = $bskpAtt1->sum('m');
                    $totalMXFinalBskp = $bskpAtt1->sum('mx');
                    $totalSFinalBskp = $bskpAtt1->sum('s');
                    $totalSXFinalBskp = $bskpAtt1->sum('sx');
                    $totalIFinalBskp = $bskpAtt1->sum('i');
                    $totalIPFinalBskp = $bskpAtt1->sum('ip');
                    $totalIXFinalBskp = $bskpAtt1->sum('ix');
                    $totalCTFinalBskp = $bskpAtt1->sum('ct');
                    $totalCHFinalBskp = $bskpAtt1->sum('ch');
                    $totalCBFinalBskp = $bskpAtt1->sum('cb');
                    $totalCLFinalBskp = $bskpAtt1->sum('cl');

                    $totalHTotalBskp += $totalHFinalBskp;
                    $totalTATotalBskp += $totalTAFinalBskp;
                    $totalDTotalBskp += $totalDFinalBskp;
                    $totalLTotalBskp += $totalLFinalBskp;
                    $totalMTotalBskp += $totalMFinalBskp;
                    $totalMXTotalBskp += $totalMXFinalBskp;
                    $totalSTotalBskp += $totalSFinalBskp;
                    $totalSXTotalBskp += $totalSXFinalBskp;
                    $totalITotalBskp += $totalIFinalBskp;
                    $totalIPTotalBskp += $totalIPFinalBskp;
                    $totalIXTotalBskp += $totalIXFinalBskp;
                    $totalCTTotalBskp += $totalCTFinalBskp;
                    $totalCHTotalBskp += $totalCHFinalBskp;
                    $totalCBTotalBskp += $totalCBFinalBskp;
                    $totalCLTotalBskp += $totalCLFinalBskp;

                    $item = [
                        'mandor' => $mandor,
                        'mandorName' => $mandorName,
                        'regularTotal1' => $regularTotal1,
                        'flTotal1' => $flTotal1,
                        'bskpTotal1' => $bskpTotal1,
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
                        'totalHFinalBskp' => $totalHFinalBskp,
                        'totalTAFinalBskp' => $totalTAFinalBskp,
                        'totalDFinalBskp' => $totalDFinalBskp,
                        'totalLFinalBskp' => $totalLFinalBskp,
                        'totalMFinalBskp' => $totalMFinalBskp,
                        'totalMXFinalBskp' => $totalMXFinalBskp,
                        'totalSFinalBskp' => $totalSFinalBskp,
                        'totalSXFinalBskp' => $totalSXFinalBskp,
                        'totalIFinalBskp' => $totalIFinalBskp,
                        'totalIPFinalBskp' => $totalIPFinalBskp,
                        'totalIXFinalBskp' => $totalIXFinalBskp,
                        'totalCTFinalBskp' => $totalCTFinalBskp,
                        'totalCHFinalBskp' => $totalCHFinalBskp,
                        'totalCBFinalBskp' => $totalCBFinalBskp,
                        'totalCLFinalBskp' => $totalCLFinalBskp,
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
                        'totalBskpTotal1' => $totalBskpTotal1,
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
                        'totalHTotalBskp' => $totalHTotalBskp,
                        'totalTATotalBskp' => $totalTATotalBskp,
                        'totalDTotalBskp' => $totalDTotalBskp,
                        'totalLTotalBskp' => $totalLTotalBskp,
                        'totalMTotalBskp' => $totalMTotalBskp,
                        'totalMXTotalBskp' => $totalMXTotalBskp,
                        'totalSTotalBskp' => $totalSTotalBskp,
                        'totalSXTotalBskp' => $totalSXTotalBskp,
                        'totalITotalBskp' => $totalITotalBskp,
                        'totalIPTotalBskp' => $totalIPTotalBskp,
                        'totalIXTotalBskp' => $totalIXTotalBskp,
                        'totalCTTotalBskp' => $totalCTTotalBskp,
                        'totalCHTotalBskp' => $totalCHTotalBskp,
                        'totalCBTotalBskp' => $totalCBTotalBskp,
                        'totalCLTotalBskp' => $totalCLTotalBskp,
                        'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
                    ]
                );
            }
        } elseif ($dept == 'BSKP') {
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
                ->where('status', 'Staff')
                ->count('dept');

            $monthlyTotal = DB::table('users')
                ->where('status', 'Monthly')
                ->count('dept');

            $regularTotal = DB::table('users')
                ->where('status', 'Regular')
                ->count('dept');

            $flTotal = DB::table('users')
                ->where('status', 'Contract FL')
                ->count('dept');

            $bskpTotal = DB::table('users')
                ->where('status', 'Contract BSKP')
                ->count('dept');

            return view(
                'admin.pages.summary-per-dept.summary-per-dept-result',
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
                    'latestUpdatedAtDateTime' => $latestUpdatedAtDateTime
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
                'admin.pages.summary-per-dept.summary-per-dept-result-anydept',
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

    public function mandor_per_emp(Request $request)
    {
        $dept = $request->dept;
        $date = $request->date;
        $mandor = $request->mandor_nik;

        $mandorName = User::where('nik', $mandor)->value('name');

        if ($dept == 'Factory') {
            $detailKehadiran = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc'
                )
                ->where('mandor_tappers.user_id', $mandor)
                ->whereNotIn('test_absen_regs.desc', ['L', 'H'])
                ->whereDate('test_absen_regs.date', $date)
                ->orderBy('test_absen_regs.desc', 'asc')
                ->where('users.active', 'yes')
                ->get();

            $detailKehadiranDescL = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                    'test_absen_regs.start_work',
                    'test_absen_regs.start_work_info'
                )
                ->where('mandor_tappers.user_id', $mandor)
                ->where('test_absen_regs.desc', '=', 'L')
                ->whereDate('test_absen_regs.date', $date)
                ->where('users.active', 'yes')
                ->get();
        } else {
            $detailKehadiran = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc'
                )
                ->where('mandor_tappers.user_id', $mandor)
                ->whereNotIn('test_absen_regs.desc', ['L', 'H'])
                ->whereDate('test_absen_regs.date', $date)
                ->orderBy('test_absen_regs.desc', 'asc')
                ->where('users.active', 'yes')
                ->get();

            $detailKehadiranDescL = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                    'test_absen_regs.start_work',
                    'test_absen_regs.start_work_info'
                )
                ->where('mandor_tappers.user_id', $mandor)
                ->where('test_absen_regs.desc', '=', 'L')
                ->whereDate('test_absen_regs.date', $date)
                ->where('users.active', 'yes')
                ->get();
        }

        return view(
            'admin.pages.summary-per-dept.summary-per-dept-mandor-result-detail',
            [
                'dept' => $dept,
                'date' => $date,
                'mandorName' => $mandorName,
                'detailKehadiran' => $detailKehadiran,
                'detailKehadiranDescL' => $detailKehadiranDescL
            ]
        );
    }

    public function mandor_per_emp_dash(Request $request)
    {
        $dept = $request->dept;
        $date = $request->date;
        $mandor = $request->mandor_nik;
        $nilai = substr($mandor, 8, 7);

        $mandorName = User::where('nik', $nilai)->value('name');

        if ($dept == 'Factory') {
            $detailKehadiran = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc'
                )
                ->where('mandor_tappers.user_id', $nilai)
                ->whereNotIn('test_absen_regs.desc', ['L', 'H'])
                ->whereDate('test_absen_regs.date', $date)
                ->orderBy('test_absen_regs.desc', 'asc')
                ->where('users.active', 'yes')
                ->get();

            $detailKehadiranDescL = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                    'test_absen_regs.start_work',
                    'test_absen_regs.start_work_info'
                )
                ->where('mandor_tappers.user_id', $nilai)
                ->where('test_absen_regs.desc', '=', 'L')
                ->whereDate('test_absen_regs.date', $date)
                ->where('users.active', 'yes')
                ->get();
        } else {
            $detailKehadiran = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc'
                )
                ->where('mandor_tappers.user_id', $nilai)
                ->whereNotIn('test_absen_regs.desc', ['L', 'H'])
                ->whereDate('test_absen_regs.date', $date)
                ->orderBy('test_absen_regs.desc', 'asc')
                ->where('users.active', 'yes')
                ->get();

            $detailKehadiranDescL = DB::table('test_absen_regs')
                ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
                ->join('mandor_tappers', 'test_absen_regs.user_id', '=', 'mandor_tappers.user_sub')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.status',
                    'test_absen_regs.desc',
                    'test_absen_regs.start_work',
                    'test_absen_regs.start_work_info'
                )
                ->where('mandor_tappers.user_id', $nilai)
                ->where('test_absen_regs.desc', '=', 'L')
                ->whereDate('test_absen_regs.date', $date)
                ->where('users.active', 'yes')
                ->get();
        }

        return view(
            'admin.pages.summary-per-dept.summary-per-dept-mandor-result-detail',
            [
                'dept' => $dept,
                'date' => $date,
                'mandorName' => $mandorName,
                'detailKehadiran' => $detailKehadiran,
                'detailKehadiranDescL' => $detailKehadiranDescL
            ]
        );
    }

    public function getMandor(Request $request)
    {
        $dept = $request->dept;

        if ($dept == 'I/A' || $dept == 'I/B' || $dept == 'I/C' || $dept == 'II/D' || $dept == 'II/E' || $dept == 'II/F') {
            $mandor = User::where('dept', $dept)
                ->where('jabatan', 'Mandor Tapping')
                ->select('nik', 'name')
                ->orderBy('name')
                ->get();

            return response()->json($mandor);
        } elseif ($dept == 'Factory') {
            $mandor = User::where('dept', $dept)
                ->where('jabatan', 'Mandor')
                ->select('nik', 'name')
                ->orderBy('name')
                ->get();

            return response()->json($mandor);
        } else {
            return response()->json([]);
        }
    }
}

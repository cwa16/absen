<?php

namespace App\Http\Controllers;

use Alert;
use App\Imports\LeaveBudgetImport;
use App\Models\TestingAbsen;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveBudget;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DataTables;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Redirect;
use Auth;

class CutiController extends Controller
{
    public function index(Request $request)
    {

        $now = Carbon::parse(Carbon::now())->format('Y-m-d');
        $year = Carbon::parse($now)->format('Y');

        if (\Auth::user()->dept == 'HR Legal' || \Auth::user()->dept == 'BSKP') {
            if ($request->ajax()) {
                $data = Leave::whereYear('date', $year)->with('user')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nik', function (Leave $leave) {
                        return $leave->user->nik;
                    })
                    ->addColumn('name', function (Leave $leave) {
                        return $leave->user->name;
                    })
                    ->addColumn('dept', function (Leave $leave) {
                        return $leave->user->dept;
                    })
                    ->addColumn('name_sub', function (Leave $leave) {
                        return $leave->user_subs->name;
                    })
                    ->addColumn('start_date', function ($row) {
                        $start_date = date("d F Y", strtotime($row->start_date));
                        return $start_date;
                    })
                    ->addColumn('end_date', function ($row) {
                        $end_date = date("d F Y", strtotime($row->end_date));
                        return $end_date;
                    })
                    ->addColumn('action', 'admin.includes.action-cuti')
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } else {
            if ($request->ajax()) {
                $data = Leave::whereYear('date', $year)->whereHas('user', function (Builder $q) {
                    $q->where('dept', \Auth::user()->dept);
                })->orderBy('date', 'DESC')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nik', function (Leave $leave) {
                        return $leave->user->nik;
                    })
                    ->addColumn('name', function (Leave $leave) {
                        return $leave->user->name;
                    })
                    ->addColumn('dept', function (Leave $leave) {
                        return $leave->user->dept;
                    })
                    ->addColumn('name_sub', function (Leave $leave) {
                        return $leave->user_subs->name;
                    })
                    ->addColumn('start_date', function ($row) {
                        $start_date = date("d F Y", strtotime($row->start_date));
                        return $start_date;
                    })
                    ->addColumn('end_date', function ($row) {
                        $end_date = date("d F Y", strtotime($row->end_date));
                        return $end_date;
                    })
                    ->addColumn('action', 'admin.includes.action-cuti')
                    ->rawColumns(['action'])
                    ->make(true);
            }

        }

        return view('admin.pages.input-cuti');
    }

    // public function print($id)
    // {
    //   $data = Leave::with(['user', 'leave_budget'])->findOrfail($id);
    //   $year = Carbon::parse(Carbon::now())->format('Y');
    //   $user_id = $data->user_id;

    //   $fromC = Carbon::parse($data->start_date)->format('d-m-Y');
    //   $toC = Carbon::parse($data->end_date)->format('d-m-Y');

    //   $from = $data->start_date;
    //   $to = $data->end_date;
    //   $datetime1 = new DateTime($from);
    //   $datetime2 = new DateTime($to);
    //   $interval = $datetime1->diff($datetime2);
    //   $days = $interval->days;

    //   $cek_kind = $data->kind;
    //   switch ($cek_kind) {
    //     case 'Large':
    //       $kind = $data->leave_budget->large;
    //       break;
    //     case 'Yearly':
    //       $kind = $data->leave_budget->yearly;
    //       break;
    //     case 'Birth':
    //       $kind = $data->leave_budget->birth;
    //       break;
    //     case 'Sick':
    //       $kind = $data->leave_budget->sick;
    //       break;
    //     case 'Other':
    //       $kind = $data->leave_budget->other;
    //       break;
    //   }

    //   $assistant = User::where('dept', $data->user->dept)->where('jabatan', 'Assistant Manager')->value('name');

    //   switch ($data->user->dept) {
    //     case ('Acc & Fin'):
    //       $manager = User::where('nik', '203-015')->value('name');
    //       break;
    //     case ('I/A' || 'I/B' || 'I/C'):
    //       $manager = User::where('nik', '190-006')->value('name');
    //       break;
    //     case ('II/D' || 'II/E' || 'II/F'):
    //       $manager = User::where('nik', '200-178')->value('name');
    //       break;
    //     case ('HSE & DP' || 'IT' || 'HR Legal'):
    //       $manager = User::where('nik', '193-007')->value('name');
    //       break;
    //     case ('Workshop' || 'Factory' || 'FSD'):
    //       $manager = User::where('nik', '200-138')->value('name');
    //       break;
    //   }

    //   $hr_manager = 'Johari, SE.';
    //   $mfo = 'Suryani, SP., MP.';
    //   $presdir = 'Daisuke Furuhashi';

    //   $imagePath = public_path("assets/img/logo.png");
    //   $image = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));
    //   return view('admin.pages.form-cuti', ['data' => $data,
    //                                                  'image' => $image,
    //                                                  'manager' => $manager,
    //                                                  'assistant' => $assistant,
    //                                                  'hr_manager' => $hr_manager,
    //                                                  'mfo' => $mfo,
    //                                                  'presdir' => $presdir,
    //                                                  'fromC' => $fromC,
    //                                                  'toC' => $toC,
    //                                                  'days' => $days,
    //                                                  'kind' => $kind]);
    // }

    public function print($id)
    {
        $data = Leave::with(['user', 'leave_budget'])->findOrfail($id);
        $year = Carbon::parse(Carbon::now())->format('Y');
        $year_next = Carbon::parse(Carbon::now()->addYears())->format('Y');
        $user_id = $data->user_id;

        $start_work = Carbon::parse($data->user->start)->format('d-m-Y');
        $fromC = Carbon::parse($data->start_date)->format('d-m-Y');
        $toC = Carbon::parse($data->end_date)->format('d-m-Y');

        $firstLeave = Leave::where('user_id', $user_id)
            ->where('start_date', '<', $data->start_date)
            ->whereYear('date', $year)->latest()->first();

        $nomorForm = 'BSKP/' . $data->id;

        $cek_from = Carbon::parse($data->end_date)->format('Y');

        $from = $data->start_date;
        $to = $data->end_date;
        $datetime1 = new DateTime($from);
        $datetime2 = new DateTime($to);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->days + 1;

        $saldo_tahunan = 12;
        $actual_tahunan = DB::table('leaves')
            ->select(DB::raw('SUM(total) as budget'))
            ->where('user_id', $user_id)
            ->whereYear('date', $year)
            ->where('kind', 'Yearly')
            ->value('budget');

        $actual_tahunan_next = DB::table('leaves')
            ->select(DB::raw('SUM(total) as budget'))
            ->where('user_id', $user_id)
            ->whereYear('end_date', $year_next)
            ->where('kind', 'Yearly')
            ->value('budget');

        $kind = Leave::where('id', $id)->value('kind');

        if ($cek_from == $year_next) {
            $cuti_tahunan = $saldo_tahunan - (int) $actual_tahunan_next;
        } else {
            $cuti_tahunan = $saldo_tahunan - (int) $actual_tahunan;
        }

        $assistant = User::where('dept', $data->user->dept)->where('jabatan', 'Assistant Manager')->value('name');

        switch ($data->user->dept) {
            case('Acc & Fin'):
                $manager = User::where('nik', '203-015')->value('name');
                break;
            case('I/A' || 'I/B' || 'I/C'):
                $manager = User::where('nik', '190-006')->value('name');
                break;
            case('II/D' || 'II/E' || 'II/F'):
                $manager = User::where('nik', '200-178')->value('name');
                break;
            case('HSE & DP' || 'IT' || 'HR Legal'):
                $manager = User::where('nik', '193-007')->value('name');
                break;
            case('Workshop' || 'Factory' || 'FSD'):
                $manager = User::where('nik', '200-138')->value('name');
                break;
        }

        $hr_manager = 'Johari, SE.';
        $mfo = 'Suryani, SP., MP.';
        $presdir = 'Daisuke Furuhashi';

        $imagePath = public_path("assets/img/logo.png");
        $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
        $pdf = PDF::loadView('admin.pages.form-cuti', [
            'data' => $data,
            'image' => $image,
            'manager' => $manager,
            'assistant' => $assistant,
            'hr_manager' => $hr_manager,
            'mfo' => $mfo,
            'presdir' => $presdir,
            'fromC' => $fromC,
            'toC' => $toC,
            'days' => $days,
            'start_work' => $start_work,
            'cuti_tahunan' => $cuti_tahunan,
            'kind' => $kind,
            'firstLeave' => $firstLeave,
            'nomorForm' => $nomorForm,
        ]);
        return $pdf->stream();

    }

    public function input_cuti_new($nik)
    {
        $years = Carbon::now();
        $year = Carbon::parse($years)->format('Y');

        $userDept = Auth::user()->dept;

        if ($userDept == 'HR Legal' || $userDept = 'BSKP') {
            $emp_sub = User::get();
        } else {
            $emp_sub = User::where('dept', $userDept)->get();
        }

        $emp = User::where('nik', $nik)->get();
        $empS = User::where('nik', $nik)->value('dept');
        $empJ = User::where('nik', $nik)->value('jabatan');

        $emp_leave = User::where('nik', $nik)->has('absen_reg')->get();

        $b_leave = LeaveBudget::where('user_id', $nik)->whereYear('date', $year)->get();

        $check = 0;

        $saldo_tahunan = 12;
        // $actual_tahunan = Leave::where('user_id', $nik)->whereYear('date', $year)->where('kind', 'Yearly')->get();
        $actual_tahunan = DB::table('leaves')
            ->select(DB::raw('SUM(total) as budget'))
            ->where('user_id', $nik)
            ->whereYear('date', $year)
            ->where('kind', 'Yearly')
            ->value('budget');
        $cuti_tahunan = $saldo_tahunan - (int) $actual_tahunan;

        // dd($b_leave);
        return view('admin.pages.input-cuti-new', [
            'emp' => $emp,
            'emp_sub' => $emp_sub,
            'b_leave' => $b_leave,
            'empS' => $empS,
            'emp_leave' => $emp_leave,
            'check' => $check,
            'cuti_tahunan' => $cuti_tahunan,
            'empJ' => $empJ,
        ]);
    }

    public function input_cuti_edit($id)
    {
        $years = Carbon::now();
        $year = Carbon::parse($years)->format('Y');
        $emp_sub = User::where('dept', \Auth::user()->dept)->get();
        $leave = Leave::with('user')->findOrFail($id);
        $b_leave = LeaveBudget::where('user_id', $leave->user->id)->whereYear('date', $year)->get();
        return view('admin.pages.input-cuti-edit', [
            'emp_sub' => $emp_sub,
            'b_leave' => $b_leave,
            'leave' => $leave
        ]);
    }

    public function getRowDetails()
    {
        return view('datatables.eloquent.row-details');
    }

    public function list_emp(Request $request)
    {

        if (\Auth::user()->dept == 'HR Legal') {
            if ($request->ajax()) {
                $data = User::whereNot('status', 'contract')->with('leave_budget')->latest();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', 'admin.includes.action-cuti-emp')
                    ->make(true);
            }
        } else {
            if ($request->ajax()) {
                $data = User::whereNot('status', 'contract')->where('dept', \Auth::user()->dept)->with('leave_budget')->latest();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', 'admin.includes.action-cuti-emp')
                    ->make(true);

            }
        }

        return view('admin.pages.input-cuti-list');
    }

    // Ini Diubah
    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $days = $request->days;
        $year = Carbon::parse(Carbon::now())->format('Y');
        $year_next = Carbon::parse(Carbon::now()->addYears())->format('Y');

        $return_date = $request->return;

        $kind = $request->kind;
        $cek_budget = User::where('nik', $user_id)->whereHas('leave_budget')->count();
        $cek_dept = User::where('nik', $user_id)->value('dept');
        $cek_budget_per = LeaveBudget::whereYear('date', $year)->where('user_id', $user_id)->value($kind);
        $saldo_tahunan = 12;

        if ($kind == 'Other') {
            $totalDay = 0;
        } else {
            $totalDay = $request->days;
        }

        $actual_tahunan = DB::table('leaves')
            ->select(DB::raw('SUM(total) as budget'))
            ->where('user_id', $user_id)
            ->whereYear('date', $year)
            ->where('kind', 'Yearly')
            ->value('budget');

        $actual_tahunan_next = DB::table('leaves')
            ->select(DB::raw('SUM(total) as budget'))
            ->where('user_id', $user_id)
            ->whereYear('end_date', $year_next)
            ->where('kind', 'Yearly')
            ->value('budget');


        // dd($act_tahunan);

        $date_req = Carbon::parse($request->to)->format('Y');
        $year_req = Carbon::parse(Carbon::now()->addYears())->format('Y');

        $leave_balance = $request->leave_balance;
        $todate_balance = $leave_balance-$request->days;

        if ($date_req == $year_req) {
            $act_tahunan = (int) $totalDay + (int) $actual_tahunan_next;
        } else {
            $act_tahunan = (int) $totalDay + (int) $actual_tahunan;
        }


        if ($act_tahunan > 12 && $kind != 'Birth' && $date_req != $year_req) {
            Alert::error('Gagal', 'Budget Cuti Habis!!!');
            return redirect()->route('cuti');
        } else if ($act_tahunan > 12 && $kind == 'Birth' && $date_req != $year_req) {
            // $period = CarbonPeriod::between($request->from, $request->to)->filter('isWeekday');

            // foreach ($period as $date) {
            //     $dayx = $date->format('Y-m-d');
            //     $daysx[] = $dayx;
            // }

            $startDate = new DateTime($request->from);
            $endDate = new DateTime($request->to);
            $period = CarbonPeriod::between($request->from, $request->to);
            $sundays = array();

            while ($startDate <= $endDate) {
                if ($startDate->format('w') == 0) {
                    $sundays[] = $startDate->format('Y-m-d');
                }

                $startDate->modify('+1 day');
            }

            $strSunday = implode(",", $sundays);

            $daysx = [];
            foreach ($period as $date) {
                $day = $date->format('Y-m-d');
                $daysx[] = $day;
            }

            $daysxx = array_filter($daysx, function ($date) use ($strSunday) {
                return strtotime($date) != strtotime($strSunday);
            });

            $t_day = count($daysxx);

            $store = Leave::create([
                'user_id' => $user_id,
                'user_sub' => $request->user_sub,
                'date' => Carbon::now(),
                'kind' => $request->kind,
                'start_date' => $request->from,
                'end_date' => $request->to,
                'return_date' => $return_date,
                'total' => $request->days,
                'purpose' => $request->purpose,
            ]);

            foreach ($daysxx as $i => $value) {
                $swW = '' . $daysxx[$i] . ' 08:00:00';
                $ewW = '' . $daysxx[$i] . ' 17:00:00';

                TestingAbsen::updateOrCreate(
                    [
                        'user_id' => $request->get('user_id'),
                        'date' => $daysxx[$i],
                    ],
                    [
                        'user_id' => $request->get('user_id'),
                        'date' => $daysxx[$i],
                        'start_work' => null,
                        'end_work' => null,
                        'desc' => 'CH',
                        'hadir' => '1',
                    ]
                );

            }

            Alert::success('Berhasil', 'Data Cuti Tersimpan!!!');
            return redirect()->route('cuti');
        } else if ($act_tahunan > 12 && $date_req == $year_req && $kind == 'Yearly') {
            if ($cek_dept != "Factory" && $cek_dept != 'FSD' && $cek_dept != 'Workshop' && $cek_dept != 'I/A' && $cek_dept != 'I/B' && $cek_dept != 'I/C' && $cek_dept != 'II/D' && $cek_dept != 'II/E' && $cek_dept != 'II/F') {
                if ($request->from == $request->to) {
                    $dateNow = $request->from;
                    $dateOnly = Carbon::parse($dateNow)->format('Y-m-d');
                    $swW = '' . $dateOnly . ' 08:00:00';
                    $ewW = '' . $dateOnly . ' 17:00:00';

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    switch ($kind) {
                        case 'Large':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CB',
                                ]);
                            break;
                        case 'Yearly':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CT',
                                ]);
                            break;
                        case 'Birth':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CH',
                                ]);
                            break;
                        case 'Sick':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CS',
                                ]);
                            break;
                        case 'Other':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CLL',
                                ]);
                            break;
                    }

                } else {

                    $period = CarbonPeriod::between($request->from, $request->to)->filter('isWeekday');

                    foreach ($period as $date) {
                        $dayx = $date->format('Y-m-d');
                        $daysx[] = $dayx;
                    }

                    $t_day = count($daysx);

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    foreach ($daysx as $i => $value) {
                        $swW = '' . $daysx[$i] . ' 08:00:00';
                        $ewW = '' . $daysx[$i] . ' 17:00:00';

                        switch ($kind) {
                            case 'Large':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $daysx[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CB',
                                    ]);
                                break;
                            case 'Yearly':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $daysx[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CT',
                                    ]);
                                break;
                            case 'Birth':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $daysx[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CH',
                                    ]);
                                break;
                            case 'Sick':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $daysx[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CS',
                                    ]);
                                break;
                            case 'Other':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $daysx[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CLL',
                                    ]);
                                break;
                        }

                    }
                }
            } else {
                if ($request->from == $request->to) {
                    $dateNow = $request->from;
                    $dateOnly = Carbon::parse($dateNow)->format('Y-m-d');
                    $swW = '' . $dateOnly . ' 08:00:00';
                    $ewW = '' . $dateOnly . ' 17:00:00';

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    switch ($kind) {
                        case 'Large':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CB',
                                ]);
                            break;
                        case 'Yearly':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CT',
                                ]);
                            break;
                        case 'Birth':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CH',
                                ]);
                            break;
                        case 'Sick':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CS',
                                ]);
                            break;
                        case 'Other':
                            TestingAbsen::updateOrCreate([
                                'user_id' => $request->get('user_id'),
                                'date' => $dateNow,
                            ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CLL',
                                ]);
                            break;
                    }
                } else {
                    $startDate = new DateTime($request->from);
                    $endDate = new DateTime($request->to);
                    $period = CarbonPeriod::between($request->from, $request->to);
                    $sundays = array();

                    while ($startDate <= $endDate) {
                        if ($startDate->format('w') == 0) {
                            $sundays[] = $startDate->format('Y-m-d');
                        }

                        $startDate->modify('+1 day');
                    }

                    $strSunday = implode(",", $sundays);

                    $days = [];
                    foreach ($period as $date) {
                        $day = $date->format('Y-m-d');
                        $days[] = $day;
                    }
                    $days = array_filter($days, function ($date) use ($strSunday) {
                        return strtotime($date) != strtotime($strSunday);
                    });

                    $cDay = count($days);

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $request->todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    foreach ($days as $i => $value) {
                        $swW = '' . $days[$i] . ' 08:00:00';
                        $ewW = '' . $days[$i] . ' 17:00:00';

                        switch ($kind) {
                            case 'Large':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $days[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CB',
                                    ]);
                                break;
                            case 'Yearly':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $days[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CT',
                                    ]);
                                break;
                            case 'Birth':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $days[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CH',
                                    ]);
                                break;
                            case 'Sick':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $days[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CS',
                                    ]);
                                break;
                            case 'Other':
                                TestingAbsen::updateOrCreate([
                                    'user_id' => $request->get('user_id'),
                                    'date' => $days[$i],
                                ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CLL',
                                    ]);
                                break;
                        }
                    }
                }

            }
            Alert::success('Berhasil', 'Data Cuti Tersimpan!!!');
            return redirect()->route('cuti');
        } else {
            if ($cek_dept != "Factory" && $cek_dept != 'FSD' && $cek_dept != 'Workshop' && $cek_dept != 'I/A' && $cek_dept != 'I/B' && $cek_dept != 'I/C' && $cek_dept != 'II/D' && $cek_dept != 'II/E' && $cek_dept != 'II/F') {
                if ($request->from == $request->to) {
                    $dateNow = $request->from;
                    $dateOnly = Carbon::parse($dateNow)->format('Y-m-d');
                    $swW = '' . $dateOnly . ' 08:00:00';
                    $ewW = '' . $dateOnly . ' 17:00:00';

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    switch ($kind) {
                        case 'Large':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CB',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Yearly':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CT',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Birth':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CH',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Sick':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CS',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Other':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CLL',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                    }

                } else {

                    $period = CarbonPeriod::between($request->from, $request->to)->filter('isWeekday');

                    foreach ($period as $date) {
                        $dayx = $date->format('Y-m-d');
                        $daysx[] = $dayx;
                    }

                    $t_day = count($daysx);

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    foreach ($daysx as $i => $value) {
                        $swW = '' . $daysx[$i] . ' 08:00:00';
                        $ewW = '' . $daysx[$i] . ' 17:00:00';

                        switch ($kind) {
                            case 'Large':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CB',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Yearly':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CT',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Birth':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CH',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Sick':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CS',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Other':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $daysx[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CLL',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                        }

                    }
                }
            } else {
                if ($request->from == $request->to) {
                    $dateNow = $request->from;
                    $dateOnly = Carbon::parse($dateNow)->format('Y-m-d');
                    $swW = '' . $dateOnly . ' 08:00:00';
                    $ewW = '' . $dateOnly . ' 17:00:00';

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    switch ($kind) {
                        case 'Large':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CB',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Yearly':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CT',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Birth':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CH',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Sick':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CS',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                        case 'Other':
                            TestingAbsen::updateOrCreate(
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                ],
                                [
                                    'user_id' => $request->get('user_id'),
                                    'date' => $dateNow,
                                    'start_work' => $swW,
                                    'end_work' => $ewW,
                                    'desc' => 'CLL',
                                    'hadir' => '1',
                                ]
                            );
                            break;
                    }
                } else {
                    $startDate = new DateTime($request->from);
                    $endDate = new DateTime($request->to);
                    $period = CarbonPeriod::between($request->from, $request->to);
                    $sundays = array();

                    while ($startDate <= $endDate) {
                        if ($startDate->format('w') == 0) {
                            $sundays[] = $startDate->format('Y-m-d');
                        }

                        $startDate->modify('+1 day');
                    }

                    $strSunday = implode(",", $sundays);

                    $days = [];
                    foreach ($period as $date) {
                        $day = $date->format('Y-m-d');
                        $days[] = $day;
                    }
                    $days = array_filter($days, function ($date) use ($strSunday) {
                        return strtotime($date) != strtotime($strSunday);
                    });

                    $cDay = count($days);

                    $store = Leave::create([
                        'user_id' => $user_id,
                        'user_sub' => $request->user_sub,
                        'date' => Carbon::now(),
                        'kind' => $request->kind,
                        'start_date' => $request->from,
                        'end_date' => $request->to,
                        'return_date' => $return_date,
                        'total' => $request->days,
                        'balance' => $todate_balance,
                        'purpose' => $request->purpose,
                    ]);

                    foreach ($days as $i => $value) {
                        $swW = '' . $days[$i] . ' 08:00:00';
                        $ewW = '' . $days[$i] . ' 17:00:00';

                        switch ($kind) {
                            case 'Large':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CB',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Yearly':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CT',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Birth':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CH',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Sick':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CS',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                            case 'Other':
                                TestingAbsen::updateOrCreate(
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                    ],
                                    [
                                        'user_id' => $request->get('user_id'),
                                        'date' => $days[$i],
                                        'start_work' => $swW,
                                        'end_work' => $ewW,
                                        'desc' => 'CLL',
                                        'hadir' => '1',
                                    ]
                                );
                                break;
                        }
                    }
                }

            }
            Alert::success('Berhasil', 'Data Cuti Tersimpan!!!');
            return redirect()->route('cuti');
        }

    }

    public function update(Request $request)
    {
        $user_id = $request->user_id;
        $days = $request->days;
        $year = Carbon::parse(Carbon::now())->format('Y');

        $kind = $request->kind;

        switch ($kind) {
            case 'Large':
                $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Large');
                $actual = $budget - $days;
                LeaveBudget::where('user_id', $user_id)->update([
                    'Large' => $actual,
                ]);
                break;

            case 'Yearly':
                $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Yearly');
                $actual = $budget - $days;
                LeaveBudget::where('user_id', $user_id)->update([
                    'Yearly' => $actual,
                ]);
                break;

            case 'Birth':
                $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Birth');
                $actual = $budget - $days;
                LeaveBudget::where('user_id', $user_id)->update([
                    'Birth' => $actual,
                ]);
                break;

            case 'Sick':
                $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Sick');
                $actual = $budget - $days;
                LeaveBudget::where('user_id', $user_id)->update([
                    'Sick' => $actual,
                ]);
                break;

            case 'Other':
                $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Other');
                $actual = $budget - $days;
                LeaveBudget::where('user_id', $user_id)->update([
                    'Other' => $actual,
                ]);
                break;
        }

        $store = Leave::where('id', $request->id)->update(
            [
                'user_id' => $user_id,
                'user_sub' => $request->user_sub,
                'date' => Carbon::now(),
                'kind' => $request->kind,
                'start_date' => $request->from,
                'end_date' => $request->to,
                'purpose' => $request->purpose,
            ]
        );

        Alert::success('Berhasil', 'Data Cuti Diubah!!!');

        return redirect()->route('cuti');
    }

    public function delete(Request $request, $id)
    {
        $year = Carbon::parse(Carbon::now())->format('Y');
        $user_id = Leave::where('id', $id)->whereYear('date', $year)->value('user_id');

        $from = Leave::where('id', $id)->whereYear('date', $year)->value('start_date');
        $to = Leave::where('id', $id)->whereYear('date', $year)->value('end_date');

        $days = Leave::where('id', $id)->whereYear('date', $year)->value('total');

        $kind = Leave::where('id', $id)->whereYear('date', $year)->value('kind');

        switch ($kind) {
            case 'Yearly':
                $c_kind = 'CT';
                break;
            case 'Large':
                $c_kind = 'CL';
                break;
            case 'Sick':
                $c_kind = 'CS';
                break;
            case 'Birth':
                $c_kind = 'CH';
                break;
            case 'Other':
                $c_kind = 'CLL';
                break;
        }

        // switch ($kind) {
        //     case 'Large':
        //         $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Large');
        //         $actual = $budget + $days;
        //         LeaveBudget::where('user_id', $user_id)->update([
        //             'Large' => $actual,
        //         ]);
        //         break;

        //     case 'Yearly':
        //         $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Yearly');
        //         $actual = $budget + $days;
        //         LeaveBudget::where('user_id', $user_id)->update([
        //             'Yearly' => $actual,
        //         ]);
        //         break;

        //     case 'Birth':
        //         $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Birth');
        //         $actual = $budget + $days;
        //         LeaveBudget::where('user_id', $user_id)->update([
        //             'Birth' => $actual,
        //         ]);
        //         break;

        //     case 'Sick':
        //         $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Sick');
        //         $actual = $budget + $days;
        //         LeaveBudget::where('user_id', $user_id)->update([
        //             'Sick' => $actual,
        //         ]);
        //         break;

        //     case 'Other':
        //         $budget = LeaveBudget::where('user_id', $user_id)->whereYear('date', $year)->value('Other');
        //         $actual = $budget + $days;
        //         LeaveBudget::where('user_id', $user_id)->update([
        //             'Other' => $actual,
        //         ]);
        //         break;

        // }

        Leave::where('id', $id)->delete();
        TestingAbsen::where('user_id', $user_id)->where('desc', $c_kind)->whereBetween('date', [$from, $to])->delete();
        Alert::success('Berhasil', 'Data Cuti Dihapus');

        return redirect()->route('cuti');
    }

    public function budgetCuti(Request $request)
    {
        // $data = LeaveBudget::with(['user' => function ($query) {
        //   $query->where('status', '=', 'Regular');
        // }])->get();
        $data = User::where('status', 'Regular')->with([
            'leave_budget' => function ($query) {
                $query->whereYear('date', '=', Carbon::parse(Carbon::now())->format('Y'));
            }
        ])->paginate(10);

        return view('admin.pages.budget-cuti', ['data' => $data]);
    }

    public function budgetCutiSearch(Request $request)
    {
        // $data = LeaveBudget::with(['user' => function ($query) {
        //   $query->where('status', '=', 'Regular');
        // }])->get();
        $name = $request->name;
        $data = User::where('name', 'LIKE', '%' . $name . '%')->where('status', 'Regular')->with([
            'leave_budget' => function ($query) {
                $query->whereYear('date', '=', Carbon::parse(Carbon::now())->format('Y'));
            }
        ])->paginate(10);

        return view('admin.pages.budget-cuti', ['data' => $data]);
    }

    public function inputBudgetCuti(Request $request)
    {
        $user = User::whereDoesntHave('leave_budget', function (Builder $query) {
            $query->whereYear('date', '=', Carbon::parse(Carbon::now())->format('Y'));
        })->paginate(10);

        return view('admin.pages.budget-cuti-new', ['user' => $user]);
    }

    public function storeBudgetCuti(Request $request)
    {
        foreach ($request->user_id as $key => $value) {
            $user_id = $request->user_id[$key];
            $date = $request->date[$key];
            $large = $request->large[$key];
            $yearly = $request->yearly[$key];
            $birth = $request->birth[$key];
            $sick = $request->sick[$key];
            $other = $request->other[$key];

            LeaveBudget::updateOrCreate(
                [
                    'user_id' => $user_id,
                ],
                [
                    'user_id' => $user_id,
                    'date' => $date,
                    'large' => $large,
                    'yearly' => $yearly,
                    'birth' => $birth,
                    'sick' => $sick,
                    'other' => $other,
                ]
            );
        }
        return Redirect::back();
    }

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('files', $nama_file);

        // import data
        Excel::import(new LeaveBudgetImport, public_path('/files/' . $nama_file));

        // notifikasi dengan session
        Alert::success('Berhasil', 'Budget Cuti Terimport');

        // alihkan halaman kembali
        return Redirect::back();
    }

    public function holidayCheck(Request $request)
    {
        // $from = $request->from;
        // $to = $request->to;
        // $nik =

        // $check = Holiday::whereBetween('date', [$from, $to])->count();

        // $years = Carbon::now();
        // $year = Carbon::parse($years)->format('Y');
        // $emp = User::where('nik', $nik)->get();
        // $empS = User::where('nik', $nik)->value('dept');
        // $emp_sub = User::get();
        // $emp_leave = User::where('nik',$nik)->has('absen_reg')->get();

        // $b_leave = LeaveBudget::where('user_id', $nik)->whereYear('date', $year)->get();
        // // dd($b_leave);
        $from = $request->from;
        $to = $request->to;

        $check = Holiday::whereBetween('date', [$from, $to])->count();

        return response()->json(['success' => $check]);
    }

}

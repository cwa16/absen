<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShiftArchive;
use App\Models\TestingAbsen;
use App\Models\TestingKitaServer;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class ChangeAbsenController extends Controller
{
    public function update_shift_new(Request $request)
    {
        // $date = Carbon::now()->format('Y-m-d');
        // $time = Carbon::now()->format('H:i');
        // $timeMunteSub = Carbon::now()->subMinutes(5)->format('H:i');
        // $attLogData = TestingKitaServer::where('inoutmode', 1)
        //     ->whereDate('scan_date', $date)
        //     ->whereTime('scan_date', '<=', $time)
        //     ->whereTime('scan_date', '>=', $timeMunteSub)
        //     ->select('id', 'nik', 'scan_date', 'sn')
        //     ->get();
        // dd($date, $time, $timeMunteSub, $attLogData);

        $firstDate = '2024-04-04';
        // $lastDate = '2024-04-23';
        $nik = '222-012';

        // $attLogData = TestingKitaServer::where('sn', $sn)
        //     ->whereDate('scan_date', '>=', $firstDate)
        //     ->whereDate('scan_date', '<=', $lastDate)
        //     ->select('id', 'nik', 'scan_date', 'sn')
        //     ->get();

        $attLogData = TestingKitaServer::where('inoutmode', 1)
            ->whereDate('scan_date', $firstDate)
            ->where('nik', $nik)
            ->select('id', 'nik', 'scan_date', 'sn')
            ->get();

        foreach ($attLogData as $data) {
            $absentCode = $data->nik;
            $nikMatch = User::where('absent_code', $absentCode)->value('nik');
            if (!$nikMatch) {
                $nik = $data->nik;
                if (!Str::contains($nik, '-')) {
                    $length = strlen($nik);
                    $nik = substr_replace($nik, '-', $length - 3, 0);
                }
            } else {
                $absentCode = $data->nik;
                $nik = User::where('absent_code', $absentCode)->value('nik');
            }

            $todayDay = Carbon::parse($data->scan_date)->format('l');

            $existingData = TestingAbsen::where('user_id', $nik)
                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                ->first();

            $dateSub = Carbon::parse($data->scan_date)->subDay()->format('Y-m-d');

            $existingDataYes = TestingAbsen::where('user_id', $nik)
                ->whereDate('date', '=', $dateSub)
                ->first();

            $scanDateData = Carbon::parse($data->scan_date)->format('H:i');

            $getDesc = TestingAbsen::where('user_id', $nik)
                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                ->value('desc');

            $getDescYes = TestingAbsen::where('user_id', $nik)
                ->whereDate('date', '=', $dateSub)
                ->value('desc');

            $getHadir = TestingAbsen::where('user_id', $nik)
                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                ->value('hadir');

            $getHadirYes = TestingAbsen::where('user_id', $nik)
                ->whereDate('date', '=', $dateSub)
                ->value('hadir');

            $getShift = ShiftArchive::where('nik', $nik)
                ->whereDate('start_date', '<=', date('Y-m-d', strtotime($data->scan_date)))
                ->whereDate('end_date', '>=', date('Y-m-d', strtotime($data->scan_date)))
                ->value('shift');

            $workLoc = User::where('nik', $nik)->value('loc_kerja');
            $workLocDetail = User::where('nik', $nik)->value('loc');
            $userJabatan = User::where('nik', $nik)->value('jabatan');
            $startWorkUser = User::where('nik', $nik)->value('start_work_user');

            $scanDateTime = Carbon::parse($existingData->start_work)->format('H:i');
            $startWorkUserTime = Carbon::parse($startWorkUser)->format('H:i');
            $startWorkUserHour = Carbon::parse($startWorkUser)->format('H');
            $startWorkUserMinute = Carbon::parse($startWorkUser)->format('i');

            $timeFriday = Carbon::create(null, null, null, 12, 05)->format('H:i');
            $timeShift2 = Carbon::create(null, null, null, 15, 05)->format('H:i');
            $timeShift3 = Carbon::create(null, null, null, 23, 05)->format('H:i');

            $absentCode = User::where('nik', $nik)->value('absent_code');

            $getHour = Carbon::parse($data->scan_date)->hour;

            if ($workLoc == 'Head Office') {
                if ($startWorkUserHour == '08') {
                    if ($todayDay == 'Saturday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => 0,
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }

                    } elseif ($todayDay == 'Sunday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('desc', 'MX')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '1',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                } else {
                    if ($todayDay == 'Saturday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '1',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'TA') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'TA')
                                ->where('hadir', 1)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($todayDay == 'Sunday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('desc', 'MX')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($todayDay == 'Friday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        if ($startWorkUserMinute == '35') {
                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:35:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:35:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:35:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:35:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();
                        } else {
                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();
                        }

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'TA') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'TA')
                                ->where('hadir', 1)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minute,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        if ($startWorkUserMinute == '35') {
                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:35:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:35:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:35:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:35:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();
                        } else {
                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();
                        }


                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minute,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                }
            } elseif ($workLoc == 'Workshop') {
                if ($startWorkUserHour == '08') {
                    if ($todayDay == 'Saturday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($todayDay == 'Sunday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('desc', 'MX')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minute,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                } else {
                    if ($todayDay == 'Saturday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($todayDay == 'Sunday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('desc', 'MX')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($todayDay == 'Friday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 6 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 6 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                }
            } elseif ($workLoc == 'Factory') {
                if ($todayDay == 'Saturday') {
                    if ($userJabatan == 'Assistant Manager' || $userJabatan == 'Clerk' || $userJabatan == 'Opas') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($userJabatan == 'Worker Proses') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 14) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 14) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"10:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "10:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"10:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"10:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($userJabatan == 'Worker WWTP') {
                        if ($getShift == '1') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '2') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $timeShift2) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 19) {
                                            if ($scanDateData > $timeShift2) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 19) {
                                            if ($scanDateData > $timeShift2) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"15:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "15:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"15:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"15:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '3') {
                            if ($data->scan_date) {
                                if ($existingDataYes->start_work && $getHour >= 7 && $getHour <= 8) {
                                    if ($getDescYes == 'TA') {
                                        if ($scanDateTime > $timeShift3) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', $dateSub)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', $dateSub)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDescYes == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDescYes == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDescYes == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDescYes == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour <= 23 && $getHour >= 22) {
                                            if ($scanDateData > $timeShift3) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour <= 23 && $getHour >= 22) {
                                            if ($scanDateData > $timeShift3) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', $dateSub)
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('HOUR(TIMEDIFF(end_work, start_work)) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"23:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "23:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"23:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"23:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDescYes == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'L') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDescYes == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } else {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                } elseif ($todayDay == 'Sunday') {
                    if ($userJabatan == 'Worker WWTP') {
                        if ($getShift == '1') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } else {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => 0,
                                            'desc' => 'MX',
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'MX',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'MX' && $getHadir == 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '2') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } else {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => 0,
                                            'desc' => 'MX',
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'MX',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'MX' && $getHadir == 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '3') {
                            if ($data->scan_date) {
                                if ($existingDataYes->start_work && $getHour >= 7 && $getHour <= 8) {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', $dateSub)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } else {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => 0,
                                            'desc' => 'MX',
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'MX',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', $dateSub)
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDescYes == 'MX' && $getHadirYes == 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDescYes != 'MX' && $getHadirYes != 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } else {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } else {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => 0,
                                            'desc' => 'MX',
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'MX',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'MX' && $getHadir == 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('desc', 'MX')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                } elseif ($todayDay == 'Friday') {
                    if ($userJabatan == 'Assistant Manager' || $userJabatan == 'Clerk' || $userJabatan == 'Opas') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($userJabatan == 'Worker Proses') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $timeFriday) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 14) {
                                        if ($scanDateData > $timeFriday) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 14) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 6 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 6 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"12:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "12:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"12:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"12:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 2),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 2),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 2),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 2),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 2),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 2),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'TA') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'TA')
                                ->where('hadir', 1)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($userJabatan == 'Worker WWTP') {
                        if ($getShift == '1') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '2') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $timeShift2) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 19) {
                                            if ($scanDateData > $timeShift2) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 19) {
                                            if ($scanDateData > $timeShift2) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"15:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "15:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"15:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"15:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '3') {
                            if ($data->scan_date) {
                                if ($existingDataYes->start_work && $getHour >= 7 && $getHour <= 8) {
                                    if ($getDescYes == 'TA') {
                                        if ($scanDateTime > $timeShift3) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', $dateSub)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', $dateSub)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDescYes == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDescYes == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDescYes == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDescYes == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour <= 23 && $getHour >= 22) {
                                            if ($scanDateData > $timeShift3) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour <= 23 && $getHour >= 22) {
                                            if ($scanDateData > $timeShift3) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', $dateSub)
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('HOUR(TIMEDIFF(end_work, start_work)) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"23:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "23:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"23:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"23:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDescYes == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'L') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDescYes == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } else {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 6 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 6 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                } else {
                    if ($userJabatan == 'Worker Proses') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 14) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 14) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        // ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"10:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "10:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"10:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"10:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($userJabatan == 'Worker WWTP') {
                        if ($getShift == '1') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            // ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '2') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $timeShift2) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 19) {
                                            if ($scanDateData > $timeShift2) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 19) {
                                            if ($scanDateData > $timeShift2) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            // ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"15:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "15:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"15:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"15:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($getShift == '3') {
                            if ($data->scan_date) {
                                if ($existingDataYes->start_work && $getHour >= 7 && $getHour <= 8) {
                                    if ($getDescYes == 'TA') {
                                        if ($scanDateTime > $timeShift3) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', $dateSub)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', $dateSub)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDescYes == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDescYes == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDescYes == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDescYes == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', $dateSub)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour <= 23 && $getHour >= 22) {
                                            if ($scanDateData > $timeShift3) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour <= 23 && $getHour >= 22) {
                                            if ($scanDateData > $timeShift3) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            // ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', $dateSub)
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('HOUR(TIMEDIFF(end_work, start_work)) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"23:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "23:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"23:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"23:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDescYes == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDescYes == 'L') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } elseif ($getDescYes == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDescYes == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDescYes == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', $dateSub)
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } else {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'MX',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            // ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'MX',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        // ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                }
            } elseif ($workLoc == 'Sub Divisi A' || $workLoc == 'Sub Divisi B' || $workLoc == 'Sub Divisi C' || $workLoc == 'Sub Divisi D' || $workLoc == 'Sub Divisi E' || $workLoc == 'Sub Divisi F') {
                if ($workLocDetail == 'Kantor Sub Divisi A' || $workLocDetail == 'Kantor Sub Divisi B' || $workLocDetail == 'Kantor Sub Divisi C' || $workLocDetail == 'Kantor Sub Divisi D' || $workLocDetail == 'Kantor Sub Divisi E' || $workLocDetail == 'Kantor Sub Divisi F') {
                    if ($userJabatan == 'Head Mandor' || $userJabatan == 'Inspektur' || $userJabatan == 'Instruktur' || $userJabatan == 'Mandor Tapping') {
                        if ($todayDay == 'Sunday') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } else {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => 0,
                                            'desc' => 'MX',
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'MX',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"06:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "06:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"06:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"06:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'MX' && $getHadir == 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($todayDay == 'Friday') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"06:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "06:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"06:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"06:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => $totalHourNonShift->total_hours,
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => $totalHourNonShift->overtime_hour,
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } else {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"06:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "06:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"06:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"06:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        }
                    } else {
                        if ($todayDay == 'Sunday') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } else {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereNull('end_work')
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => 0,
                                            'desc' => 'MX',
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'MX',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'MX' && $getHadir == 0) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } elseif ($todayDay == 'Friday') {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        } else {
                            if ($data->scan_date) {
                                if ($existingData->start_work) {
                                    if ($getDesc == 'TA') {
                                        if ($scanDateTime > $startWorkUserTime) {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->where('hadir', '1')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                ]);
                                        } else {
                                            TestingAbsen::whereNotNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('start_work', '!=', $data->scan_date)
                                                ->where('desc', 'TA')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'H',
                                                ]);
                                        }
                                    } elseif ($getDesc == 'L') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'L')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'IP',
                                            ]);
                                    } elseif ($getDesc == 'D') {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->whereNull('end_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'D')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'D',
                                            ]);
                                    }
                                } else {
                                    if ($getDesc == null) {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->whereNull('desc')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'M') {
                                        if ($getHour < 12) {
                                            if ($scanDateData > $startWorkUserTime) {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'L',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            } else {
                                                TestingAbsen::whereNull('start_work')
                                                    ->where('user_id', $nik)
                                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                    ->where('desc', 'M')
                                                    ->where('hadir', '0')
                                                    ->update([
                                                        'start_work' => $data->scan_date,
                                                        'start_work_info' => $data->sn,
                                                        'desc' => 'TA',
                                                        'hadir' => '1',
                                                        'absent_code' => $absentCode
                                                    ]);
                                            }
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'end_work' => $data->scan_date,
                                                    'end_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } elseif ($getDesc == 'MX') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'MX')
                                            ->where('hadir', '0')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'hadir' => '0',
                                                'absent_code' => $absentCode
                                            ]);
                                    } elseif ($getDesc == 'IP') {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'IP')
                                            ->where('hadir', '1')
                                            ->update([
                                                'start_work' => $data->scan_date,
                                                'start_work_info' => $data->sn,
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                }
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNull('desc')
                                    ->update([
                                        'desc' => 'M',
                                        'hadir' => '0',
                                    ]);
                            }

                            $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                    DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                    DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "07:05:00")))) ELSE 0 END) as late_minutes'),
                                    DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"07:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"07:05:00")))) ELSE 0 END) as late_hours'),
                                ])
                                ->first();

                            if ($getDesc == 'H') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'H')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'L') {
                                if ($existingData->end_work == null) {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => null,
                                            'total_minute' => null,
                                            'overtime_hour' => null,
                                            'overtime_minute' => null,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                } else {
                                    TestingAbsen::where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->whereNotNull('start_work')
                                        ->whereNotNull('end_work')
                                        ->where('desc', 'L')
                                        ->update([
                                            'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                            'total_minute' => $totalHourNonShift->total_minutes,
                                            'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                            'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                            'late_hour' => $totalHourNonShift->late_hours,
                                            'late_minute' => $totalHourNonShift->late_minutes,
                                        ]);
                                }
                            } elseif ($getDesc == 'D') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'D')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'IP') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'IP')
                                    ->update([
                                        'total_hour' => $totalHourNonShift->total_hours,
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => $totalHourNonShift->overtime_hour,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } elseif ($getDesc == 'MX') {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'MX')
                                    ->where('hadir', 0)
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => $totalHourNonShift->total_hours,
                                        'overtime_minute' => $totalHourNonShift->total_minutes,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => null,
                                        'late_minute' => null,
                                    ]);
                            }
                        }
                    }
                } else {
                    if ($todayDay == 'Sunday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                TestingAbsen::whereNotNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('start_work', '!=', $data->scan_date)
                                    ->where('desc', 'MX')
                                    ->where('hadir', '0')
                                    ->update([
                                        'end_work' => $data->scan_date,
                                        'end_work_info' => $data->sn,
                                    ]);
                            } else {
                                TestingAbsen::whereNull('start_work')
                                    ->where('user_id', $nik)
                                    ->whereNull('end_work')
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->where('desc', 'MX')
                                    ->update([
                                        'start_work' => $data->scan_date,
                                        'start_work_info' => $data->sn,
                                        'hadir' => 0,
                                        'desc' => 'MX',
                                        'absent_code' => $absentCode
                                    ]);
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'MX',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'MX' && $getHadir == 0) {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } elseif ($todayDay == 'Friday') {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 11) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 11) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN HOUR(TIMEDIFF(end_work, start_work)) - 5 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 5 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"05:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "05:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"05:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"05:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    } else {
                        if ($data->scan_date) {
                            if ($existingData->start_work) {
                                if ($getDesc == 'TA') {
                                    if ($scanDateTime > $startWorkUserTime) {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->where('hadir', '1')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'L',
                                            ]);
                                    } else {
                                        TestingAbsen::whereNotNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('start_work', '!=', $data->scan_date)
                                            ->where('desc', 'TA')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'H',
                                            ]);
                                    }
                                } elseif ($getDesc == 'L') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'L')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'IP',
                                        ]);
                                } elseif ($getDesc == 'D') {
                                    TestingAbsen::whereNotNull('start_work')
                                        ->whereNull('end_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('start_work', '!=', $data->scan_date)
                                        ->where('desc', 'D')
                                        ->where('hadir', '1')
                                        ->update([
                                            'end_work' => $data->scan_date,
                                            'end_work_info' => $data->sn,
                                            'desc' => 'D',
                                        ]);
                                }
                            } else {
                                if ($getDesc == null) {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->whereNull('desc')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->whereNull('desc')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'M') {
                                    if ($getHour < 12) {
                                        if ($scanDateData > $startWorkUserTime) {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'L',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        } else {
                                            TestingAbsen::whereNull('start_work')
                                                ->where('user_id', $nik)
                                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                                ->where('desc', 'M')
                                                ->where('hadir', '0')
                                                ->update([
                                                    'start_work' => $data->scan_date,
                                                    'start_work_info' => $data->sn,
                                                    'desc' => 'TA',
                                                    'hadir' => '1',
                                                    'absent_code' => $absentCode
                                                ]);
                                        }
                                    } else {
                                        TestingAbsen::whereNull('start_work')
                                            ->where('user_id', $nik)
                                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                            ->where('desc', 'M')
                                            ->where('hadir', '0')
                                            ->update([
                                                'end_work' => $data->scan_date,
                                                'end_work_info' => $data->sn,
                                                'desc' => 'TA',
                                                'hadir' => '1',
                                                'absent_code' => $absentCode
                                            ]);
                                    }
                                } elseif ($getDesc == 'MX') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'MX')
                                        ->where('hadir', '0')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'hadir' => '0',
                                            'absent_code' => $absentCode
                                        ]);
                                } elseif ($getDesc == 'IP') {
                                    TestingAbsen::whereNull('start_work')
                                        ->where('user_id', $nik)
                                        ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                        ->where('desc', 'IP')
                                        ->where('hadir', '1')
                                        ->update([
                                            'start_work' => $data->scan_date,
                                            'start_work_info' => $data->sn,
                                            'absent_code' => $absentCode
                                        ]);
                                }
                            }
                        } else {
                            TestingAbsen::whereNull('start_work')
                                ->where('user_id', $nik)
                                ->whereNull('end_work')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNull('desc')
                                ->update([
                                    'desc' => 'M',
                                    'hadir' => '0',
                                ]);
                        }

                        $totalHourNonShift = TestingAbsen::where('user_id', $nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN HOUR(TIMEDIFF(end_work, start_work)) - 7 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 7 THEN MINUTE(TIMEDIFF(end_work, start_work)) ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"05:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "05:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"05:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"05:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                        if ($getDesc == 'H') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'H')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'L') {
                            if ($existingData->end_work == null) {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => null,
                                        'total_minute' => null,
                                        'overtime_hour' => null,
                                        'overtime_minute' => null,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->whereNotNull('end_work')
                                    ->where('desc', 'L')
                                    ->update([
                                        'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                        'total_minute' => $totalHourNonShift->total_minutes,
                                        'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                        'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                        'late_hour' => $totalHourNonShift->late_hours,
                                        'late_minute' => $totalHourNonShift->late_minutes,
                                    ]);
                            }
                        } elseif ($getDesc == 'D') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'D')
                                ->update([
                                    'total_hour' => max(0, $totalHourNonShift->total_hours - 1),
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => max(0, $totalHourNonShift->overtime_hour - 1),
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'IP') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'IP')
                                ->update([
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } elseif ($getDesc == 'MX') {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->where('desc', 'MX')
                                ->where('hadir', 0)
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => $totalHourNonShift->total_hours,
                                    'overtime_minute' => $totalHourNonShift->total_minutes,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        } else {
                            TestingAbsen::where('user_id', $nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($data->scan_date)))
                                ->whereNotNull('start_work')
                                ->whereNotNull('end_work')
                                ->update([
                                    'total_hour' => null,
                                    'total_minute' => null,
                                    'overtime_hour' => null,
                                    'overtime_minute' => null,
                                    'late_hour' => null,
                                    'late_minute' => null,
                                ]);
                        }
                    }
                }
            } else {
                echo 'Kebun';
            }
        }

        TestingAbsen::whereNull('start_work')
            ->whereNull('end_work')
            ->whereNull('desc')
            ->whereDate('date', $firstDate)
            ->update([
                'desc' => 'M',
                'hadir' => '0',
            ]);
    }
}

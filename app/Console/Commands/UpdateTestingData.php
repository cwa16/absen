<?php

namespace App\Console\Commands;

use App\Models\MasterShift;
use App\Models\ShiftArchive;
use App\Models\TestingAbsen;
use App\Models\TestingKitaServer;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class UpdateTestingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:testingdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lastDate = Carbon::now()->format('Y-m-d');
        $firstDate = Carbon::parse($lastDate)->subDays(3)->format('Y-m-d');
        $attLogMode1 = TestingKitaServer::where('inoutmode', 1)
            ->whereDate('scan_date', '>=', $firstDate)
            ->whereDate('scan_date', '<=', $lastDate)
            ->select('id', 'nik', 'scan_date', 'sn')
            ->get();

            foreach ($attLogMode1 as $log) {
                if($log->sn == "FIO66208023190896") {
                    $length = strlen($log->nik);
                    $log->nik = substr_replace($log->nik, '-', $length - 3, 0);
                }

                $existingEntry = TestingAbsen::where('user_id', $log->nik)
                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                    ->first();

                $shiftArchiveEntry = ShiftArchive::where('nik', $log->nik)
                    ->whereDate('start_date', '<=', date('Y-m-d', strtotime($log->scan_date)))
                    ->whereDate('end_date', '>=', date('Y-m-d', strtotime($log->scan_date)))
                    ->first();

                if($shiftArchiveEntry) {
                    if (!$existingEntry) {
                        $absentDate = Carbon::parse($log->scan_date)->subDay()->format('Y-m-d');
                        $dataEntry = TestingAbsen::where('user_id', $log->nik)->whereDate('date', '=', $absentDate)->where('shift', '3')->first();
                        $absenIn = TestingAbsen::where('user_id', $log->nik)->whereDate('date', '=', $absentDate)->value('start_work');
                        $absenInTime = Carbon::parse($absenIn)->format('H:i:s');
                        $shift3Time = MasterShift::where('id', 3)->select('start_work as jampiro')->first();
                        $shift3TimeA = $shift3Time->jampiro;

                        if($dataEntry) {
                            if($absenInTime > $shift3TimeA) {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', $absentDate)
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->update([
                                        'end_work' => $log->scan_date,
                                        'start_work_info' => $log->sn,
                                        'end_work_info' => $log->sn,
                                        'desc' => 'L',
                                ]);
                            } else {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', $absentDate)
                                    ->whereNotNull('start_work')
                                    ->whereNull('end_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->update([
                                        'end_work' => $log->scan_date,
                                        'start_work_info' => $log->sn,
                                        'end_work_info' => $log->sn,
                                        'desc' => 'H',
                                ]);
                            }
                        } else {
                            TestingAbsen::create([
                                'user_id' => $log->nik,
                                'date' => $log->scan_date,
                                'start_work' => $log->scan_date,
                                'start_work_info' => $log->sn,
                                'desc' => 'TA',
                                'hadir' => '1',
                                'shift' => $shiftArchiveEntry->shift
                            ]);
                        }
                    } else {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->update([
                                'end_work' => $log->scan_date,
                                'start_work_info' => $log->sn,
                                'end_work_info' => $log->sn,
                            ]);
                    }

                        // Jam shift (Actual)
                        $startWorkUser1 = User::join('shift_archives', 'users.nik', '=', 'shift_archives.nik')
                                ->join('master_shifts', 'shift_archives.shift', '=', 'master_shifts.id')
                                ->where('users.nik', $log->nik)
                                ->select('users.*', 'shift_archives.*', 'master_shifts.*')
                                ->whereDate('start_date', '<=', date('Y-m-d', strtotime($log->scan_date)))
                                ->whereDate('end_date', '>=', date('Y-m-d', strtotime($log->scan_date)))
                                ->first();

                        $totalHourShift = TestingAbsen::where('user_id', $log->nik)
                                ->join('shift_archives', 'shift_archives.nik', '=', 'test_absen_regs.user_id')
                                ->join('master_shifts', 'master_shifts.id', '=', 'shift_archives.shift')
                                ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                ->select([
                                    'test_absen_regs.date as date',
                                    DB::raw('HOUR(TIMEDIFF(test_absen_regs.end_work, test_absen_regs.start_work)) as total_hours'),
                                    DB::raw('MINUTE(TIMEDIFF(test_absen_regs.end_work, test_absen_regs.start_work)) as total_minutes'),
                                    DB::raw('CASE WHEN HOUR(TIMEDIFF(test_absen_regs.end_work, test_absen_regs.start_work)) > 7 THEN HOUR(TIMEDIFF(test_absen_regs.end_work, test_absen_regs.start_work)) - 7 ELSE 0 END as overtime_hour'),
                                    DB::raw('CASE WHEN MINUTE(TIMEDIFF(test_absen_regs.end_work, test_absen_regs.start_work)) > 7 THEN HOUR(TIMEDIFF(test_absen_regs.end_work, test_absen_regs.start_work)) - 7 ELSE 0 END as overtime_minutes'),
                                    DB::raw('CASE WHEN TIME(test_absen_regs.start_work) > TIME(CONCAT(date, " " ,master_shifts.start_work)) THEN FLOOR(MINUTE(TIMEDIFF(test_absen_regs.start_work, CONCAT(date, " ", master_shifts.start_work)))) ELSE 0 END as late_minutes'),
                                    DB::raw('CASE WHEN TIME(test_absen_regs.start_work) > TIME(CONCAT(date, " " ,master_shifts.start_work)) THEN FLOOR(HOUR(TIMEDIFF(test_absen_regs.start_work, CONCAT(date, " " ,master_shifts.start_work)))) ELSE 0 END as late_hours'),
                                ])
                                ->first();

                        $descUser = TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->value('desc');

                        // Jam
                        $startWorkUser = $startWorkUser1->start_work;
                        // Tanggal Mulai
                        $startDate = $startWorkUser1->start_date;
                        // Tanggal Berkahir
                        $endDate = $startWorkUser1->end_date;

                        // Jam Absen (Origin)
                        $scanDateUser = TestingAbsen::where('user_id', $log->nik)
                                ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                ->value('start_work');

                        // Jam
                        $scanDateUserTime = Carbon::parse($scanDateUser)->format('H:i:s');
                        // Tanggal
                        $scanDateUserDate = Carbon::parse($scanDateUser)->format('Y-m-d');

                        if($startDate <= $scanDateUserDate && $endDate >= $scanDateUserDate) {
                            if ($scanDateUserTime > $startWorkUser) {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->update([
                                            'desc' => 'L',
                                            'total_hour' => $totalHourShift->total_hours,
                                            'overtime_hour' => $totalHourShift->overtime_hour,
                                            'late_hour' => $totalHourShift->late_hours,
                                            'total_minute' => $totalHourShift->total_minutes,
                                            'overtime_minute' => $totalHourShift->overtime_minutes,
                                            'late_minute' => $totalHourShift->late_minutes,
                                    ]);
                            } elseif ($scanDateUserTime <= $startWorkUser && $descUser == 'D') {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->where('desc', 'D')
                                    ->update([
                                        'desc' => 'D',
                                        'total_hour' => $totalHourShift->total_hours,
                                        'overtime_hour' => $totalHourShift->overtime_hour,
                                        'late_hour' => $totalHourShift->late_hours,
                                        'total_minute' => $totalHourShift->total_minutes,
                                        'overtime_minute' => $totalHourShift->overtime_minutes,
                                        'late_minute' => $totalHourShift->late_minutes,
                                    ]);
                            } elseif ($scanDateUserTime <= $startWorkUser && $descUser == 'IP') {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->where('desc', 'IP')
                                    ->update([
                                        'desc' => 'IP',
                                        'total_hour' => $totalHourShift->total_hours,
                                        'overtime_hour' => $totalHourShift->overtime_hour,
                                        'late_hour' => $totalHourShift->late_hours,
                                        'total_minute' => $totalHourShift->total_minutes,
                                        'overtime_minute' => $totalHourShift->overtime_minutes,
                                        'late_minute' => $totalHourShift->late_minutes,
                                    ]);
                            } else {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->update([
                                            'desc' => 'H',
                                            'total_hour' => $totalHourShift->total_hours,
                                            'overtime_hour' => $totalHourShift->overtime_hour,
                                            'late_hour' => $totalHourShift->late_hours,
                                            'total_minute' => $totalHourShift->total_minutes,
                                            'overtime_minute' => $totalHourShift->overtime_minutes,
                                            'late_minute' => $totalHourShift->late_minutes,
                                    ]);
                            }
                        } else {
                                TestingAbsen::where('user_id', $log->nik)
                                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                                    ->whereNotNull('start_work')
                                    ->where('start_work', '!=', $log->scan_date)
                                    ->update([
                                            'desc' => null,
                                    ]);
                        }
                } else {
                    if (!$existingEntry) {
                        TestingAbsen::create([
                            'user_id' => $log->nik,
                            'date' => $log->scan_date,
                            'start_work' => $log->scan_date,
                            'start_work_info' => $log->sn,
                            'desc' => 'TA',
                            'hadir' => '1',
                            'shift' => '0'
                        ]);
                    } else {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->update([
                                    'end_work' => $log->scan_date,
                                    'start_work_info' => $log->sn,
                                    'end_work_info' => $log->sn,
                            ]);
                    }

                    $totalHourNonShift = TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->select([
                                'test_absen_regs.date as date',
                                DB::raw('SUM(HOUR(TIMEDIFF(end_work, start_work))) as total_hours'),
                                DB::raw('SUM(MINUTE(TIMEDIFF(end_work, start_work))) as total_minutes'),
                                DB::raw('SUM(CASE WHEN HOUR(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_hour'),
                                DB::raw('SUM(CASE WHEN MINUTE(TIMEDIFF(end_work, start_work)) > 8 THEN HOUR(TIMEDIFF(end_work, start_work)) - 8 ELSE 0 END) as overtime_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(MINUTE(TIMEDIFF(start_work, CONCAT(date, " ", "08:05:00")))) ELSE 0 END) as late_minutes'),
                                DB::raw('SUM(CASE WHEN TIME(start_work) > TIME(CONCAT(date, " " ,"08:05:00")) THEN FLOOR(HOUR(TIMEDIFF(start_work, CONCAT(date, " " ,"08:05:00")))) ELSE 0 END) as late_hours'),
                            ])
                            ->first();

                    $descUser = TestingAbsen::where('user_id', $log->nik)
                        ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                        ->value('desc');

                    // Jam shift (Actual)
                    $user = User::where('nik', $log->nik)->first();
                    $startWorkUserInjury = $user->start_work_user;
                    $startWorkUserTimeInjury = Carbon::parse($startWorkUserInjury)->format('H:i:s');

                // Jam Absen (Origin)
                $scanDateUser = TestingAbsen::where('user_id', $log->nik)
                    ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                    ->value('start_work');

                    // Jam
                    $scanDateUserTime = Carbon::parse($scanDateUser)->format('H:i:s');

                    if ($scanDateUserTime > $startWorkUserTimeInjury) {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->update([
                                    'desc' => 'L',
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                            ]);
                    } elseif ($scanDateUserTime <= $startWorkUserTimeInjury && $descUser == 'D') {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->where('desc', 'D')
                            ->update([
                                'desc' => 'D',
                                'total_hour' => $totalHourNonShift->total_hours,
                                'overtime_hour' => $totalHourNonShift->overtime_hour,
                                'late_hour' => $totalHourNonShift->late_hours,
                                'total_minute' => $totalHourNonShift->total_minutes,
                                'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                'late_minute' => $totalHourNonShift->late_minutes,
                            ]);
                    } elseif ($scanDateUserTime <= $startWorkUserTimeInjury && $descUser == 'IP') {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->where('desc', 'IP')
                            ->update([
                                'desc' => 'IP',
                                'total_hour' => $totalHourNonShift->total_hours,
                                'overtime_hour' => $totalHourNonShift->overtime_hour,
                                'late_hour' => $totalHourNonShift->late_hours,
                                'total_minute' => $totalHourNonShift->total_minutes,
                                'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                'late_minute' => $totalHourNonShift->late_minutes,
                            ]);
                    } else {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->update([
                                    'desc' => 'H',
                                    'total_hour' => $totalHourNonShift->total_hours,
                                    'overtime_hour' => $totalHourNonShift->overtime_hour,
                                    'late_hour' => $totalHourNonShift->late_hours,
                                    'total_minute' => $totalHourNonShift->total_minutes,
                                    'overtime_minute' => $totalHourNonShift->overtime_minutes,
                                    'late_minute' => $totalHourNonShift->late_minutes,
                            ]);
                    }
                }

                    // Update data dengan desc MX
                    if ($existingEntry) {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->where('desc', 'MX')
                            ->update([
                                'start_work' => $log->scan_date,
                            ]);
                    } else {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->where('desc', 'MX')
                            ->update([
                                'end_work' => $log->scan_date,
                                'end_work_info' => $log->sn,
                            ]);
                    }

                    // Update data dengan desc D
                    if ($existingEntry) {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->where('desc', 'D')
                            ->update([
                                'end_work' => $log->scan_date,
                                'end_work_info' => $log->sn,
                            ]);
                    }

                    // Update data dengan desc IP
                    if ($existingEntry) {
                        TestingAbsen::where('user_id', $log->nik)
                            ->whereDate('date', '=', date('Y-m-d', strtotime($log->scan_date)))
                            ->whereNotNull('start_work')
                            ->where('start_work', '!=', $log->scan_date)
                            ->where('desc', 'IP')
                            ->update([
                                'end_work' => $log->scan_date,
                                'end_work_info' => $log->sn,
                            ]);
                    }

            }
    }
}

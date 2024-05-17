<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\TestingAbsen;
use Carbon\CarbonPeriod;
use App\Models\User;

class AttendanceArchiveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archived:attendancedata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archived attendance data from test_absen_regs table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $date = Carbon::now()->format('Y-m-d');
        $date = '2024-03-31';
        $startDate = Carbon::parse($date)->firstOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        if ($date == $endDate) {

            $dateNew = Carbon::parse($date)->addDay()->format('Y-m-d');
            $startDateNewA = Carbon::parse($dateNew)->firstOfMonth()->format('Y-m-d');
            $startDateNew = Carbon::parse($dateNew)->firstOfMonth();
            $lastDateNew = Carbon::parse($startDateNew)->endOfMonth();

            if ($dateNew == $startDateNewA) {
                $nik = User::select('nik')->get();

                $period = CarbonPeriod::create($startDateNew, $lastDateNew);
                foreach ($period as $date) {
                    $dates[] = $date->format('Y-m-d');
                }

                foreach ($nik as $user) {
                    foreach ($dates as $date) {
                        TestingAbsen::firstOrCreate([
                            'user_id' => $user->nik,
                            'date' => $date,
                            // 'desc' => 'TA'
                        ]);
                    }
                }
            }

            $filename = "absen_regs_{$startDate}_to_{$endDate}.sql";

            $sql = "INSERT INTO `test_absen_regs` (`id`, `user_id`, `date`, `start_work`, `start_work_info`, `start_work_info_url`, `end_work`, `end_work_info`, `end_work_info_url`, `total_hour`, `total_minute`, `overtime_hour`, `overtime_minute`, `late_hour`, `late_minute`, `desc`, `hadir`, `shift`, `info`, `link`, `checked`, `checked_by`, `approval`, `approval_by`, `created_at`, `updated_at`, `sn`) VALUES \n";

            $data = TestingAbsen::whereBetween('date', [$startDate, $endDate])->get();
            foreach ($data as $index => $row) {
                $sql .= "(NULL ,'{$row->user_id}', '{$row->date}', ";

                $sql .= $row->start_work !== null ? "'{$row->start_work}'" : 'NULL';

                $sql .= $row->start_work_info !== null ? ", '{$row->start_work_info}'" : ', NULL';

                $sql .= $row->start_work_info_url !== null ? ", '{$row->start_work_info_url}'" : ', NULL';

                $sql .= $row->end_work !== null ? ", '{$row->end_work}'" : ', NULL';

                $sql .= $row->end_work_info !== null ? ", '{$row->end_work_info}'" : ', NULL';

                $sql .= $row->end_work_info_url !== null ? ", '{$row->end_work_info_url}'" : ', NULL';

                $sql .= $row->total_hour !== null ? ", {$row->total_hour}" : ', NULL';

                $sql .= $row->total_minute !== null ? ", {$row->total_minute}" : ', NULL';

                $sql .= $row->overtime_hour !== null ? ", {$row->overtime_hour}" : ', NULL';

                $sql .= $row->overtime_minute !== null ? ", {$row->overtime_minute}" : ', NULL';

                $sql .= $row->late_hour !== null ? ", {$row->late_hour}" : ', NULL';

                $sql .= $row->late_minute !== null ? ", {$row->late_minute}" : ', NULL';

                $sql .= ", '{$row->desc}'";

                $sql .= $row->hadir !== null ? ", {$row->hadir}" : ', NULL';

                $sql .= $row->shift !== null ? ", {$row->shift}" : ', NULL';

                $sql .= $row->info !== null ? ", '{$row->info}'" : ', NULL';

                $sql .= $row->link !== null ? ", '{$row->link}'" : ', NULL';

                $sql .= $row->checked !== null ? ", '{$row->checked}'" : ', NULL';

                $sql .= $row->checked_by !== null ? ", '{$row->checked_by}'" : ', NULL';

                $sql .= $row->approval !== null ? ", '{$row->approval}'" : ', NULL';

                $sql .= $row->approval_by !== null ? ", '{$row->approval_by}'" : ', NULL';

                $sql .= $row->created_at !== null ? ", '{$row->created_at}'" : ', NULL';

                $sql .= $row->updated_at !== null ? ", '{$row->updated_at}'" : ', NULL';

                $sql .= $row->sn !== null ? ", '{$row->sn}'" : ', NULL';

                if ($index === count($data) - 1) {
                    $sql .= ");\n";
                } else {
                    $sql .= "),\n";
                }
            }

            $sql = rtrim($sql);

            $isStored = Storage::disk('local')->put("sql_exports/$filename", $sql);

            if ($isStored) {
                // TestingAbsen::whereBetween('date', [$startDate, $endDate])->delete();
                $this->info('Custom task executed successfully!');
            }
        } else {
            $this->info('Custom task executed failed!');
        }
    }
}

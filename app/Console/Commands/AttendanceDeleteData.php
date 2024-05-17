<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\TestingAbsen;

class AttendanceDeleteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:attendancedata';

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
        $date = Carbon::now()->format('Y-m-d');
        $startDate = Carbon::parse($date)->firstOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $delAttData = TestingAbsen::whereBetween('date', [$startDate, $endDate])->delete();

        if ($delAttData) {
            return 1;
        } else {
            return 0;
        }
    }
}

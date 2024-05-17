<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\TestingAbsen;

class WeeklyAbsentChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $dataByWeek = [];
        $weeksInfo = [];

        for ($week = 1; $week <= 5; $week++) {
            $startDate = Carbon::create($currentYear, $currentMonth, 1)->startOfWeek()->addWeeks($week - 1);
            $endDate = $startDate->copy()->endOfWeek();

            $totalAbsen = TestingAbsen::whereBetween('date', [$startDate, $endDate])->count();
            $dataByWeek[] = $totalAbsen;

            $startDateString = $startDate->format('d F');
            $endDateString = $endDate->format('d F Y');
            $weeksInfo[] = "Week $week ($startDateString - $endDateString)";
        }

        return $this->chart->lineChart()
            ->setTitle('Total Absensi Minggu Ini')
            ->setSubtitle('Total data absen per minggu')
            ->addData('Total Absensi', $dataByWeek)
            ->setXAxis($weeksInfo)
            ->setColors(['#98FB98', '#98FB98'])
            ->setGrid()
            ->setMarkers(['#2E8B57', '#2E8B57'], 7, 10);
    }
}
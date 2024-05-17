<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\TestingAbsen;
use Carbon\Carbon;

class MinutesAbsentChart
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
        $currentDay = Carbon::now()->day;
        $currentHour = Carbon::now()->hour;
        $currentMinute = Carbon::now()->minute;

        $dataByMinute = [];
        $dataLabels = [];

        $interval = 1;

        $startOfDay = Carbon::create($currentYear, $currentMonth, $currentDay, $currentHour, $currentMinute)->startOfHour();
        $endOfDay = Carbon::create($currentYear, $currentMonth, $currentDay, $currentHour, $currentMinute)->endOfHour();

        while ($startOfDay->lte($endOfDay)) {
            $endOfInterval = $startOfDay->copy()->addMinutes($interval);
            $totalAbsen = TestingAbsen::whereBetween('date', [$startOfDay, $endOfInterval])->count();
            $dataByMinute[] = $totalAbsen;

            $minuteLabel = $startOfDay->format('H:i');
            $dataLabels[] = $minuteLabel;

            $startOfDay->addMinutes($interval);
        }

        return $this->chart->lineChart()
            ->setTitle('Total Absensi Per Menit')
            ->setSubtitle('Total data absen per menit')
            ->addData('Total Absensi', $dataByMinute)
            ->setXAxis($dataLabels)
            ->setColors(['#FFFF00', '#FFFF00'])
            ->setGrid()
            ->setMarkers(['#DAA520', '#DAA520'], 7, 10);
    }


}
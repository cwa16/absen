<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\TestingAbsen;

class DailyAbsentChart
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

        $dataByDay = [];
        $dataLabels = [];

        $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);

        while ($startOfMonth->month === $currentMonth) {
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            while ($startOfMonth->lte($endOfMonth)) {
                $totalAbsen = TestingAbsen::whereDate('date', $startOfMonth)->count();
                $dataByDay[] = $totalAbsen;

                $dayLabel = $startOfMonth->format('d M');
                $dataLabels[] = $dayLabel;

                $startOfMonth->addDay();
            }

            $startOfMonth->addMonth();
        }

        return $this->chart->lineChart()
            ->setTitle('Total Absensi Harian')
            ->setSubtitle('Total data absen per tanggal - ' . Carbon::now()->format('d F Y'))
            ->addData('Total Absensi', $dataByDay)
            ->setXAxis($dataLabels)
            ->setColors(['#ffc63b', '#ff6384'])
            ->setGrid()
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10);
    }

}
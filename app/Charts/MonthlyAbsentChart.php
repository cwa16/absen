<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\TestingKitaServer;
use App\Models\TestingAbsen;

class MonthlyAbsentChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $currentYear = Carbon::now()->year;

        $dataByMonth = [];
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        $currentMonth = Carbon::now()->month;
        $currentMonthLabel = $months[$currentMonth - 1];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($currentYear, $month, 1)->startOfMonth();
            $endDate = Carbon::create($currentYear, $month, 1)->endOfMonth();

            $totalAbsen = TestingAbsen::whereBetween('date', [$startDate, $endDate])->count();
            $dataByMonth[] = $totalAbsen;
        }

        return $this->chart->lineChart()
            ->setTitle('Total Absensi Bulan Ini')
            ->setSubtitle("Total data absen per bulan - $currentMonthLabel $currentYear")
            ->addData('Total Absensi', $dataByMonth)
            ->setXAxis($months)
            ->setColors(['#FF69B4', '#ff6384'])
            ->setGrid()
            ->setMarkers(['#800000', '#E040FB'], 7, 10);
    }

}
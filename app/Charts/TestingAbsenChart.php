<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\TestingKitaServer;
use Carbon\Carbon;

class TestingAbsenChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $currentTime = Carbon::now();
        $startDate = $currentTime->copy()->startOfDay();
        $endDate = $currentTime->copy()->endOfDay();

        $data = TestingKitaServer::whereBetween('scan_date', [$startDate, $endDate])
            ->orderBy('scan_date')
            ->get();

        $dataByDateTime = [];

        foreach ($data as $item) {
            $dateTime = Carbon::parse($item->scan_date);
            $formattedDateTime = $dateTime->format('d F Y H:i:s');

            if (isset($dataByDateTime[$formattedDateTime])) {
                $dataByDateTime[$formattedDateTime]++;
            } else {
                $dataByDateTime[$formattedDateTime] = 1;
            }
        }

        $dataLabels = array_keys($dataByDateTime);
        $dataTotalAbsen = array_values($dataByDateTime);

        return $this->chart->lineChart()
            ->setTitle('Total Absensi Hari Ini')
            ->setSubtitle('Total absensi per tanggal ' . $currentTime)
            ->addData('Total Absensi', $dataTotalAbsen)
            ->setXAxis($dataLabels)
            ->setGrid();

    }
}
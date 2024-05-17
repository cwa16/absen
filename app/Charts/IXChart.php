<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use DB;

class IXChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $datas = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('users.nik', 'users.name', 'absen_regs.date', 'absen_regs.start_work', 'absen_regs.end_work', 'absen_regs.desc','absen_regs.info as info' , DB::raw('COUNT(absen_regs.info) as infos'))
            ->whereNotNull('absen_regs.info')
            ->whereIn('absen_regs.desc', ['IX','I'])
            ->groupBy('absen_regs.info')
            ->get();

        foreach ($datas as $key => $value) {
            $count_info[] = $value->infos;
            $list_info[] = $value->info;
        }

        return $this->chart->barChart()
            ->setTitle('Izin')
            ->setSubtitle('Grouping Izin')
            ->addData('Izin', $count_info)
            ->setXAxis($list_info);
    }
}

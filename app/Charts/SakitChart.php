<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use DB;

class SakitChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $data = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select('users.nik','users.name','absen_regs.date','absen_regs.start_work','absen_regs.end_work','absen_regs.desc','absen_regs.info as infos')
                ->whereNotNull('absen_regs.info')
                ->groupBy('absen_regs.info')
                ->get();

        $datas = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select('users.nik','users.name','absen_regs.date','absen_regs.start_work','absen_regs.end_work','absen_regs.desc',DB::raw('COUNT(absen_regs.info) as infos'))
                ->whereNotNull('absen_regs.info')
                ->groupBy('absen_regs.info')
                ->get();

        foreach ($data as $key => $item) {
            $info[] = $item->infos;
        }

        foreach ($datas as $key => $value) {
            $count_info[] = $value->infos;
        }

        // dd($c);

        return $this->chart->pieChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData($count_info)
            ->setLabels($info);
    }
}

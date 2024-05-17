<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use App\Models\User;
use DB;

class EmpExportNA implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function view(): View
    {
        $image = public_path("assets/img/logo.png");
        $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                        DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                    )->where('users.active', 'no')->get()->groupBy(function ($item) {
                        return $item->status;
                    });
        $year = Carbon::parse(Carbon::now())->format('Y');

        return view('admin.reports.employee-list-report-all', [
            'resign' => $resign,
            'image' => $image,
            'year' => $year,
        ]);
    }
}

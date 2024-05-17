<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use App\Models\User;
use DB;

class EmpExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $att;

    function __construct($att)
    {
        $this->att = $att;
    }

    public function view(): View
    {

        $image = public_path("assets/img/logo.png");
        $resign = User::select($this->att)
                        ->addSelect('users.start',DB::raw('DATEDIFF(CURDATE(), users.start) / 365.25 as total_years'),
                        DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                    )->where('users.active', 'yes')->get();


        $year = Carbon::parse(Carbon::now())->format('Y');

        return view('admin.reports.employee-list-report-all', [
            'resign' => $resign,
            'image' => $image,
            'year' => $year,
            'att' => $this->att
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use Carbon\CarbonPeriod;
use Redirect;

class SummaryCutiController extends Controller
{
    public function index()
    {
        $data = null;
        return view('admin.summary.summary-cuti', ['data' => $data]);
    }

    public function loadSummaryCuti(Request $request)
    {
        $date = $request->date;
        $group = $request->group;
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');
        $endOfMonth = Carbon::parse($date)->endOfMonth()->format('d');

        $fromDate = $year.'-01-01';
        $toDate = $year.'-'.$month.'-'.$endOfMonth;

        $CB_budget = 0;
        $CT_budget = 12;
        $CS_budget = 0;
        $CH_budget = 0;
        $CLL_budget = 0;
        $total_budget = $CB_budget+$CT_budget+$CH_budget+$CS_budget+$CLL_budget;

        if ($group == 'Dept') {
            $data = DB::table('leaves')
            ->join('users', 'leaves.user_id', '=', 'users.nik')
            ->select('users.nik','users.name','users.dept','users.status', 'leaves.kind', DB::raw('SUM(leaves.total) as total'))
            ->whereBetween('leaves.start_date', [$fromDate, $toDate])
            ->groupBy('users.name', 'leaves.kind')
            ->get()->groupBy(function($data) {
                return $data->dept.', '.$data->status;
            });
        }

        if ($group == 'Monthly') {
            $data = DB::table('leaves')
                ->join('users', 'leaves.user_id', '=', 'users.nik')
                ->select('users.nik','users.name','users.dept','users.status', 'leaves.kind', 'leaves.start_date', DB::raw('SUM(leaves.total) as total'))
                ->whereBetween('leaves.start_date', [$fromDate, $toDate])
                ->groupBy('users.name', 'leaves.kind')
                ->get()->groupBy(function($data) {
                    return Carbon::parse($data->start_date)->format('F');
                });

        }

        return view('admin.summary.summary-cuti', ['data' => $data,
                                                   'CB_budget' => $CB_budget,
                                                   'CT_budget' => $CT_budget,
                                                   'CS_budget' => $CS_budget,
                                                   'CH_budget' => $CH_budget,
                                                   'CLL_budget' => $CLL_budget,
                                                   'total_budget' => $total_budget,
                                                  ]);
    }
}

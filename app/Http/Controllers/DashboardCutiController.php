<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Leave;
use App\Models\LeaveBudget;
use App\Models\AbsenReg;
use App\Models\MandorTapper;
use App\Models\User;
use DataTables;
use PDF;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Alert;
use DateTime;
use Redirect;
use App\Imports\LeaveBudgetImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DashboardCutiController extends Controller
{
    public function index(Request $request)
    {
        // $data = User::with('mandor')->with('leave_budget')->orderBy('dept')->paginate(50);
        $year = Carbon::parse(Carbon::now())->format('Y');
        $data = User::with('mandor')->with(['leave' => function ($query) use ($year) {
            $query->whereYear('date', $year);
        }])->get();
        
        $dept = User::groupBy('dept')->get();

        return view('admin.pages.dashboard-cuti', ['data' => $data,
                                                   'dept' => $dept,
                                                   'year' => $year]);
    }

    public function find(Request $request)
    {
        $name = $request->name;
        $dept = $request->dept;

        $data = User::where( 'name', 'LIKE', '%' . $name . '%' )->where( 'dept', 'LIKE', '%' . $dept . '%' )->with('mandor')->with('leave_budget')->orderBy('dept')->simplePaginate(70);
        $dept = User::groupBy('dept')->get();

        return view('admin.pages.dashboard-cuti', ['data' => $data,
                                                   'dept' => $dept]);
    }
}

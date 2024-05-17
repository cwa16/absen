<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\User;
use Redirect;
use App\Exports\AbsenExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class SummaryPerDeptController extends Controller
{
    public function index() 
    {
      $month = Carbon::now()->format('m');
      $monthLabel = Carbon::now()->format('F Y');
      $yearNow = Carbon::now()->format('Y');

      $emp = User::with(['absen' => function($query) use ($month) {
        $query->whereMonth('date', $month);
      }])->get()->groupBy(function($item) {
        return $item->dept;
      });

      // $emp = DB::table('users')
      //        ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
      //        ->get()
      //        ->groupBy(function($item) {
      //         return $item->dept;
      //       });

      
      return view('admin.pages.attendance-per-dept', ['emp' => $emp, 'monthLabel' => $monthLabel, 'yearNow' => $yearNow, 'month' => $month]);
    }

    public function index_filter(Request $request) 
    {
      $monthLabel = $request->month;
      $month = Carbon::parse($monthLabel)->format('m');
      $yearNow = Carbon::parse($monthLabel)->format('Y');

      $emp = User::with(['absen' => function($query) use ($month) {
        $query->whereMonth('date', $month);
      }])
      ->latest()->get()
      ->groupBy(function($item, $val) {
        return $item->dept;
      });


      return view('admin.pages.attendance-per-dept', ['emp' => $emp, 'monthLabel' => $monthLabel, 'month' => $month, 'yearNow' => $yearNow]);
    }
}

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

class SummaryController extends Controller
{
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $data = User::latest();
       
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action','admin.includes.action-summary-emp')
        ->make(true); 
      }
      return view('admin.pages.attendance-per-emp');
    }

    public function view($id)
    {
      $emp = User::with('absen')->findOrFail($id);

      // $emp2 = Absen::all();
      // dd(json_decode($emp2));
        
      // }
      
      // $sumHour = DB::table('absens')
      //             ->where('user_id', '=', $id)
      //             ->whereMonth('date', 06)
      //             ->sum(DB::raw('TIMESTAMPDIFF(HOUR, start_work, end_work)'));
      // ->where('user_id', '=', $id)
      //                  ->select('date',DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
          
      $emp1 = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select('users.name',
                       'absens.date',
                       'users.start_work_user',
                       'users.end_work_user',
                       'absens.start_work',
                       'absens.end_work',
                       'absens.desc',
                       DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"),
                       DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"),
                       )
                       ->where('absens.user_id', $id)
                       ->groupBy('absens.date')
                       ->get();
      
     
                  
      $totalHours = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absens.user_id', $id)
                       ->value('result');

      $totalOT = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absens.user_id', $id)
                       ->whereNotNull('absens.end_work')
                       ->whereTime('absens.start_work', '<', '09:00:00')
                       ->groupBy('absens.date')
                       ->get();

      $totalUH = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"))
                       ->where('absens.user_id', $id)
                       ->whereNotNull('absens.end_work')
                       ->value('userWork');
                    
      $totalOTs = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absens.user_id', $id)
                       ->whereNotNull('absens.end_work')
                       ->value('result');

      $qty = $totalOT->count();
      $tot = 8 * $qty;
      $rr = $totalOTs - $tot;
      



      

      return view('admin.pages.attendance-details', ['emp' => $emp, 
                                                      'emp1' => $emp1, 
                                                      'totalHours' => $totalHours,
                                                      'rr' => $rr
                                                    ]);
    }

    public function view_filter(Request $request)
    {
      $id = $request->id;
      $emp = User::with('absen')->findOrFail($id);

      $fromDate = $request->from;
      $toDate = $request->to;

      $emp1 = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select('users.name',
                       'absens.date',
                       'users.start_work_user',
                       'users.end_work_user',
                       'absens.start_work',
                       'absens.end_work',
                       'absens.desc',
                       DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"),
                       DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"),
                       )
                       ->where('absens.user_id', $id)
                       ->whereBetween('absens.date', [$fromDate, $toDate])
                       ->groupBy('absens.date')
                       ->get();

      $totalHours = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absens.user_id', $id)
                       ->whereBetween('absens.date', [$fromDate, $toDate])
                       ->value('result');

      $totalOT = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absens.user_id', $id)
                       ->whereBetween('absens.date', [$fromDate, $toDate])
                       ->whereNotNull('absens.end_work')
                       ->whereTime('absens.start_work', '<', '09:00:00')
                       ->groupBy('absens.date')
                       ->get();

      $totalUH = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"))
                       ->where('absens.user_id', $id)
                       ->whereNotNull('absens.end_work')
                       ->whereBetween('absens.date', [$fromDate, $toDate])
                       ->value('userWork');
                    
      $totalOTs = DB::table('users')
                       ->rightJoin('absens', 'users.id', '=', 'absens.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absens.user_id', $id)
                       ->whereNotNull('absens.end_work')
                       ->whereBetween('absens.date', [$fromDate, $toDate])
                       ->value('result');

      $qty = $totalOT->count();
      $tot = 8 * $qty;
      $rr = $totalOTs - $tot;

      return view('admin.pages.attendance-details', ['emp' => $emp, 
                                                      'emp1' => $emp1, 
                                                      'totalHours' => $totalHours,
                                                      'rr' => $rr
                                                    ]);
    }
}

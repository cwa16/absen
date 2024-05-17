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

class SummaryRegController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $data = User::where('status', 'Regular')->latest();

      return DataTables::of($data)
      ->addIndexColumn()
      ->addColumn('action','admin.includes.action-summary-emp-reg')
      ->make(true);
    }
    return view('admin.pages.attendance-per-emp-reg');
  }

  public function view($nik)
    {
      $dateNow = Carbon::now();
      $month = Carbon::parse($dateNow)->format('m');
      $yearNow = Carbon::parse($dateNow)->format('Y');
      $firstDay = $dateNow->firstOfMonth()->format('Y-m-d');
      $lastDay = $dateNow->endOfMonth()->format('Y-m-d');

      $emp = User::where('nik', $nik)->with(['absen_reg' => function($query) use ($month, $yearNow) {
          $query->whereMonth('date', $month);
          $query->whereYear('date', $yearNow);
        }])->first();



      $L = DB::table('users')
           ->rightJoin('absen_regs', 'users.nik', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'L')
           ->count();

      $A = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'A')
           ->count();

      $I = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'I')
           ->count();

      $IX = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'IX')
           ->count();

      $S = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'S')
           ->count();

      $SX = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'SX')
           ->count();

      $C = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'C')
           ->count();

      $TA = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'TA')
           ->count();


      $emp1 = DB::table('users')
                       ->rightJoin('absen_regs', 'users.nik', '=', 'absen_regs.user_id')
                       ->select('users.name',
                       'absen_regs.date',
                       'users.start_work_user',
                       'users.end_work_user',
                       'absen_regs.start_work',
                       'absen_regs.end_work',
                       'absen_regs.desc',
                       DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"),
                       DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"),
                       )
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->groupBy('absen_regs.date')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->get();

      $totalHours = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNot('absen_regs.desc', 'TA')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->value('result');

      $totalOT = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNotNull('absen_regs.end_work')
                       ->whereTime('absen_regs.start_work', '<', '09:00:00')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->groupBy('absen_regs.date')
                       ->get();

      $totalUH = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNotNull('absen_regs.end_work')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->value('userWork');

      $totalOTs = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNotNull('absen_regs.end_work')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->value('result');

      $qty = $totalOT->count();
      $tot = 8 * $qty;
      $rr = $totalOTs - $tot;

      return view('admin.pages.attendance-details-reg', ['emp' => $emp,
                                                      'emp1' => $emp1,
                                                      'totalHours' => $totalHours,
                                                      'rr' => $rr,
                                                      'L' => $L,
                                                      'A' => $A,
                                                      'I' => $I,
                                                      'IX' => $IX,
                                                      'S' => $S,
                                                      'SX' => $SX,
                                                      'C' => $C,
                                                      'TA' => $TA,
                                                      'firstDay' => $firstDay,
                                                      'lastDay' => $lastDay
                                                    ]);
    }

    public function view_filter(Request $request)
    {
      $nik = $request->nik;
      $firstDay = $request->from;
      $lastDay = $request->to;

      $emp = User::where('nik', $nik)->with(['absen_reg' => function ($query) use ( $firstDay, $lastDay ){
        $query->whereBetween('date', [$firstDay, $lastDay]);

      }])->first();


     $L = DB::table('users')
           ->rightJoin('absen_regs', 'users.nik', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'L')
           ->count();

      $A = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'A')
           ->count();

      $I = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'I')
           ->count();

      $IX = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'IX')
           ->count();

      $S = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'S')
           ->count();

      $SX = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'SX')
           ->count();

      $C = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'C')
           ->count();

      $TA = DB::table('users')
           ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
           ->select('users.name', 'absen_regs.date', 'absen_regs.desc')
           ->where('absen_regs.user_id', $nik)
           ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
           ->where('absen_regs.desc', 'TA')
           ->count();


      $emp1 = DB::table('users')
                       ->rightJoin('absen_regs', 'users.nik', '=', 'absen_regs.user_id')
                       ->select('users.name',
                       'absen_regs.date',
                       'users.start_work_user',
                       'users.end_work_user',
                       'absen_regs.start_work',
                       'absen_regs.end_work',
                       'absen_regs.desc',
                       DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"),
                       DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"),
                       )
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->groupBy('absen_regs.date')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->get();

      $totalHours = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNot('absen_regs.desc', 'TA')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->value('result');

      $totalOT = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNotNull('absen_regs.end_work')
                       ->whereTime('absen_regs.start_work', '<', '09:00:00')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->groupBy('absen_regs.date')
                       ->get();

      $totalUH = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work_user, start_work_user)) / 3600) as userWork"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNotNull('absen_regs.end_work')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->value('userWork');

      $totalOTs = DB::table('users')
                       ->rightJoin('absen_regs', 'users.id', '=', 'absen_regs.user_id')
                       ->select(DB::raw("SUM(time_to_sec(timediff(end_work, start_work)) / 3600) as result"))
                       ->where('absen_regs.user_id', $nik)
                       ->whereBetween('absen_regs.date', [$firstDay, $lastDay])
                       ->whereNotNull('absen_regs.end_work')
                       ->orderBy('absen_regs.date', 'ASC')
                       ->value('result');

      $qty = $totalOT->count();
      $tot = 8 * $qty;
      $rr = $totalOTs - $tot;

      return view('admin.pages.attendance-details-reg', ['emp' => $emp,
                                                      'emp1' => $emp1,
                                                      'totalHours' => $totalHours,
                                                      'rr' => $rr,
                                                      'firstDay' => $firstDay,
                                                      'lastDay' => $lastDay
                                                    ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AbsenReg;
use App\Models\MandorTapper;
use App\Models\TestingAbsen;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SummaryPerKategoriController extends Controller
{
    public function index()
    {
        $data = null;
        $dept = DB::table('users')->groupBy('dept')->get();
        $desc = 0;
        $total = 0;
        $months = 0;
        $year = 0;
        return view('admin.summary.summary-kategori', ['data' => $data, 'dept' => $dept, 'desc' => $desc, 'total' => $total, 'months' => $months, 'year' => $year]);
    }

    public function loadSummaryKategori(Request $request)
    {
        $date = $request->date;
        $group = $request->group;
        $month = Carbon::parse($date)->format('m');
        $months = Carbon::parse($date)->format('F');
        $year = Carbon::parse($date)->format('Y');
        $dept = DB::table('users')->groupBy('dept')->get();

        if ($group == 'All') {
            $data = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select('users.nik', 'users.name', 'users.dept', 'users.status', 'absen_regs.date', 'absen_regs.desc', DB::raw('COUNT(absen_regs.desc) as total'))
                ->whereMonth('absen_regs.date', $month)
                ->whereYear('absen_regs.date', $year)
                ->groupBy('users.name')
                ->get()->groupBy(function ($data) {
                    return $data->dept . ', ' . $data->status . ' - ' . Carbon::parse($data->date)->format('F Y');
                });

            $chart = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select('absen_regs.desc', DB::raw('COUNT(absen_regs.desc) as total'))
                ->whereMonth('absen_regs.date', $month)
                ->whereYear('absen_regs.date', $year)
                ->groupBy('absen_regs.desc')
                ->orderBy('absen_regs.desc', 'ASC')
                ->get();

            foreach ($chart as $cdata) {
                $descArray[] = $cdata->desc;
                $totalArray[] = $cdata->total;
            }
            $desc = json_encode($descArray);
            $total = json_encode($totalArray);

        } else {
            $data = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select('users.nik', 'users.name', 'users.dept', 'users.status', 'absen_regs.date', 'absen_regs.desc', DB::raw('COUNT(absen_regs.desc) as total'))
                ->whereMonth('absen_regs.date', $month)
                ->whereYear('absen_regs.date', $year)
                ->where('users.dept', $group)
                ->groupBy('users.name')
                ->get()->groupBy(function ($data) {
                    return $data->dept . ', ' . $data->status . ' - ' . Carbon::parse($data->date)->format('F Y');
                });

            $chart = DB::table('absen_regs')
                ->join('users', 'absen_regs.user_id', '=', 'users.nik')
                ->select('absen_regs.desc', DB::raw('COUNT(absen_regs.desc) as total'))
                ->whereMonth('absen_regs.date', $month)
                ->whereYear('absen_regs.date', $year)
                ->where('users.dept', $group)
                ->groupBy('absen_regs.desc')
                ->orderBy('absen_regs.desc', 'ASC')
                ->get();

            foreach ($chart as $cdata) {
                $descArray[] = $cdata->desc;
                $totalArray[] = $cdata->total;
            }
            $desc = json_encode($descArray);
            $total = json_encode($totalArray);
        }
        return view('admin.summary.summary-kategori', [
            'data' => $data,
            'dept' => $dept,
            'months' => $months,
            'year' => $year,
            'desc' => $desc,
            'total' => $total
        ]);
    }

    public function index_new()
    {
        $userDept = Auth::user()->dept;
        $getEmployeesDept = User::pluck('dept')->unique();

        $getEmployeesStatus = User::pluck('status')->unique();

        return view(
            'admin.pages.summary.summary-kategori',
            [
                'getEmployeesDept' => $getEmployeesDept,
                'getEmployeesStatus' => $getEmployeesStatus,
                'userDept' => $userDept
            ]
        );
    }

    public function getDataPerkategori(Request $request)
    {
        $startPeriod = $request->start;
        $endPeriod = $request->end;
        $dept = $request->dept;
        $status = $request->status;
        $categories = $request->kategori;

        if ($dept == 'BSKP') {
            $dataEmp = User::where('loc_kerja', 'Head Office')
                ->where('active', 'yes')
                ->whereIn('status', $status)
                ->select('nik', 'name', 'status', 'dept')
                ->get();
        } else {
            $dataEmp = User::where('dept', $dept)
                ->where('active', 'yes')
                ->whereIn('status', $status)
                ->select('nik', 'name', 'status', 'dept')
                ->get();
        }

        // dd($status);

        return view('admin.pages.summary.summary-kategori-new', [
            'dataEmp' => $dataEmp,
            'dept' => $dept,
            'status' => $status,
            'categories' => $categories,
            'startPeriod' => $startPeriod,
            'endPeriod' => $endPeriod
        ]);
    }
}

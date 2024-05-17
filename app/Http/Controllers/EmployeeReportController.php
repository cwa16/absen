<?php

namespace App\Http\Controllers;

use Alert;
use App\Exports\EmpExport;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class EmployeeReportController extends Controller
{
    public function index()
    {
        return view('admin.pages.master-employee-report');
    }

    public function index_excel()
    {
        return view('admin.pages.master-employee-report-excel');
    }

    public function print(Request $request)
    {
        $filter_by = $request->filter_by;
        $sorted_by = $request->sorted;
        $resigned = $request->resigned;
        $monthly = $request->monthly;

        switch ($request->action) {
            case 'preview':
                if ($filter_by == 'all' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                    $todate = Carbon::parse(Carbon::now())->format('Y-m-d');
                    // $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                    //     DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old"),
                    // )->get()->groupBy(function ($item) {
                    //     return $item->status;
                    // });

                    $resign = DB::table('users')
                        ->select('users.*')
                        ->selectRaw("DATEDIFF(CURDATE(), users.start) / 365.25 as total_year")
                        ->selectRaw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                        ->selectRaw('COUNT(users.nik) as c_emp')
                        ->groupBy('users.status', 'users.nik')
                        ->get()->groupBy(function ($item) {
                        return $item->status;
                    });

                    $imagePath = public_path("assets/img/logo.png");
                    $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                    $year = Carbon::parse(Carbon::now())->format('Y');

                    $pdf = PDF::loadView('admin.reports.employee-list-report-all', ['resign' => $resign,
                        'image' => $image,
                        'year' => $year]);

                    return $pdf->stream();
                } else if ($filter_by == 'all' && $sorted_by == 'status_dept' && $resigned == '1' && $monthly == null) {
                    $resign = DB::table('table_emp_outs')
                        ->join('users', 'table_emp_outs.nik', '=', 'users.nik')
                        ->select('users.dept', 'users.name', 'users.sex', 'users.grade', 'table_emp_outs.*')
                        ->selectRaw('DATEDIFF(date_out, start_work) / 365.25 as total_years')
                        ->selectRaw('DATEDIFF(date_out, users.ttl) / 365.25 as old')
                        ->selectRaw('COUNT(table_emp_outs.nik) as c_emp')
                        ->groupBy('users.status')
                        ->get();

                    $imagePath = public_path("assets/img/logo.png");
                    $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                    $year = Carbon::parse(Carbon::now())->format('Y');

                    $pdf = PDF::loadView('admin.reports.employee-list-report-monthly', ['resign' => $resign,
                        'image' => $image,
                        'year' => $year]);

                    return $pdf->stream();
                } else if ($filter_by == 'all' && $sorted_by == 'status_dept' && $resigned == '1' && $monthly == '1') {

                    $resign = DB::table('table_emp_outs')
                        ->join('users', 'table_emp_outs.nik', '=', 'users.nik')
                        ->select('users.nik', 'users.dept', 'users.name', 'users.sex', 'users.grade', 'table_emp_outs.*')
                        ->selectRaw('DATEDIFF(table_emp_outs.date_out, start_work) / 365.25 as total_years')
                        ->selectRaw('DATEDIFF(table_emp_outs.date_out, users.ttl) / 365.25 as old')
                        ->groupBy(DB::raw('MONTH(table_emp_outs.date_out)'))
                        ->get();

                    $imagePath = public_path("assets/img/logo.png");
                    $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                    $year = Carbon::parse(Carbon::now())->format('Y');

                    $pdf = PDF::loadView('admin.reports.employee-list-report-monthly', ['resign' => $resign,
                        'image' => $image,
                        'year' => $year]);

                    return $pdf->stream();
                } else if ($filter_by == 'NEO' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                    $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                        DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                    )->where('users.active', 'yes')->whereYear('start', Carbon::now()->format('Y'))->get()->groupBy(function ($item) {
                        return $item->status;
                    });

                    if ($resign->count() > 0) {
                        $imagePath = public_path("assets/img/logo.png");
                        $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                        $year = Carbon::parse(Carbon::now())->format('Y');

                        $pdf = PDF::loadView('admin.reports.employee-list-report-all', ['resign' => $resign,
                            'image' => $image,
                            'year' => $year]);

                        return $pdf->stream();
                    } else {
                        Alert::error('Maaf', 'Tidak ada data');
                        return redirect()->route('employee-list-report');
                    }

                } else if ($filter_by == 'ENAO' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                    $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                        DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                    )->where('users.active', 'no')->get()->groupBy(function ($item) {
                        return $item->status;
                    });

                    // dd($resign);

                    $ket = 'NON-ACTIVE';

                    $imagePath = public_path("assets/img/logo.png");
                    $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                    $year = Carbon::parse(Carbon::now())->format('Y');

                    $pdf = PDF::loadView('admin.reports.employee-list-report-all', ['resign' => $resign,
                        'image' => $image,
                        'year' => $year,
                        'ket' => $ket]);

                    return $pdf->stream();
                } else if ($filter_by == 'EAO' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                    $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), users.start) / 365.25 as total_years'),
                        DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                    )->where('users.active', 'yes')->get()->groupBy(function ($item) {
                        return $item->status;
                    });

                    // dd($resign);

                    $ket = 'ACTIVE';

                    $imagePath = public_path("assets/img/logo.png");
                    $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                    $year = Carbon::parse(Carbon::now())->format('Y');

                    $pdf = PDF::loadView('admin.reports.employee-list-report-all', ['resign' => $resign,
                        'image' => $image,
                        'year' => $year,
                        'ket' => $ket]);

                    return $pdf->stream();
                }
                break;

            case 'export':
                $att = [
                    'nik',
                    'name',
                    'status',
                    'grade',
                    'dept',
                    'jabatan',
                    'sex',
                    'ttl',
                    'no_baju',
                    'gol_darah',
                    'start',
                    'pendidikan',
                    'agama',
                    'domisili',
                    'email',
                    'no_ktp',
                    'no_telpon',
                    'kis',
                    'kpj',
                    'bank',
                    'no_bank',
                    'suku',
                    'no_sepatu_safety',
                    'start_work_user',
                    'end_work_user',
                    'loc_kerja',
                    'loc',
                    'sistem_absensi',
                    'latitude',
                    'longitude',
                    'status_pernikahan',
                    'istri_suami',
                ];

                return view('admin.pages.master-employee-report-excel', ['att' => $att]);
                // if ($filter_by == 'all' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                //     $todate = Carbon::parse(Carbon::now())->format('Y-m-d');
                //     $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                //         DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old"),
                //     )->get()->groupBy(function ($item) {
                //         return $item->status;
                //     });

                //     $imagePath = public_path("assets/img/logo.png");
                //     $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                //     $year = Carbon::parse(Carbon::now())->format('Y');

                //     $pdf = PDF::loadView('admin.reports.employee-list-report-all', ['resign' => $resign,
                //         'image' => $image,
                //         'year' => $year]);

                //     return $pdf->stream();
                // } else if ($filter_by == 'all' && $sorted_by == 'status_dept' && $resigned == '1' && $monthly == null) {
                //     $resign = DB::table('table_emp_outs')
                //         ->join('users', 'table_emp_outs.nik', '=', 'users.nik')
                //         ->select('users.dept', 'users.name', 'users.sex', 'users.grade', 'table_emp_outs.*')
                //         ->selectRaw('DATEDIFF(date_out, start_work) / 365.25 as total_years')
                //         ->selectRaw('DATEDIFF(date_out, users.ttl) / 365.25 as old')
                //         ->selectRaw('COUNT(table_emp_outs.nik) as c_emp')
                //         ->groupBy('users.status')
                //         ->get();

                //     $imagePath = public_path("assets/img/logo.png");
                //     $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                //     $year = Carbon::parse(Carbon::now())->format('Y');

                //     $pdf = PDF::loadView('admin.reports.employee-list-report-monthly', ['resign' => $resign,
                //         'image' => $image,
                //         'year' => $year]);

                //     return $pdf->stream();
                // } else if ($filter_by == 'all' && $sorted_by == 'status_dept' && $resigned == '1' && $monthly == '1') {

                //     $resign = DB::table('table_emp_outs')
                //         ->join('users', 'table_emp_outs.nik', '=', 'users.nik')
                //         ->select('users.dept', 'users.name', 'users.sex', 'users.grade', 'table_emp_outs.*')
                //         ->selectRaw('DATEDIFF(table_emp_outs.date_out, start_work) / 365.25 as total_years')
                //         ->selectRaw('DATEDIFF(table_emp_outs.date_out, users.ttl) / 365.25 as old')
                //         ->groupBy(DB::raw('MONTH(table_emp_outs.date_out)'))
                //         ->get();

                //     $imagePath = public_path("assets/img/logo.png");
                //     $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                //     $year = Carbon::parse(Carbon::now())->format('Y');

                //     $pdf = PDF::loadView('admin.reports.employee-list-report-monthly', ['resign' => $resign,
                //         'image' => $image,
                //         'year' => $year]);

                //     return $pdf->stream();
                // } else if ($filter_by == 'NEO' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                //     $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                //         DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                //     )->where('users.active', 'yes')->whereYear('start', Carbon::now()->format('Y'))->get()->groupBy(function ($item) {
                //         return $item->status;
                //     });

                //     if ($resign->count() > 0) {
                //         $imagePath = public_path("assets/img/logo.png");
                //         $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                //         $year = Carbon::parse(Carbon::now())->format('Y');

                //         $pdf = PDF::loadView('admin.reports.employee-list-report-all', ['resign' => $resign,
                //             'image' => $image,
                //             'year' => $year]);

                //         return $pdf->stream();
                //     } else {
                //         Alert::error('Maaf', 'Tidak ada data');
                //         return redirect()->route('employee-list-report');
                //     }

                // } else if ($filter_by == 'ENAO' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                //     $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                //         DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                //     )->where('users.active', 'no')->get()->groupBy(function ($item) {
                //         return $item->status;
                //     });

                //     // dd($resign);

                //     $imagePath = public_path("assets/img/logo.png");
                //     $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                //     $year = Carbon::parse(Carbon::now())->format('Y');

                //     // Export data to Excel
                //     return Excel::download(new EmpExportNA(), 'exported_data.xlsx');
                // } else if ($filter_by == 'EAO' && $sorted_by == 'status_dept' && $resigned == null && $monthly == null) {
                //     $resign = User::select('users.*', DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                //         DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
                //     )->where('users.active', 'yes')->get()->groupBy(function ($item) {
                //         return $item->status;
                //     });

                //     // dd($resign);

                //     $imagePath = public_path("assets/img/logo.png");
                //     $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

                //     $year = Carbon::parse(Carbon::now())->format('Y');

                //     // Export data to Excel
                //     return Excel::download(new EmpExport(), 'exported_data.xlsx');
                // }
        }

    }

    public function print_career($nik)
    {
        $career = DB::table('table_work_histories')
            ->where('nik', $nik)
            ->get();
        $emp = DB::table('users')
            ->where('users.nik', $nik)
            ->select('users.*')
            ->first();

        $imagePath = public_path("assets/img/logo.png");
        $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

        $year = Carbon::parse(Carbon::now())->format('Y');

        $pdf = PDF::loadView('admin.reports.employee-career-report', ['career' => $career,
            'image' => $image,
            'year' => $year,
            'emp' => $emp]);
        return $pdf->stream();
    }

    public function print_general($nik)
    {
        $emp = DB::table('users')->where('nik', $nik)->first();

        $profile_photo = public_path('image/' . $emp->image_url);
        $imagePath = public_path("assets/img/logo.png");
        $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

        $year = Carbon::parse(Carbon::now())->format('Y');

        $image_profile = "data:image/png;base64," . base64_encode(file_get_contents($profile_photo));

        $work = DB::table('table_work_histories')->where('nik', $nik)->get();

        $pdf = PDF::loadView('admin.reports.employee-general-report', ['emp' => $emp,
            'image' => $image,
            'work' => $work,
            'image_profile' => $image_profile,
            'year' => $year])->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function excel(Request $request)
    {
        $att = $request->att;

        if ($att != 'all') {
            $user = User::select(DB::raw('DATEDIFF(CURDATE(), start) / 365.25 as total_years'),
                DB::raw("DATEDIFF(CURDATE(), users.ttl) / 365.25 as old")
            )->where('users.active', 'yes')->get($att)->groupBy(function ($item) {
                return $item->status;
            });

            $imagePath = public_path("assets/img/logo.png");
            $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $year = Carbon::parse(Carbon::now())->format('Y');

            // Export data to Excel
            return Excel::download(new EmpExport($att), 'exported_data.xlsx');
        }

    }
}

<?php

namespace App\Http\Controllers;

use Alert;
use App\Imports\AbsenRegImport;
use App\Models\AbsenReg;
use App\Models\AbsenRegInput;
use App\Models\MandorTapper;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use DB;

class AbsenRegulerController extends Controller
{
    public function index()
    {
        $year = Carbon::parse(Carbon::now())->format('d');
        // $user = User::where('status', 'Regular')->with('leave')->get();

        if (\Auth::user()->dept == 'Workshop') {
            $user = User::where('dept', 'Workshop')->where('status', 'Regular')->whereDoesntHave('absen_reg', function (Builder $query) {
                $query->where('date', '=', Carbon::parse(Carbon::now())->format('Y-m-d'));
            })->get();
        } else if (\Auth::user()->dept == 'FSD') {
            $user = User::whereNotIn('loc_kerja', ['HO'])->where('dept', 'FSD')->where('status', 'Regular')->whereDoesntHave('absen_reg', function (Builder $query) {
                $query->where('date', '=', Carbon::parse(Carbon::now())->format('Y-m-d'));
            })->get();
            // dd($user);
        } else if (\Auth::user()->dept == 'Security') {
            $user = User::where('dept', 'Security')->where('status', 'Regular')->whereDoesntHave('absen_reg', function (Builder $query) {
                $query->where('date', '=', Carbon::parse(Carbon::now())->format('Y-m-d'));
            })->get();
        } else if (\Auth::user()->dept == 'HR Legal') {
            $user = User::whereIn('loc_kerja', ['HO', 'Head Office'])->where('status', 'Regular')->whereDoesntHave('absen_reg', function (Builder $query) {
                $query->where('date', '=', Carbon::parse(Carbon::now())->format('Y-m-d'));
            })
                ->whereHas('leave', function (Builder $query) {
                    $query->whereYear('date', '=', Carbon::parse(Carbon::now())->format('Y'));
                })
                ->get();
        } else {
            // $user = MandorTapper::whereHas('user', function (Builder $query) {
            //     $query->where('dept', '=', \Auth::user()->dept);
            //     $query->whereNotIn('loc_kerja', ['HO']);
            // })->get()->groupBy(function ($item) {
            //     return $item->user->name;
            // });

            // $user = MandorTapper::whereHas('user', function (Builder $query) {
            //     $query->where('dept', '=', \Auth::user()->dept);
            //     $query->whereNotIn('loc_kerja', ['HO']);
            // })->whereDoesntHave('absen_reg', function (Builder $query) {
            //     $query->where('date', '=', Carbon::parse(Carbon::now()->subDay(1))->format('Y-m-d'));
            // })
            // ->whereHas('leave', function (Builder $query) {
            //     $query->whereYear('date', '=', Carbon::parse(Carbon::now())->format('Y'));
            // })
            // ->get()->groupBy(function ($item) {
            //     return $item->user->name;
            // });

            $user = MandorTapper::whereHas('user', function (Builder $query) {
                $query->where('dept', '=', \Auth::user()->dept);
                $query->whereNotIn('loc_kerja', ['HO']);
            })->whereHas('test_absen_reg', function (Builder $query) {
                $query->where('date', '=', Carbon::parse(Carbon::now()->subDay(1))->format('Y-m-d'));
            })
            ->whereDoesntHave('leave', function (Builder $query) {
                $query->whereYear('date', '=', Carbon::parse(Carbon::now())->format('Y'));
            })
            ->get()->groupBy(function ($item) {
                return $item->user->name;
            });
        }

        $date = Carbon::parse(Carbon::now())->format('Y-m-d');
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d H:i:s');

        $SXLists = DB::table('sxlists')->get();
        // $SXLists = json_encode($SXList);

        return view('admin.pages.attendance-input-baru-reg', [
            'user' => $user,
            'date' => $date,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'sxlists' => $SXLists
        ]);
    }

    public function index_reg()
    {
        $date = Carbon::now()->format('Y-m-d');
        $data = AbsenReg::where('date', $date)->with('user');
        return view('admin.pages.attendance-input-reg');
    }

    public function index_reg_import()
    {
        $absen = AbsenRegInput::with('user')->get();
        // dd($absen);
        return view('admin.pages.attendance-input-baru-reg-import', ['absen' => $absen]);
    }

    public function store_import(Request $request)
    {

        foreach ($request->user_id as $key => $value) {
            $date = $request->date_select[$key];
            $start_work = $request->start_work[$key];
            $end_work = $request->end_work[$key];

            $sw = Carbon::parse($start_work)->format('H:i:s');
            $ew = Carbon::parse($end_work)->format('H:i:s');

            $swW = '' . $date . ' ' . $sw . '';
            $ewW = '' . $date . ' ' . $ew . '';
            // $image = $this->saveImage($request->image, 'absens');

            // $Record = new AbsenReg;
            // $Record->user_id = $request->get('user_id')[$key];
            // $Record->date = $request->get('date_select')[$key];
            // $Record->start_work = $swW;
            // $Record->end_work = $ewW;
            // $Record->desc = $request->get('desc')[$key];
            // $Record->save();

            AbsenReg::firstOrCreate(
                [
                    'user_id' => $request->get('user_id')[$key],
                    'date' => $request->get('date_select')[$key],
                ],
                [
                    'user_id' => $request->get('user_id')[$key],
                    'date' => $request->get('date_select')[$key],
                    'start_work' => $swW,
                    'end_work' => $ewW,
                    'desc' => $request->get('desc')[$key],
                ]
            );
        }

        AbsenRegInput::truncate();
        Alert::success('Berhasil', 'Data Absensi Tersimpan!!!');

        return Redirect::back();
    }

    public function delete()
    {
        $reg = AbsenRegInput::truncate();
        // notifikasi dengan session
        Alert::success('Berhasil', 'Absensi Dikosongkan');

        return Redirect::back();
    }

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('files', $nama_file);

        // import data
        Excel::import(new AbsenRegImport, public_path('/files/' . $nama_file));

        // notifikasi dengan session
        Alert::success('Berhasil', 'Absensi Terimport');

        // alihkan halaman kembali
        return Redirect::back();
    }

    public function attendance_reg(Request $request)
    {
        if (\Auth::user()->dept == 'HR Legal' || \Auth::user()->dept == 'BSKP') {
            if ($request->ajax()) {
                $date = Carbon::now()->format('Y-m-d');
                $data = AbsenReg::where('date', $date)->with('user');
                return DataTables::eloquent($data)
                    ->addColumn('user', function (AbsenReg $absen) {
                        return $absen->user->name;
                    })
                    ->addColumn('date', function ($row) {
                        $date = date("d F Y", strtotime($row->date));
                        return $date;
                    })
                    ->addColumn('start_work', function ($row) {
                        $start_work = date("H:i:s", strtotime($row->start_work));
                        return $start_work;
                    })
                    ->addColumn('end_work', function ($row) {
                        if ($row->end_work == null) {
                            $end_work = 'Belum Absen';
                            return $end_work;
                        } else {
                            $end_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->end_work)->format('H:i:s');
                            return $end_work;
                        }
                    })
                    ->toJson();
            }
        } else {
            if ($request->ajax()) {
                $date = Carbon::now()->format('Y-m-d');
                $data = AbsenReg::where('date', $date)->whereHas('user', function (Builder $q) {
                    $q->where('dept', \Auth::user()->dept);
                })->get();
                return DataTables::of($data)
                    ->addColumn('nik', function (AbsenReg $absen) {
                        return $absen->user->nik;
                    })
                    ->addColumn('user', function (AbsenReg $absen) {
                        return $absen->user->name;
                    })
                    ->addColumn('dept', function (AbsenReg $absen) {
                        return $absen->user->dept;
                    })
                    ->addColumn('date', function ($row) {
                        $date = date("d F Y", strtotime($row->date));
                        return $date;
                    })
                    ->addColumn('start_work', function ($row) {
                        $start_work = date("H:i:s", strtotime($row->start_work));
                        return $start_work;
                    })
                    ->addColumn('end_work', function ($row) {
                        if ($row->end_work == null) {
                            $end_work = 'Belum Absen';
                            return $end_work;
                        } else {
                            $end_work = Carbon::createFromFormat('Y-m-d H:i:s', $row->end_work)->format('H:i:s');
                            return $end_work;
                        }
                    })
                    ->toJson();
            }
        }

        return view('admin.pages.attendance-input-reg');
    }

    public function store(Request $request)
    {
        $countIX = 0;
        foreach ($request->info as $key => $value) {
            if ($value != null) {
                $countIX++;
            }
        }

        $countReqI = 0;
        foreach ($request->desc as $key => $value) {
            if ($value == 'I') {
                $countReqI++;
            }
        }

        $countReqIP = 0;
        foreach ($request->desc as $key => $value) {
            if ($value == 'IP') {
                $countReqIP++;
            }
        }

        $countReqIX = 0;
        foreach ($request->desc as $key => $value) {
            if ($value == 'IX') {
                $countReqIX++;
            }
        }

        $countReqSX = 0;
        foreach ($request->desc as $key => $value) {
            if ($value == 'SX') {
                $countReqSX++;
            }
        }

        $countReqS = 0;
        foreach ($request->desc as $key => $value) {
            if ($value == 'S') {
                $countReqS++;
            }
        }

        $totalReq = $countReqI + $countReqIP + $countReqIX + $countReqSX + $countReqS;


        foreach ($request->user_id as $key => $value) {
            $date = $request->date_select[$key];
            $start_work = $request->start_work[$key];
            $end_work = $request->end_work[$key];

            $sw = Carbon::parse($start_work)->format('H:i:s');
            $ew = Carbon::parse($end_work)->format('H:i:s');

            $swW = '' . $date . ' ' . $sw . '';
            $ewW = '' . $date . ' ' . $ew . '';
            // $image = $this->saveImage($request->image, 'absens');

            if ($countIX != $totalReq) {
                Alert::warning('Gagal', 'Data I, IP, IX, S atau SX belum ada keterangan');
            } else {
                if ($request->hasfile('start_work_info_url') == true && $request->hasfile('end_work_info_url') == true) {
                    foreach ($request->file('start_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $data[] = $name;
                    }

                    foreach ($request->file('end_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $edata[] = $name;
                    }

                    AbsenReg::updateOrCreate(
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                        ],
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                            'start_work' => $swW,
                            'start_work_info' => $request->get('start_work_info')[$key],
                            'start_work_info_url' => $data[$key],
                            'end_work' => $ewW,
                            'end_work_info' => $request->get('end_work_info')[$key],
                            'end_work_info_url' => $edata[$key],
                            'desc' => $request->get('desc')[$key],
                            'info' => $request->get('info')[$key],
                        ]
                    );
                } else if ($request->hasfile('start_work_info_url') == true && $request->hasfile('end_work_info_url') == false) {
                    foreach ($request->file('start_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $data[] = $name;
                    }

                    AbsenReg::updateOrCreate(
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                        ],
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                            'start_work' => $swW,
                            'start_work_info' => $request->get('start_work_info')[$key],
                            'start_work_info_url' => $data[$key],
                            'end_work' => $ewW,
                            'end_work_info' => $request->get('end_work_info')[$key],
                            'desc' => $request->get('desc')[$key],
                            'info' => $request->get('info')[$key],
                        ]
                    );
                } else if ($request->hasfile('start_work_info_url') == false && $request->hasfile('end_work_info_url') == true) {
                    foreach ($request->file('end_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $edata[] = $name;
                    }

                    AbsenReg::updateOrCreate(
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                        ],
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                            'start_work' => $swW,
                            'start_work_info' => $request->get('start_work_info')[$key],
                            'end_work' => $ewW,
                            'end_work_info' => $request->get('end_work_info')[$key],
                            'end_work_info_url' => $edata[$key],
                            'desc' => $request->get('desc')[$key],
                            'info' => $request->get('info')[$key],
                        ]
                    );
                } else if ($request->hasfile('start_work_info_url') == false && $request->hasfile('end_work_info_url') == false) {

                    AbsenReg::updateOrCreate(
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                        ],
                        [
                            'user_id' => $request->get('user_id')[$key],
                            'date' => $request->get('date_select')[$key],
                            'start_work' => $swW,
                            'start_work_info' => $request->get('start_work_info')[$key],
                            'end_work' => $ewW,
                            'end_work_info' => $request->get('end_work_info')[$key],
                            'desc' => $request->get('desc')[$key],
                            'info' => $request->get('info')[$key],
                        ]
                    );
                }
                Alert::success('Berhasil', 'Data Absensi Tersimpan!!!');
            }
        }



        return Redirect::back();
    }
}

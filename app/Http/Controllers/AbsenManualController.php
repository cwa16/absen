<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Leave;
use App\Models\ShiftArchive;
use App\Models\TestingAbsen;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Redirect;

class AbsenManualController extends Controller
{
    public function index()
    {
        $user = User::all();
        $SXLists = DB::table('sxlists')->get();
        $IXLists = DB::table('ixlists')->get();

        return view('admin.pages.attendance-input-baru', ['user' => $user, 'sxlists' => $SXLists, 'ixlists' => $IXLists]);
    }

    /**
     * The function stores attendance data for multiple users, including their start and end work
     * times, information, and files, and returns a success message.
     *
     * @param Request request The  parameter is an instance of the Request class, which
     * represents an HTTP request. It contains all the data sent in the request, such as form inputs,
     * query parameters, and uploaded files. In this code, it is used to retrieve input values and
     * uploaded files from the request.
     *
     * @return a redirect back to the previous page.
     */
    public function store(Request $request)
    {

        foreach ($request->input('user_id') as $key => $value) {

            $cek_cuti = Leave::where('user_id', $request->user_id[$key])
                ->whereYear('date', Carbon::now()->format('Y'))
                ->count();

            $cekShift = ShiftArchive::where('nik', $request->user_id[$key])
                ->select('shift')
                ->first();

            $date = $request->date_select[$key];

            $start_work = $request->start_work[$key];
            $end_work = $request->end_work[$key];

            if ($start_work == null && $end_work == null) {
                $sw = null;
                $ew = null;
            } elseif ($end_work == null) {
                $sw = Carbon::parse($start_work)->format('H:i:s');
                $ew = null;
            } else {
                $sw = Carbon::parse($start_work)->format('H:i:s');
                $ew = Carbon::parse($end_work)->format('H:i:s');
            }

            if ($sw == null && $ew == null) {
                $swW = null;
                $ewW = null;
            } elseif ($ew == null) {
                $swW = '' . $date . ' ' . $sw . '';
                $ewW = null;
            } else {
                $swW = '' . $date . ' ' . $sw . '';
                $ewW = '' . $date . ' ' . $ew . '';
            }

            $info = $request->input('info');
            $infoString = implode(',', $info);

            if ($info == null) {
                $infoGet = null;
            } else {
                $infoGet = $infoString;
            }

            if ($cek_cuti > 12 && $request->desc[$key] == 'I') {
                Alert::error('Gagal', 'Maaf izin tidak bisa karena jumlah cuti anda habis');
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

                    $date = $request->get('date_select')[$key];
                    $user_id = $request->get('user_id')[$key];

                    $Record = TestingAbsen::where('date', $date)
                        ->where('user_id', $user_id)
                        ->first();

                    if ($Record) {
                        $Record->start_work = $swW;
                        $Record->start_work_info = $request->get('start_work_info')[$key];
                        $Record->start_work_info_url = $data[$key];
                        $Record->end_work = $ewW;
                        $Record->end_work_info = $request->get('end_work_info')[$key];
                        $Record->end_work_info_url = $edata[$key];
                        $Record->desc = $request->get('desc')[$key];
                        $Record->hadir = 1;
                        $Record->shift = $cekShift;
                        $Record->info = $infoGet;
                        $Record->save();
                    }

                    $Record->user_id = $request->get('user_id')[$key];
                    $Record->date = $request->get('date_select')[$key];
                    $Record->start_work = $swW;
                    $Record->start_work_info = $request->get('start_work_info')[$key];
                    $Record->start_work_info_url = $data[$key];
                    $Record->end_work = $ewW;
                    $Record->end_work_info = $request->get('end_work_info')[$key];
                    $Record->end_work_info_url = $edata[$key];
                    $Record->desc = $request->get('desc')[$key];
                    $Record->hadir = 1;
                    $Record->shift = $cekShift;
                    $Record->info = $infoGet;
                    $Record->save();

                } else if ($request->hasfile('start_work_info_url') == true && $request->hasfile('end_work_info_url') == false) {
                    foreach ($request->file('start_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $data[] = $name;
                    }

                    $date = $request->get('date_select')[$key];
                    $user_id = $request->get('user_id')[$key];

                    $Record = TestingAbsen::where('date', $date)
                        ->where('user_id', $user_id)
                        ->first();

                    if ($Record) {
                        $Record->start_work = $swW;
                        $Record->start_work_info = $request->get('start_work_info')[$key];
                        $Record->start_work_info_url = $data[$key];
                        $Record->end_work = $ewW;
                        $Record->end_work_info = $request->get('end_work_info')[$key];
                        $Record->desc = $request->get('desc')[$key];
                        $Record->hadir = 1;
                        $Record->shift = $cekShift;
                        $Record->info = $infoGet;
                        $Record->save();
                    }

                } else if ($request->hasfile('start_work_info_url') == false && $request->hasfile('end_work_info_url') == true) {
                    foreach ($request->file('end_work_info_url') as $file) {
                        $name = $file->store('public/images');
                        $edata[] = $name;
                    }

                    $date = $request->get('date_select')[$key];
                    $user_id = $request->get('user_id')[$key];

                    $Record = TestingAbsen::where('date', $date)
                        ->where('user_id', $user_id)
                        ->first();

                    if ($Record) {
                        $Record->start_work = $swW;
                        $Record->start_work_info = $request->get('start_work_info')[$key];
                        $Record->end_work = $ewW;
                        $Record->end_work_info = $request->get('end_work_info')[$key];
                        $Record->end_work_info_url = $edata[$key];
                        $Record->desc = $request->get('desc')[$key];
                        $Record->hadir = 1;
                        $Record->shift = $cekShift;
                        $Record->info = $infoGet;
                        $Record->save();
                    }

                } else if ($request->hasfile('start_work_info_url') == false && $request->hasfile('end_work_info_url') == false) {

                    $date = $request->get('date_select')[$key];
                    $user_id = $request->get('user_id')[$key];

                    $Record = TestingAbsen::where('date', $date)
                        ->where('user_id', $user_id)
                        ->first();

                    if ($Record) {
                        $Record->start_work = $swW;
                        $Record->start_work_info = $request->get('start_work_info')[$key];
                        $Record->end_work = $ewW;
                        $Record->end_work_info = $request->get('end_work_info')[$key];
                        $Record->desc = $request->get('desc')[$key];
                        $Record->hadir = 1;
                        $Record->shift = $cekShift;
                        $Record->info = $infoGet;
                        $Record->save();
                    }

                }
                Alert::success('Berhasil', 'Data Absensi Tersimpan!!!');
            }
        }

        return Redirect::back();
    }
}

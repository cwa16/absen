<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\User;
use App\Models\Leave;

class AbsenController extends Controller
{
    public function index($id)
    {
        $date = Carbon::now()->format('Y-m-d');

        $absen = Absen::where('date', $date)->where('user_id', $id)->with('user:id,name,start_work_user,end_work_user')->get();
        return response([
            'absen' => $absen
        ], 200);
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $start_work = Carbon::now();
        $image = $this->saveImage($request->image, 'absens');

        $absen = Absen::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'date' => $date,
            ],
            [
                'start_work' => $start_work,
                'start_work_info' => $request->start_work_info,
                'start_work_info_url' => $image,
                'end_work' => null,
                'end_work_info' => 'n/a',
                'end_work_info_url' => 'n/a',
                'desc' => $request->desc,
                'link' => 'n/a'
            ]
        );

        return response([
            'absen' => $absen
        ], 200);
    }

    public function update($id)
    {
        $end_work = Carbon::now();
        $date = Carbon::now()->format('Y-M-d');


        $absen = Absen::where('id', $id)->update([
            'end_work' => $end_work,
        ]);

        return response([
            'absen' => $absen
        ], 200);
    }

    public function updateAbsen(Request $request, $id)
    {
        $end_work = Carbon::now();

        $image = $this->saveImage($request->image, 'absens');

        $absen = Absen::where('id', $id)->update([
            'end_work' => $end_work,
            'end_work_info' => $request->end_work_info,
            'end_work_info_url' => $image
        ]);

        return response([
            'absen' => $absen
        ], 200);
    }

    public function storeLeave(Request $request)
    {
        $date = Carbon::now();

        $leave = Leave::create([
            'user_id' => $request->user_id,
            'user_sub' => $request->user_sub,
            'date' => $date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'purpose' => $request->purpose
        ]);

        return response([
            'leave' => $leave
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MasterWorkHour;
use App\Models\User;
use App\Models\WorkHour;
use DB;
use Illuminate\Http\Request;
use Redirect;

class WorkHourController extends Controller
{
    public function index()
    {
        $workhour = WorkHour::get();
        $workhour_master = DB::table('workhour_master')->get();
        $dept = DB::table('users')->groupBy('users.dept')->get();

        return view('admin.pages.work-hour', ['workhour' => $workhour,
            'workhour_master' => $workhour_master,
            'dept' => $dept]);
    }

    public function store(Request $request)
    {
        $name = $request->name_work;
        $dept = $request->dept;
        $position = $request->position;
        $seninId = $request->senin;
        $selasaId = $request->selasa;
        $rabuId = $request->rabu;
        $kamisId = $request->kamis;
        $jumatId = $request->jumat;
        $sabtuId = $request->sabtu;

        $seninWh = DB::table('workhour_master')->where('id', $seninId)->first();
        $selasaWh = DB::table('workhour_master')->where('id', $selasaId)->first();
        $rabuWh = DB::table('workhour_master')->where('id', $rabuId)->first();
        $kamisWh = DB::table('workhour_master')->where('id', $kamisId)->first();
        $jumatWh = DB::table('workhour_master')->where('id', $jumatId)->first();
        $sabtuWh = DB::table('workhour_master')->where('id', $sabtuId)->first();

        $dataToUpdate = [
            'name' => $name,
            'start_work_senin' => ($seninWh) ? $seninWh->start_work : null,
            'end_work_senin' => ($seninWh) ? $seninWh->end_work : null,
            'start_work_selasa' => ($selasaWh) ? $selasaWh->start_work : null,
            'end_work_selasa' => ($selasaWh) ? $selasaWh->end_work : null,
            'start_work_rabu' => ($rabuWh) ? $rabuWh->start_work : null,
            'end_work_rabu' => ($rabuWh) ? $rabuWh->end_work : null,
            'start_work_kamis' => ($kamisWh) ? $kamisWh->start_work : null,
            'end_work_kamis' => ($kamisWh) ? $kamisWh->end_work : null,
            'start_work_jumat' => ($jumatWh) ? $jumatWh->start_work : null,
            'end_work_jumat' => ($jumatWh) ? $jumatWh->end_work : null,
            'start_work_sabtu' => ($sabtuWh) ? $sabtuWh->start_work : null,
            'end_work_sabtu' => ($sabtuWh) ? $sabtuWh->end_work : null,
            'group_in' => $position,
            'group_in_dept' => $dept,
        ];

        // Optionally filter out null values
        $dataToUpdate = array_filter($dataToUpdate, function ($value) {
            return $value !== null;
        });

        DB::beginTransaction();
        try {
            $data = WorkHour::updateOrCreate([
                'name' => $name,
            ],
            $dataToUpdate);

            $workhourId = $data->id;
            // Save to table relation
            $workhourUser = User::whereIn('dept', $request->dept)
                ->whereIn('jabatan', $request->position)
                ->update([
                    'work_hour_id' => $workhourId,
                ]);

            DB::commit();
            return Redirect::back();
        } catch (Exception $e) {
            DB::rollback();

            return Redirect::back();
        }
    }

    public function edit_hour($id)
    {
        $data = WorkHour::find($id);
        $workhour = DB::table('workhours')->get();
        $workhour_master = DB::table('workhour_master')->get();

        return view('admin.pages.work-hour-edit', ['data' => $data,
            'workhour' => $workhour,
            'workhour_master' => $workhour_master]);
    }

    public function delete($id)
    {
        WorkHour::where('id', $id)->delete();
        return Redirect::back();
    }

    public function index_set()
    {
        $dept = DB::table('users')->groupBy('users.dept')->get();
        $hour = DB::table('workhours')->get();

        $data = DB::table('users')
            ->select('users.*')
            ->groupBy('users.jabatan')
            ->get();

        return view('admin.pages.set-work-hour', ['dept' => $dept, 'hour' => $hour]);
    }

    public function set_workhour(Request $request)
    {
        $dept = $request->dept;
        $position = $request->position;
        $workHourId = $request->workhour;

        // $start_work_sk = MasterWorkHour

        $data = User::where('dept', $dept)
            ->where('jabatan', $position)->update([
            'work_hour_id' => $workHourId,
        ]);

        return Redirect::back();

    }

    public function select_dept(Request $request)
    {
        $jabatan = User::whereIn('dept', $request->dept)->groupBy('jabatan')->pluck('jabatan');
        return response()->json(['jabatan' => $jabatan]);
    }

    public function check(Request $request)
    {
        $dept = $request->dept;
        $jabatan = $request->position;

        $data = DB::table('users')
            ->select('users.*')
            ->where('users.dept', $dept)
            ->where('users.dept', $jabatan)
            ->first();

        $hour = DB::table('workhours')
            ->get();

        return view('admin.pages.set-work-hour', ['data' => $data, 'hour' => $hour]);
    }

    public function index_master()
    {
        $workhour = DB::table('workhour_master')->get();

        return view('admin.pages.master-work-hour', ['workhour' => $workhour]);
    }

    public function delete_master($id)
    {
        DB::table('workhour_master')->where('id', $id)->delete();

        return Redirect::back();
    }

    public function store_master(Request $request)
    {
        $start_work = $request->start_work;
        $end_work = $request->end_work;
        $ket = $request->ket;

        $data = MasterWorkHour::create([
            'start_work' => $start_work,
            'end_work' => $end_work,
            'ket' => $ket,
        ]);

        return Redirect::back();
    }

    public function index_workhour_setting()
    {
        $workhour = DB::table('workhours')->get();
        $workhour_master = DB::table('workhour_master')->get();

        return view('admin.pages.work-hour-setting', ['workhour' => $workhour,
            'workhour_master' => $workhour_master]);
    }

    public function store_workhour_setting(Request $request)
    {
        $workHourId = $request->workhourId;
        $workHourSkId = $request->start_work_sk;
        $workHourJId = $request->start_work_j;
        $workHourSId = $request->start_work_s;

        $start_work_sk = DB::table('workhour_master')->where('id', $workHourSkId)->first();
        $start_work_j = DB::table('workhour_master')->where('id', $workHourJId)->first();
        $start_work_s = DB::table('workhour_master')->where('id', $workHourSId)->first();

        if (!$start_work_sk && !$start_work_j && $start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_s' => $start_work_s->start_work,
                'end_work_s' => $start_work_s->end_work,
            ]);

            return Redirect::back();
        } else if ($start_work_sk && !$start_work_j && !$start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_sk' => $start_work_sk->start_work,
                'end_work_sk' => $start_work_sk->end_work,
            ]);

            return Redirect::back();
        } else if (!$start_work_sk && $start_work_j && !$start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_j' => $start_work_j->start_work,
                'end_work_j' => $start_work_j->end_work,
            ]);

            return Redirect::back();
        } else if ($start_work_sk && $start_work_j && !$start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_sk' => $start_work_sk->start_work,
                'end_work_sk' => $start_work_sk->end_work,
                'start_work_j' => $start_work_j->start_work,
                'end_work_j' => $start_work_j->end_work,
            ]);

            return Redirect::back();
        } else if ($start_work_sk && !$start_work_j && $start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_sk' => $start_work_sk->start_work,
                'end_work_sk' => $start_work_sk->end_work,
                'start_work_s' => $start_work_s->start_work,
                'end_work_s' => $start_work_s->end_work,
            ]);

            return Redirect::back();
        } else if (!$start_work_sk && $start_work_j && $start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_j' => $start_work_j->start_work,
                'end_work_j' => $start_work_j->end_work,
                'start_work_s' => $start_work_s->start_work,
                'end_work_s' => $start_work_s->end_work,
            ]);

            return Redirect::back();
        } else if (!$start_work_sk && !$start_work_j && !$start_work_s) {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_s' => null,
                'end_work_s' => null,
            ]);

            return Redirect::back();
        } else {
            $data = WorkHour::where('id', $workHourId)->update([
                'start_work_sk' => $start_work_sk->start_work,
                'end_work_sk' => $start_work_sk->end_work,
                'start_work_j' => $start_work_j->start_work,
                'end_work_j' => $start_work_j->end_work,
                'start_work_s' => $start_work_s->start_work,
                'end_work_s' => $start_work_s->end_work,
            ]);

            return Redirect::back();
        }

    }
}

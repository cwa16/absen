<?php

namespace App\Http\Controllers;

use App\Models\AbsenReg;
use App\Models\TestingAbsen;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Alert;

class MasterAbsenController extends Controller
{
    public function index()
    {
        $master_absen = DB::table('test_absen_regs')
            ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
            ->select('test_absen_regs.date', 'users.dept')
            ->whereNotNull('test_absen_regs.date')
            ->whereIn('test_absen_regs.desc', ['H', 'MX', 'M', 'L', 'D', 'TA', 'I', 'S', 'IX', 'SX'])
            ->groupBy('test_absen_regs.date', 'users.dept')
            ->orderBy('test_absen_regs.date', 'DESC')
            ->get();
        // dd($master_absen);
        return view('admin.pages.master-absen', ['master_absen' => $master_absen]);
    }

    public function view(Request $request)
    {
        $dept = $request->dept;
        $date = $request->date;

        $master_absen = DB::table('test_absen_regs')
            ->join('users', 'test_absen_regs.user_id', '=', 'users.nik')
            ->select('users.nik', 'users.name', 'users.dept', 'test_absen_regs.date', 'test_absen_regs.id',
                'test_absen_regs.start_work', 'test_absen_regs.end_work', 'test_absen_regs.desc', 'test_absen_regs.info')
            ->where('users.dept', $dept)
            ->where('test_absen_regs.date', $date)
            ->whereIn('test_absen_regs.desc', ['H', 'MX', 'M', 'L', 'D', 'I', 'S', 'IX', 'SX', 'TA'])
            ->get();

        $SXLists = DB::table('sxlists')->get();

        return view('admin.pages.master-absen-view', ['master_absen' => $master_absen, 'dept' => $dept, 'date' => $date, 'sxlists' => $SXLists]);
    }

    // public function view($date, $dept)
    // {

    //     $master_absen = DB::table('absen_regs')
    //                     ->join('users', 'absen_regs.user_id', '=', 'users.nik')
    //                     ->select('users.nik','users.name','users.dept', 'absen_regs.date', 'absen_regs.id',
    //                             'absen_regs.start_work', 'absen_regs.end_work', 'absen_regs.desc')
    //                     ->where('users.dept', $dept)
    //                     ->where('absen_regs.date', $date)
    //                     ->whereIn('absen_regs.desc', ['H','MX','M','L','D','E','I','S','IX','SX','NT'])
    //                     ->get();

    //     return view('admin.pages.master-absen-view', ['master_absen' => $master_absen, 'dept' => $dept, 'date'=> $date]);
    // }

    public function update(Request $request)
    {
        foreach ($request->input('idx') as $key => $value) {
            TestingAbsen::where('id', $request->idx[$key])
                ->update([
                    'desc' => $request->desc[$key],
                    'info' => $request->info[$key],
                    'start_work' => $request->start_work[$key],
                    'end_work' => $request->end_work[$key],
                ]);
        }
        Alert::success('Berhasil', 'Data Absensi Diupdate!!!');
        return redirect()->route('master-absen');
    }

    public function delete(Request $request)
    {
        $dept = $request->dept;
        $date = $request->date;

        $master_absen = DB::table('absen_regs')
            ->join('users', 'absen_regs.user_id', '=', 'users.nik')
            ->select('users.nik', 'users.name', 'users.dept', 'absen_regs.date',
                'absen_regs.start_work', 'absen_regs.end_work', 'absen_regs.desc')
            ->where('users.dept', $dept)
            ->where('absen_regs.date', $date)
            ->whereIn('absen_regs.desc', ['H', 'MX', 'M', 'L', 'D', 'E', 'I', 'S', 'IX', 'SX', 'NT'])
            ->delete();

        Alert::success('Berhasil', 'Data Absensi Dihapus!!!');
        return Redirect::back();
    }

    public function deleteItem($id)
    {
        DB::table('absen_regs')->where('id', $id)->delete();
        Alert::success('Berhasil', 'Data Absensi Dihapus!!!');
        return Redirect::back();
    }
}

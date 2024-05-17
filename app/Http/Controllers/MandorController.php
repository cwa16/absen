<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Leave;
use App\Models\LeaveBudget;
use App\Models\MandorTapper;
use App\Models\User;
use DataTables;
use PDF;
use Auth;
use Carbon\Carbon;
use Alert;
use DateTime;
use Redirect;
use App\Imports\MandorImport;
use Maatwebsite\Excel\Facades\Excel;

class MandorController extends Controller
{
    // Ini Diubah
    public function index()
    {
        $userDept = Auth::user()->dept;

        if ($userDept == 'HR Legal' || $userDept = 'BSKP') {
            $user = MandorTapper::get()->groupBy(function ($item) {
                return $item->user->name;
            });
        } else {
            $user = MandorTapper::whereRelation('user', 'dept', \Auth::user()->dept)->get()->groupBy(function ($item) {
                return $item->user->name;
            });
        }

        return view('admin.pages.mandor', ['user' => $user]);
    }

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('files', $nama_file);

        // import data
        Excel::import(new MandorImport, public_path('/files/' . $nama_file));

        // notifikasi dengan session
        Alert::success('Berhasil', 'Data Kemandoran Terimport');

        // alihkan halaman kembali
        return Redirect::back();
    }

    // Ini Diubah
    public function inputMandor(Request $request)
    {
        $userDept = Auth::user()->dept;

        if ($userDept == 'HR Legal' || $userDept = 'BSKP') {
            $user = MandorTapper::get()->groupBy(function ($item) {
                return $item->user->name;
            });
            $data = User::get();
        } else {
            $user = MandorTapper::whereRelation('user', 'dept', \Auth::user()->dept)->get()->groupBy(function ($item) {
                return $item->user->name;
            });
            $data = User::where('dept', \Auth::user()->dept)->get();
        }

        return view('admin.pages.input-mandor', [
            'user' => $user,
            'data' => $data
        ]);
    }

    public function storeMandor(Request $request)
    {
        $nik_mandor = $request->nik_mandor;
        $nik_reg = $request->nik_reg;

        $data = MandorTapper::create([
            'user_id' => $nik_mandor,
            'user_sub' => $nik_reg
        ]);

        Alert::success('Berhasil', 'Data Kemandoran Ditambahkan');

        return Redirect::back();
    }

    public function deleteMandor(Request $request)
    {
        $idx = $request->id_check;
        $idd = array_map('intval', explode(',', $idx));

        MandorTapper::whereIn('id', $idd)->delete();
        Alert::success('Berhasil', 'Data Kemandoran Dihapus');
        return Redirect::back();
    }

}

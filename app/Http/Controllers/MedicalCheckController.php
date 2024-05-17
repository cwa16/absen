<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MedicalCheckInput;
use App\Models\MedicalCheck;
use App\Models\User;
use DataTables;
use PDF;
use Auth;
use Carbon\Carbon;
use Alert;
use DateTime;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class MedicalCheckController extends Controller
{
    public function index()
    {
        $data = MedicalCheck::all();
        return view('admin.pages.medical', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = MedicalCheck::firstOrCreate([
            'date' => $request->date
        ],
        [
            'date' => $request->date
        ]);

        Alert::success('Berhasil', 'Tanggal Medical Tersimpan!!!');
        return Redirect::back();
    }

    public function add($id)
    {
        $data = MedicalCheck::findOrFail($id);
        $user = User::all();
        return view('admin.pages.medical-input', ['data' => $data, 'user' => $user]);
    }

    public function storeInput(Request $request)
    {
        foreach ($request->result as $key => $value) {
            MedicalCheckInput::create([
                'medical_id' => $request->id,
                'nik' => $request->nik[$key],
                'result' => $request->result[$key]
            ]);
        }

        Alert::success('Berhasil', 'Data Medical Tersimpan!!!');
        return Redirect::back();
    }

    public function view($id)
    {
        $data = MedicalCheckInput::where('medical_id', $id)->get();
        $dates = MedicalCheck::where('id', $id)->value('date');
        $date = Carbon::parse($dates)->format('d F Y');

        return view('admin.pages.medical-view', ['data' => $data, 'date' => $date]);
    }
}

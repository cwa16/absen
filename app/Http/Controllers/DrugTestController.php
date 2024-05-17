<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\DrugTestInput;
use App\Models\DrugTest;
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

class DrugTestController extends Controller
{
    public function index()
    {
        $data = DrugTest::all();
        return view('admin.pages.drug', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = DrugTest::firstOrCreate([
            'date' => $request->date
        ],
        [
            'date' => $request->date
        ]);

        Alert::success('Berhasil', 'Tanggal Tes Narkoba Tersimpan!!!');
        return Redirect::back();
    }

    public function indexAdd($id)
    {
        $data = DrugTest::findOrFail($id);
        $user = User::all();
        return view('admin.pages.drug-input', ['data' => $data, 'user' => $user]);
    }

    public function storeInput(Request $request)
    {
        foreach ($request->result as $key => $value) {
            DrugTestInput::create([
                'drug_id' => $request->id,
                'nik' => $request->nik[$key],
                'result' => $request->result[$key]
            ]);
        }

        Alert::success('Berhasil', 'Data Hasil Tes Narkoba Tersimpan!!!');
        return Redirect::back();
    }
}

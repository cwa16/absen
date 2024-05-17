<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Jabatan;

class MasterJabatanController extends Controller
{
    public function index()
    {
        $data = Jabatan::get();
        return view('admin.pages.master-jabatan', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $jabatan = $request->jabatan;
        $alias = $request->alias;

        Jabatan::create([
            'jabatan' => $jabatan,
            'alias' => $alias
        ]);

        return Redirect::back();
    }

    public function delete($id)
    {
        Jabatan::where('id', $id)->delete();

        return Redirect::back();
    }
}

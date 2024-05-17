<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\User;
use Redirect;
Use Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
      $user = User::whereIn('role_app', ['Admin','User','Inputer'])->get();

      return view('admin.pages.master-user', ['user' => $user]);
    }

    public function index_input()
    {
      $user = User::all();
      return view('admin.pages.master-user-input', ['user' => $user]);
    }

    public function store_user(Request $request)
    {
      $data = User::where('id', $request->id)->update([
        'role_app' => $request->role_app,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]);

      $alert = Alert::success('Berhasil', 'User Berhasil Ditambahkan!');

      $user = User::whereIn('role_app', ['Admin','User','Inputer'])->get();
      return view('admin.pages.master-user', ['user' => $user, 'alert' => $alert]);
    }


    public function update_user(Request $request)
    {
      $data = User::where('id', $request->id)->update([
        'role_app' => $request->role_app,
        'password' => Hash::make($request->password)
      ]);

      $alert = Alert::success('Berhasil', 'User Berhasil Diubah!');

      $user = User::whereIn('role_app', ['Admin','User','Inputer'])->get();
      return view('admin.pages.master-user', ['user' => $user, 'alert' => $alert]);
    }

    public function edit_user($id)
    {
      $user = User::findOrFail($id);
      return view('admin.pages.master-user-edit', ['user' => $user]);
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
      $nama_file = rand().$file->getClientOriginalName();
   
      // upload ke folder file_siswa di dalam folder public
      $file->move('files',$nama_file);
   
      // import data
      Excel::import(new UserImport, public_path('/files/'.$nama_file));
   
      // notifikasi dengan session
      Alert::success('Berhasil', 'User Terimport');
   
      // alihkan halaman kembali
      return Redirect::back();
    }
}

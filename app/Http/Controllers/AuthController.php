<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\User;
use Redirect;
use App\Exports\AbsenExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class AuthController extends Controller
{
  public function postLogin(Request $request)
  {
      $request->validate([
          'email' => 'required',
          'password' => 'required',
      ]);
 
      $credentials = $request->only('email', 'password');
      if (\Auth::attempt($credentials)) {
          return redirect()->intended('dashboard')
                      ->withSuccess('You have Successfully loggedin');
      }

      return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
  }
}

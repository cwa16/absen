<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
      if (\Auth::attempt(
        ['nik' => $request->nik,
         'password' => $request->password
        ])) {
        $user = \Auth::user();
        $token = $user->createToken('user')->accessToken;
        $data['user'] = $user;
        $data['token'] = $token;

        $dateNow = Carbon::now()->format('Y-m-d');
        $id = \Auth::user()->id;
        
        $update = User::where('id', $id)->update([
          'start_work_user' => ''.$dateNow. ' 08:00:00',
          'end_work_user' => ''.$dateNow.' 17:00:00',
          'access_by' => 'local'
        ]);

        return response()->json([
          'success' => true, 
          'data' => $data, 
          'pesan' => 'Login Berhasil'
        ], 200);
      } else {
        return response()->json([
          'success' => false, 
          'data' => '', 
          'pesan' => 'Login Gagal'
        ], 401);
      }
    }

    public function login_public(Request $request)
    {
      if (\Auth::attempt(
        ['nik' => $request->nik,
         'password' => $request->password
        ])) {
        $user = \Auth::user();
        $token = $user->createToken('user')->accessToken;
        $data['user'] = $user;
        $data['token'] = $token;

        $dateNow = Carbon::now()->format('Y-m-d');
        $id = \Auth::user()->id;
        
        $update = User::where('id', $id)->update([
          'start_work_user' => ''.$dateNow. ' 08:00:00',
          'end_work_user' => ''.$dateNow.' 17:00:00',
          'access_by' => 'public'
        ]);

        return response()->json([
          'success' => true, 
          'data' => $data, 
          'pesan' => 'Login Berhasil'
        ], 200);
      } else {
        return response()->json([
          'success' => false, 
          'data' => '', 
          'pesan' => 'Login Gagal'
        ], 401);
      }
    }

    // get user details
    public function user()
    {
      return response([
        'user' =>  auth()->user()
      ], 200);
    }

    // get now date
    public function dateNow()
    {
      $date = Carbon::now()->format('d M Y');
      return response([
        'date' => $date
      ], 200);
    }

    public function update_jam() {
      $dateNow = Carbon::now()->format('Y-m-d');
        $id = \Auth::user()->id;
        
        $update = User::where('id', $id)->update([
          'start_work_user' => ''.$dateNow. ' 08:00:00',
          'end_work_user' => ''.$dateNow.' 17:00:00',
          'access_by' => 'public'
        ]);

        return response([
          'data' => $update
        ], 200);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function chart_monthly()
    {
      $todayL = Carbon::now();
      $today = Carbon::parse($todayL)->format('Y-m-d');
      $res = User::groupBy('status')->with('absen')->get();

      return response()->json($res);
    }
}

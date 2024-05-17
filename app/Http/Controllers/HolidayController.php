<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Leave;
use App\Models\LeaveBudget;
use App\Models\AbsenReg;
use App\Models\TestingAbsen;
use App\Models\User;
use App\Models\Holiday;
use DataTables;
use PDF;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Alert;
use DateTime;
use Redirect;
use App\Imports\LeaveBudgetImport;
use Maatwebsite\Excel\Facades\Excel;

class HolidayController extends Controller
{
    public function indexAllDept()
    {
        $data = Holiday::orderBy('date', 'desc')->get();
        return view('admin.pages.holiday-all-dept', ['data' => $data]);
    }

    public function index()
    {
        // $dept = Auth::user()->dept;

        // $data = Holiday::where('dept', $dept)
        //     ->orderBy('date', 'desc')
        //     ->get();

        $data = Holiday::orderBy('date', 'desc')->get();
        return view('admin.pages.holiday', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $dates = $request->date;
        $info = $request->info;

        foreach ($dates as $key => $date) {
            $infoValue = $info[$key];

            Holiday::updateOrCreate(
                ['date' => $date],
                ['info' => $infoValue]
            );

            $allUserIds = User::pluck('nik')->toArray();

            $newDate = $date;
            $desc = 'MX';

            $chunks = array_chunk($allUserIds, 300);

            foreach ($chunks as $chunk) {
                foreach ($chunk as $userId) {
                    $existingData = TestingAbsen::where('user_id', $userId)
                        ->where('date', $newDate)
                        ->first();

                    if (!$existingData) {
                        TestingAbsen::updateOrCreate(
                            ['user_id' => $userId, 'date' => $newDate, 'info' => $infoValue],
                            ['desc' => $desc]
                        );
                    }
                }
            }
        }
        Alert::success('Berhasil', 'Data Hari Libur Tersimpan!!!');
        return Redirect::back();
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $holiday = Holiday::find($id);

        if ($holiday) {
            $dateMX = $holiday->date;

            $holiday->delete();

            TestingAbsen::where('date', $dateMX)
                ->where('desc', 'MX')
                ->delete();
        }

        return Redirect::back();
    }
}

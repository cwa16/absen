<?php

namespace App\Http\Controllers;

use App\Models\MasterShift;
use App\Models\ShiftArchive;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Alert;
use Auth;

class MasterShiftController extends Controller
{
    public function index(Request $request)
    {
        $data = User::where('dept', 'factory')->get()->groupBy(function ($item) {
            return $item->jabatan;
        });

        $masterShifts = MasterShift::all();
        return view('admin.pages.shift.master-shift-view', compact('data', 'masterShifts'));
    }

    public function index_detail(Request $request)
    {
        $data = User::where('dept', 'factory')->get()->groupBy(function ($item) {
            return $item->jabatan;
        });

        $masterShifts = MasterShift::all();
        return view('admin.pages.shift.detail-shift-view', compact('data', 'masterShifts'));
    }

    public function detail_emp_shift($nik)
    {
        $shiftArchiveDataEmp = ShiftArchive::where('nik', $nik)
            ->select('shift_archives.*', 'master_shifts.start_work', 'master_shifts.end_work')
            ->leftJoin('master_shifts', 'shift_archives.shift', '=', 'master_shifts.id')
            ->get();

        $emp = User::where('nik', $nik)->first();
        $masterShifts = MasterShift::all();

        return view('admin.pages.shift.detail-shift-emp-view', compact('shiftArchiveDataEmp', 'masterShifts', 'emp'));
    }

    public function detail()
    {
        $uniqueDates = ShiftArchive::selectRaw('DISTINCT DATE_FORMAT(start_date, "%Y-%m") as start_date')
            ->pluck('start_date');

        $monthsAndYears = [];
        foreach ($uniqueDates as $date) {
            $dateObj = Carbon::createFromFormat('Y-m', $date);
            $monthsAndYears[$dateObj->format('Y-m')] = $dateObj->format('F Y');
        }
        return view('admin.pages.shift.master-shift-detail', ['monthsAndYears' => $monthsAndYears]);
    }

    public function fact_detail()
    {
        $employeesInFactory = User::get();

        $uniqueStatus = $employeesInFactory->pluck('dept')->unique();

        return view('admin.pages.shift.master-emp-factory', ['uniqueStatus' => $uniqueStatus]);
    }

    public function filterData(Request $request)
    {
        $selectedMonth = $request->input('filterMonth');
        list($selectedYear, $selectedMonth) = explode('-', $selectedMonth);

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // $filteredData = ShiftArchive::whereBetween('date', [$startDate, $endDate])->get();
        $filteredData = ShiftArchive::whereBetween('start_date', [$startDate, $endDate])
            ->join('users', 'shift_archives.nik', '=', 'users.nik')
            ->join('master_shifts', 'shift_archives.shift', '=', 'master_shifts.id')
            ->select('shift_archives.*', 'users.*', 'master_shifts.start_work', 'master_shifts.end_work')
            ->get();

        $filteredData->transform(function ($item) {
            $item->start_work = Carbon::parse($item->start_work)->format('H:i:s');
            $item->end_work = Carbon::parse($item->end_work)->format('H:i:s');
            return $item;
        });

        $monthsAndYears = [];

        $uniqueDates = ShiftArchive::selectRaw('DISTINCT DATE_FORMAT(start_date, "%Y-%m") as start_date')
            ->pluck('start_date');

        foreach ($uniqueDates as $date) {
            $dateObj = Carbon::createFromFormat('Y-m', $date);
            $monthsAndYears[$dateObj->format('Y-m')] = $dateObj->format('F Y');
        }

        return view('admin.pages.shift.master-shift-detail', [
            'filteredData' => $filteredData,
            'selectedMonth' => $selectedMonth,
            'monthsAndYears' => $monthsAndYears,
        ]);
    }

    public function filterDataemp(Request $request)
    {
        $selectedStatus = $request->input('selected_status');

        $filteredData = User::where('dept', $selectedStatus)->where('status', $request->dept)
            ->get();

        $masterShifts = MasterShift::all();

        return view('admin.pages.shift.master-emp-factory', [
            'masterShifts' => $masterShifts,
            'filteredData' => $filteredData,
            'uniqueStatus' => User::distinct('dept')->pluck('dept')
        ]);
    }

    public function searchDataemp(Request $request)
    {
        $searchName = $request->input('search_name');

        $filteredData = User::where('name', 'LIKE', '%' . $searchName . '%')
            ->orWhere('nik', 'LIKE', '%' . $searchName . '%')
            ->limit(3)
            ->get();

        $masterShifts = MasterShift::all();

        return view('admin.pages.shift.master-emp-factory', [
            'masterShifts' => $masterShifts,
            'filteredData' => $filteredData,
            'uniqueStatus' => User::distinct('dept')->pluck('dept')
        ]);
    }

    public function selectPosition(Request $request)
    {
        $selectedStatus = $request->input('selected_status');
        $jabatan = User::where('dept', $selectedStatus)->groupBy('status')
            ->pluck('status');

        return response()->json($jabatan);
    }

    public function masterShift()
    {
        $masterShifts = MasterShift::all();
        return view('admin.pages.shift.master-shift', compact('masterShifts'));
    }

    public function masterShift_store(Request $request)
    {
        $validatedData = $request->validate([
            'shift' => 'required|unique:master_shifts',
            'start_work' => 'required',
            'end_work' => 'required',
        ]);

        if ($validatedData['start_work'] == $validatedData['end_work']) {
            return redirect()->back()->with('error', 'Start Work dan End Work harus berbeda.');
        }

        MasterShift::create($validatedData);

        Alert::success('Berhasil', 'Data Shift Tersimpan!!!');

        return redirect()->back();
    }

    public function masterShift_edit($id)
    {
        $shift = MasterShift::find($id);
        return view('admin.pages.shift.master-shift-edit', compact('shift'));
    }

    public function masterShift_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shift' => 'required|unique:master_shifts,shift,' . $id,
            'start_work' => 'required',
            'end_work' => 'required',
        ]);

        if ($validatedData['start_work'] == $validatedData['end_work']) {
            return redirect()->back()->with('error', 'Start Work dan End Work harus berbeda.');
        }

        MasterShift::where('id', $id)->update($validatedData);

        Alert::success('Berhasil', 'Data Shift Tersimpan!!!');

        return redirect()->route('shift-master');
    }

    public function masterShift_delete($id)
    {
        MasterShift::where('id', $id)->delete();
        Alert::success('Berhasil', 'Data Shift Tersimpan!!!');
        return redirect()->route('shift-master');
    }

    public function update(Request $request)
    {
        try {
            $selectedIds = $request->input('selected_ids');

            $request->validate([
                'selected_ids' => 'required|array',
                'selected_ids.*' => 'exists:users,nik',
            ]);

            $shiftData = $request->input('shift');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // dd($shiftData, $startDate, $endDate);

            foreach ($selectedIds as $nik) {
                $user = User::where('nik', $nik)->first();
                $shift = MasterShift::where('id', $shiftData)->first();

                if ($user && $shift) {
                    $existingData = ShiftArchive::where('nik', $user->nik)
                        ->where('start_date', $startDate)
                        ->where('end_date', $endDate)
                        ->first();

                    // dd($user->nik, $shiftData, $startDate, $endDate);

                    if (!$existingData) {
                        ShiftArchive::create([
                            'nik' => $user->nik,
                            'shift' => $shift->id,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                        ]);
                    } else {
                        ShiftArchive::where('nik', $user->nik)
                            ->where('start_date', $startDate)
                            ->where('end_date', $endDate)
                            ->update([
                                'shift' => $shift->id,
                            ]);
                    }
                }
            }

            Alert::success('Berhasil', 'Data Shift Tersimpan!!!');
            return redirect()->route('shift-dua');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data Shift Tidak Tersimpan!!!');
            return redirect()->route('shift-dua')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateDetail(Request $request)
    {
        try {
            $newShiftValue = $request->input('shift');
            $selectedIds = $request->input('selected_ids');

            $request->validate([
                'selected_ids' => 'required|array',
                'selected_ids.*' => 'exists:shift_archives,id',
            ]);

            foreach ($selectedIds as $id) {
                $dataToUpdate = ShiftArchive::findOrFail($id);

                // dd($newShiftValue);

                $dataToUpdate->update([
                    'shift' => $newShiftValue,
                ]);
            }

            Alert::success('Berhasil', 'Data Shift Tersimpan!!!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data Shift Tersimpan!!!');
            return redirect()->back();
        }
    }


    // public function update(Request $request)
    // {
    //     try {
    //         $nikData = $request->input('nik');
    //         $shiftData = $request->input('shift');
    //         $startDate = $request->input('start_date');
    //         $endDate = $request->input('end_date');

    //         // dd($startDate);

    //         $start = Carbon::createFromFormat('Y-m-d', $startDate);
    //         $end = Carbon::createFromFormat('Y-m-d', $endDate);

    //         $daterange = CarbonPeriod::create($start, $end);

    //         // dd($daterange);

    //         foreach ($nikData as $key => $nik) {
    //             $user = User::where('nik', $nik)->first();

    //             if ($user) {
    //                 foreach ($daterange as $date) {
    //                     $shiftValue = $date->isSaturday() ? 7 : $shiftData[$key];

    //                     ShiftArchive::create([
    //                         'nik' => $nik,
    //                         'shift' => $shiftValue,
    //                         'date' => $date->toDateString(),
    //                     ]);
    //                 }
    //             }
    //         }

    //         return redirect()->route('shift-dua')->with('success', 'Data Shift berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('shift-dua')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function search(Request $request)
    {
        $searchKeyword = $request->input('search_keyword');

        $data = User::where('dept', 'factory')
            ->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('jabatan', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('dept', 'like', '%' . $searchKeyword . '%');
            })
            ->paginate(10);

        $masterShifts = MasterShift::all();

        return view('admin.pages.shift.master-shift-view', compact('data', 'masterShifts'));
    }

    // Ini Diubah

    // Index Pengaturan Shift
    public function shift_setting()
    {
        $userDept = Auth::user()->dept;

        if ($userDept == 'Security') {
            $empWithShift = User::where('jabatan', 'Security')
                ->select('nik', 'name', 'status', 'dept', 'jabatan')
                ->get();
        } elseif ($userDept == 'Factory') {
            $empWithShift = User::where('jabatan', 'Worker WWTP')
                ->select('nik', 'name', 'status', 'dept', 'jabatan')
                ->get();
        } else {
            $empWithShift = User::where('jabatan', 'Security')
                ->orWhere('jabatan', 'Worker WWTP')
                ->select('nik', 'name', 'status', 'dept', 'jabatan')
                ->get();
        }

        return view('admin.pages.shift.shift-setting', compact('empWithShift'));
    }

    // Form Pengaturan Shift
    public function shift_setting_shift($nik)
    {
        $masterShifts = MasterShift::all();
        $dataEmp = User::where('nik', $nik)
            ->select('nik', 'name', 'dept')
            ->first();

        return view('admin.pages.shift.shift-setting-detail', [
            'masterShifts' => $masterShifts,
            'nik' => $nik,
            'dataEmp' => $dataEmp
        ]);
    }

    // Proses Penambahan Data Shift
    public function shift_setting_store(Request $request)
    {
        $nik = $request->nik;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $shift = $request->shift;

        $existingData = ShiftArchive::where('nik', $nik)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->where('shift', $shift)
            ->first();

        if (!$existingData) {
            ShiftArchive::create([
                'nik' => $nik,
                'shift' => $shift,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        } else {
            ShiftArchive::where('nik', $nik)
                ->where('start_date', $startDate)
                ->where('end_date', $endDate)
                ->update([
                    'shift' => $shift,
                ]);
        }

        Alert::success('Berhasil', 'Data Shift Tersimpan!!!');

        return redirect()->route('shift-setting');
    }

    public function shift_setting_edit($nik)
    {
        $dataShiftEmp = ShiftArchive::where('nik', $nik)
            ->select('id', 'nik', 'shift', 'start_date', 'end_date')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataEmp = User::where('nik', $nik)
            ->select('nik', 'name', 'dept')
            ->first();

        $masterShifts = MasterShift::all();

        return view('admin.pages.shift.shift-setting-edit', [
            'dataShiftEmp' => $dataShiftEmp,
            'masterShifts' => $masterShifts,
            'nik' => $nik,
            'dataEmp' => $dataEmp
        ]);
    }

    public function shift_setting_update(Request $request)
    {
        $id = $request->id;
        $shift = $request->shift;
        $nik = $request->nik;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $existingData = ShiftArchive::where('id', $id)
            ->where('nik', $nik)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->first();

        if ($existingData) {
            ShiftArchive::where('id', $id)
                ->where('nik', $nik)
                ->where('start_date', $startDate)
                ->where('end_date', $endDate)
                ->update([
                    'shift' => $shift,
                ]);
        }

        Alert::success('Berhasil', 'Data Shift Berhasil Diubah!!!');

        return redirect()->route('shift-setting');
    }

}

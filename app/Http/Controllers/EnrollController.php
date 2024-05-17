<?php

namespace App\Http\Controllers;

use DB;

class EnrollController extends Controller
{
    public function index()
    {
        $field = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->whereIn('status', ['Manager', 'Staff', 'Monthly', 'Regular'])
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->jabatan;
        });

        $field_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->whereIn('status', ['Manager', 'Staff', 'Monthly', 'Regular'])
            ->where('active', 'yes')
            ->groupBy('users.dept')
            ->orderBy('users.dept', 'ASC')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $field_sum_all = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->whereIn('status', ['Manager', 'Staff', 'Monthly', 'Regular'])
            ->where('active', 'yes')
            ->get();

        $dept = DB::table('users')
            ->select('users.dept')
            ->whereIn('status', ['Manager', 'Staff', 'Monthly', 'Regular'])
            ->where('active', 'yes')
            ->groupBy('users.dept')
            ->orderBy('users.dept', 'ASC')
            ->pluck('users.dept');

        $jabatan = DB::table('users')
            ->select('users.jabatan')
            ->whereIn('status', ['Manager', 'Staff', 'Monthly', 'Regular'])
            ->where('active', 'yes')
            ->groupBy('users.jabatan')
            ->orderBy('users.jabatan', 'ASC')
            ->pluck('users.jabatan');

        foreach ($jabatan as $key => $value) {
            $fields[] = $value;
        }

        $dept_array = $fields;
        $dept_json = json_encode($fields);
        $jabatan_string = str_replace(array('[', ']'), '', $dept_json);
        // dd($jabatan_string);

        return view('admin.pages.enroll-data', ['field' => $field, 'field_sum' => $field_sum, 'field_sum_all' => $field_sum_all, 'dept_array' => $dept_array, 'dept' => $dept, 'jabatan_string' => $jabatan_string]);
    }

    public function index_detail()
    {
        $sts = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->status;
        });

        $sts_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status')
            ->where('active', 'yes')
            ->count();

        $agama_users = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $dept_users = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $dept_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->status;
        });

        $agama_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->agama;
        });

        $sex_users = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama', 'users.sex')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $sex_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama', 'users.sex')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->sex;
        });

        $suku_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama', 'users.sex', 'users.suku')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->suku;
        });

        $suku_users = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama', 'users.sex', 'users.suku')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $gol_darah_users = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama', 'users.sex', 'users.suku', 'users.gol_darah')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $agama = DB::table('users')
            ->select('users.agama')
            ->groupBy('users.agama')
            ->orderBy('users.agama', 'ASC')
            ->pluck('users.agama');

        $dept = DB::table('users')
            ->select('users.dept')
            ->groupBy('users.dept')
            ->orderBy('users.dept', 'ASC')
            ->pluck('users.dept');

        $jabatan = DB::table('users')
            ->select('users.jabatan')
            ->groupBy('users.jabatan')
            ->where('active', 'yes')
            ->orderBy('users.jabatan', 'ASC')
            ->pluck('users.jabatan');

        $status = DB::table('users')
            ->select('users.status')
            ->groupBy('users.status')
            ->where('active', 'yes')
            ->pluck('users.status');

        $sex = DB::table('users')
            ->select('users.sex')
            ->groupBy('users.sex')
            ->where('active', 'yes')
            ->pluck('users.sex');

        $suku = DB::table('users')
            ->select('users.suku')
            ->groupBy('users.suku')
            ->where('active', 'yes')
            ->pluck('users.suku');

        $gol_darah = DB::table('users')
            ->select('users.gol_darah')
            ->groupBy('users.gol_darah')
            ->where('active', 'yes')
            ->pluck('users.gol_darah');

        foreach ($jabatan as $key => $value) {
            $fields[] = $value;
        }

        $dept_array = $fields;
        $dept_json = json_encode($fields);
        $jabatan_string = str_replace(array('[', ']'), '', $dept_json);
        // dd($jabatan_string);

        return view('admin.pages.enroll-data-detail', ['sts' => $sts,
            'dept_array' => $dept_array,
            'dept' => $dept,
            'jabatan_string' => $jabatan_string,
            'jabatan' => $jabatan,
            'agama' => $agama,
            'status' => $status,
            'agama_users' => $agama_users,
            'sex' => $sex,
            'sex_users' => $sex_users,
            'suku' => $suku,
            'suku_users' => $suku_users,
            'gol_darah' => $gol_darah,
            'gol_darah_users' => $gol_darah_users,
            'dept_users' => $dept_users,
            'sts_sum' => $sts_sum,
            'sex_sum' => $sex_sum,
            'agama_sum' => $agama_sum,
            'suku_sum' => $suku_sum,
            'dept_sum' => $dept_sum]);
    }

    public function index_contract()
    {
        $field = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->where('status', 'Contract BSKP')
            ->get()->groupBy(function ($item) {
            return $item->jabatan;
        });

        $field_fl = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('active', 'yes')
            ->where('status', 'Contract FL')
            ->get()->groupBy(function ($item) {
            return $item->jabatan;
        });

        $dept = DB::table('users')
            ->select('users.dept')
            ->groupBy('users.dept')
            ->orderBy('users.dept', 'ASC')
            ->pluck('users.dept');

        $jabatan = DB::table('users')
            ->select('users.jabatan')
            ->groupBy('users.jabatan')
            ->orderBy('users.jabatan', 'ASC')
            ->pluck('users.jabatan');

        foreach ($jabatan as $key => $value) {
            $fields[] = $value;
        }

        $dept_array = $fields;
        $dept_json = json_encode($fields);
        $jabatan_string = str_replace(array('[', ']'), '', $dept_json);

        $con_sum = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('status', 'Contract BSKP')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $con_sum_fl = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status', 'users.agama')
            ->groupBy('users.jabatan', 'users.dept', 'users.nik')
            ->where('status', 'Contract FL')
            ->where('active', 'yes')
            ->get()->groupBy(function ($item) {
            return $item->dept;
        });

        $total_con = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status')
            ->where('active', 'yes')
            ->where('status', 'Contract BSKP')
            ->count();

        $total_con_fl = DB::table('users')
            ->select('users.nik', 'users.name', 'users.jabatan', 'users.dept', 'users.status')
            ->where('active', 'yes')
            ->where('status', 'Contract FL')
            ->count();
        // dd($field);

        return view('admin.pages.enroll-data-contract', ['total_con' => $total_con,
                                                         'total_con_fl' => $total_con_fl,
                                                         'field' => $field,
                                                         'field_fl' => $field_fl,
                                                         'dept_array' => $dept_array,
                                                         'dept' => $dept,
                                                         'jabatan_string' => $jabatan_string,
                                                         'con_sum' => $con_sum,
                                                         'con_sum_fl' => $con_sum_fl]);
    }
}

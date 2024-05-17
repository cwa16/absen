<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class UserImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return User::firstOrCreate([
          'nik' => $row['NIK'],
        ],
        [
          'nik' => $row['NIK'],
          'name' => $row['Nama'],
          'status' => $row['Status'],
          'grade' => $row['Grade'],
          'dept' => $row['Divisi'],
          'jabatan' => $row['Jabatan'],
          'sex' => $row['Sex'],
          'ttl' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Ttl'])),
          'start' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Start'])),
          'pendidikan' => $row['Pendidikan'],
          'agama' => $row['Agama'],
          'no_ktp' => $row['No KTP'],
          'no_telpon' => $row['No HP'],
          'kis' => $row['KIS'],
          'kpj' => $row['KPJ'],
          'suku' => $row['Suku'],
          'no_sepatu_safety' => $row['No Sepatu'],
          'start_work_user' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Start Work'])),
          'end_work_user' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['End Work'])),
          'loc_kerja' => $row['Loc Kerja'],
          'loc' => $row['Loc'],
          'sistem_absensi' => $row['Sistem Absensi'],
          'latitude' => $row['Latitude'],
          'longitude' => $row['Longitude'],
          'status_pernikahan' => $row['Status Pernikahan'], 
          'istri_sumai' => $row['Istri Suami']
        ]);
    }
}

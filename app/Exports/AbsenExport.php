<?php

namespace App\Exports;
use App\Models\Absen;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      return DB::table('absens')
              ->leftJoin('users', 'users.id', '=', 'absens.user_id')
              ->select('users.name','absens.date','absens.start_work','absens.end_work')
              ->get();
    }
}

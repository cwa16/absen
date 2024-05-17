<?php

namespace App\Imports;

use App\Models\MandorTapper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class MandorImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return MandorTapper::create(
        [
          'user_id' => $row['NIK Mandor'],
          'user_sub' => $row['NIK Tapper']
        ]);
    }
}

<?php

namespace App\Imports;

use App\Models\AttTraining;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class AttTrainingImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AttTraining([
          'id_training' => $row['No'],
          'nik' => $row['NIK'],
          'score' => $row['Score'],
          'ket' => 'imported',
        ]);
    }
}

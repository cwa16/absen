<?php

namespace App\Imports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class JudulTrainingImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Training([
          'no' => $row['No'],
          'kind' => $row['Kind'],
          'id_data' => $row['No'],
          'topic' => $row['Topic'],
          'trainer' => $row['Trainer'],
          'from_date' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['From Date'])),
          'to_date' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['To Date'])),
          'place' => $row['Place'],
          'category' => $row['Category'],
          'summary' => '.',
          'comment' => 'imported',
        ]);
    }
}

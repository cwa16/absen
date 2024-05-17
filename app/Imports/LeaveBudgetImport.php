<?php

namespace App\Imports;

use App\Models\LeaveBudget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class LeaveBudgetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return LeaveBudget::updateOrCreate([
          'user_id' => $row['NIK'],
          
        ],
        [
          'user_id' => $row['NIK'],
          'date' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])),
          'large' => $row['Large'],
          'yearly' => $row['Yearly'],
          'birth' => $row['Birth'],
          'sick' => $row['Sick'],
          'other' => $row['Other'],
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmpOut extends Model
{
    use HasFactory;

    protected $table = 'table_emp_outs';

    protected $fillable = [
      'id',
      'nik',
      'no_approval',
      'start_work',
      'date_out',
      'work_period',
      'date_resign_approval',
      'date_out_document',
      'date_severance_pay',
      'total_day_process',
      'reason',
      'total_severance_pay',
      'remark',
  ];

  public function user()
  {
    return $this->belongsTo(User::class,'nik','nik');
  }

}

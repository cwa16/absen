<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkHistory extends Model
{
    use HasFactory;

    protected $table = 'table_work_histories';

    protected $fillable = [
      'id',
      'nik',
      'start',
      'end',
      'duration',
      'position',
      'grade',
      'status',
      'division',
      'remark',
  ];

  public function user()
  {
    return $this->belongsTo(User::class,'nik','nik');
  }

}

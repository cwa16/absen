<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkHour extends Model
{
    use HasFactory;

    protected $table = 'workhours';

    protected $casts = [
        'group_in' => 'array',
        'group_in_dept' => 'array',
    ];

    protected $fillable = [
        'name',
        'start_work_senin',
        'end_work_senin',
        'start_work_selasa',
        'end_work_selasa',
        'start_work_rabu',
        'end_work_rabu',
        'start_work_kamis',
        'end_work_kamis',
        'start_work_jumat',
        'end_work_jumat',
        'start_work_sabtu',
        'end_work_sabtu',
        'group_in',
        'group_in_dept',
  ];

}

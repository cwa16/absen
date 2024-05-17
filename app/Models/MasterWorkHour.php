<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MasterWorkHour extends Model
{
    use HasFactory;

    protected $table = 'workhour_master';

    protected $fillable = [
        'day',
        'start_work',
        'end_work',
        'ket',
  ];

}

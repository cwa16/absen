<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_code',
        'shift',
        'start_work',
        'end_work'
    ];

    protected $dates = ['start_work', 'end_work'];
}

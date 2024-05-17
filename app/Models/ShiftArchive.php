<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'shift',
        'start_date',
        'end_date',
    ];
}

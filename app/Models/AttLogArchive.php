<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttLogArchive extends Model
{
    use HasFactory;

    protected $table = 'att_log_archive';

    protected $fillable = [
        'id',
        'sn',
        'scan_date',
        'nik',
        'verifymode',
        'inoutmode',
        'device_ip'
    ];
}

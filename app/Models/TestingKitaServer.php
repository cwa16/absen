<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingKitaServer extends Model
{
    use HasFactory;

    protected $table = 'att_log';

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingArchive extends Model
{
    use HasFactory;

    protected $table = 'test_absen_regs_archive';

    protected $fillable = [
        'user_id',
        'date',
        'start_work',
        'start_work_info',
        'start_work_info_url',
        'end_work',
        'end_work_info',
        'end_work_info_url',
        'desc',
        'hadir',
        'shift',
        'info',
        'link',
        'checked',
        'checked_by',
        'approval',
        'approval_by',
        'created_at',
        'updated_at',
        'sn',
    ];

    protected $dates = [
        'start_work',
        'end_work',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'nik');
    }
}

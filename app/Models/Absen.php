<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'user_id',
      'date',
      'start_work',
      'start_work_info',
      'start_work_info_url',
      'end_work',
      'end_work_info',
      'end_work_info_url',
      'desc',
      'link',
      'checked',
      'checked_by',
      'approval',
      'approval_by'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

}

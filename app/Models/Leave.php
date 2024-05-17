<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'user_sub',
      'date',
      'kind',
      'start_date',
      'end_date',
      'return_date',
      'total',
      'balance',
      'col_date',
      'purpose',
    ];

    public function user()
    {
      return $this->belongsTo(User::class,'user_id','nik');
    }

    public function user_subs()
    {
      return $this->belongsTo(User::class,'user_sub','nik');
    }

    public function leave_budget()
    {
      return $this->belongsTo(LeaveBudget::class,'user_id','user_id');
    }

    public function mandor()
    {
      return $this->belongsTo(MandorTapper::class,'user_id','user_sub', 'user');
    }
}

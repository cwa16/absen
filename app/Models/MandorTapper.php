<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandorTapper extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'user_sub',
    ];

    public function user()
    {
      return $this->belongsTo(User::class,'user_id','nik');
    }

    public function user_subs()
    {
      return $this->belongsTo(User::class,'user_sub','nik');
    }

    public function absen_reg()
    {
      return $this->hasMany(AbsenReg::class, 'user_id', 'user_sub');
    }

    public function test_absen_reg()
    {
      return $this->hasMany(TestingAbsen::class, 'user_id', 'user_sub');
    }

    public function leave()
    {
      return $this->hasMany(Leave::class, 'user_id', 'user_sub');
    }

    public function leaveBudgets()
    {
      return $this->hasMany(LeaveBudget::class, 'user_id', 'user_sub');
    }
}

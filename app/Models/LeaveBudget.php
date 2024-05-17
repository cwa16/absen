<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBudget extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'date',
      'budget',
      'large',
      'yearly',
      'birth',
      'sick',
      'other'
    ];

    public function user()
  {
    return $this->belongsTo(User::class,'user_id','nik');
  }
}

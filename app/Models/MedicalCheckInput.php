<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCheckInput extends Model
{
    use HasFactory;

    protected $fillable = [
       'medical_id',
       'nik',
       'result'
      ];

      public function user()
      {
        return $this->belongsTo(User::class,'nik','nik');
      }

      public function medical()
      {
        return $this->belongsTo(MedicalCheck::class,'medical_id','id');
      }
}

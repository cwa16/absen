<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_training',
        'nik',
        'score',
        'ket'
    ];

    public function user()
    {
      return $this->belongsTo(User::class,'nik','nik');
    }

    public function training()
    {
      return $this->belongsTo(Training::class,'id_training','id_data');
    }
}

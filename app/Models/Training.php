<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'kind',
        'id_data',
        'topic',
        'trainer',
        'from_date',
        'to_date',
        'place',
        'category',
        'summary',
        'comment'
      ];

    // relation`
    public function user()
    {
      return $this->belongsTo(User::class,'trainer','nik');
    }

    public function attTrainings()
    {
      return $this->hasMany(AttTraining::class, 'id_training', 'id_data');
    }
}

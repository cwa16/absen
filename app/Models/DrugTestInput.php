<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugTestInput extends Model
{
    use HasFactory;
    protected $fillable = [
        'drug_id',
        'nik',
        'result'
       ];
 
       public function user()
       {
         return $this->belongsTo(User::class,'nik','nik');
       }
 
       public function drug()
       {
         return $this->belongsTo(DrugTest::class,'drug_id','id');
       }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SXList extends Model
{
    use HasFactory;

    protected $table = 'sxlists';

    protected $fillable = [
        'code',
        'name'
    ];
}

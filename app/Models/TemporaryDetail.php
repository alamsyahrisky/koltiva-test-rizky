<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryDetail extends Model
{
    use HasFactory;

    protected $table = 'temporary_detail';

    protected $fillable = [
        'age',
        'year',
        'result',
    ];
}

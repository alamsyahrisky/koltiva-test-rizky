<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryResult extends Model
{
    use HasFactory;

    protected $table = 'temporary_result';

    protected $fillable = [
        'avg',
    ];
}

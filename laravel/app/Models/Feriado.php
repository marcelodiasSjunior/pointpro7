<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feriado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'startDate',
        'endDate'
    ];

    protected $dates = [
        'startDate',
        'endDate',
    ];
}

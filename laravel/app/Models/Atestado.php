<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atestado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'path',
        'file',
        'media_type',
        'dateUpload',
        'startDate',
        'endDate',
    ];
}

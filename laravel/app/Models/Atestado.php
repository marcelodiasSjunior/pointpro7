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
        'funcionario_id',
        'company_id',
        'path',
        'file',
        'media_type',
        'dateUpload',
        'startDate',
        'endDate',
        'startTime',
        'endTime'
    ];

    protected $dates = [
        'startDate',
        'endDate',
        'dateUpload'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}

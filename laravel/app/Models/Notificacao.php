<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'company_id',
        'funcionario_id',
        'read',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

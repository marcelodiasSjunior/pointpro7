<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Observacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'atividade_id',
        'funcionario_id',
        'company_id',
        'message',
        'sender_id',
        'sender_type'
    ];


    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    protected function hora(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->timezone('America/Sao_Paulo')->format('H:i'),
        );
    }

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->timezone('America/Sao_Paulo')->format('d/n/Y'),
        );
    }

    protected function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }
}
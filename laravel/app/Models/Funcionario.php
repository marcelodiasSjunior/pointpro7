<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Funcionario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'jornada_id',
        'funcao_id',
        'nascimento',
        'admission_date',
        'celular',
        'cpf',
        'rg',
        'rg_emissor',
        'rg_emissao',
        'sexo',
        'nis',
        'nome_pai',
        'nome_mae',
        'titulo_eleitoral',
        'zona_eleitoral',
        'secao_eleitoral',
        'carteira_reservista',
        'serie_reservista',
        'telefone',
        'estado_civil',
        'grau_instrucao',
        'comorbidade',
        'cnh_numero',
        'cnh_categoria',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'state_id',
        'city_id',
        'workHome'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }

    public function jornada()
    {
        return $this->belongsTo(Jornada::class);
    }

    protected function cargaSemanal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->calcularCargaSemanal(),
        );
    }

    private function calcularCargaSemanal()
    {
        $carga_semanal = 0;
        $dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'];

        foreach ($dias as $dia) {
            if (isset($this->jornada->$dia)) {
                $horasParts = explode(':', $this->jornada->$dia);
                $horasEmNumeros = (int)$horasParts[0] + (int)$horasParts[1] / 60;
                if (isset($horasParts[2])) {
                    $horasEmNumeros += (int)$horasParts[2] / 3600;
                }
                $carga_semanal += $horasEmNumeros;
            }
        }
        return $carga_semanal;
    }

    public function atividades_count()
    {
        return $this->belongsTo(FuncionarioAtividade::class)->count();
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }

    public function frequencias_hoje()
    {
        return $this->hasMany(Frequencia::class)->whereDate('created_at', Carbon::now()->format('y-m-d'));
    }
}

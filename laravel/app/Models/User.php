<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    protected function company(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->companies() ? $this->companies()->first() : false,
        );
    }

    protected function companyId(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->companies() && $this->companies()->first() ? $this->companies()->first()->id : "",
        );
    }

    public function biometria_facial()
    {
        return $this->hasMany(BiometriaFacial::class);
    }

    public function funcionario()
    {
        return $this->HasOne(Funcionario::class);
    }
}

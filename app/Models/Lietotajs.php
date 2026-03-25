<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Lietotajs extends Authenticatable
{
    use Notifiable;

    protected $table = 'lietotaji';
    protected $primaryKey = 'ID';
    public $timestamps = false;

  protected $fillable = [
    'vards',
    'uzvards',
    'epasts',
    'email',
    'loma',
    'parole',
    'password',
    'aktivs',
];

    protected $hidden = [
        'parole',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->parole;
    }

    public function irApstiprinats(): bool
    {
        return (int)$this->aktivs === 1;
    }

    public function pieteikumi()
    {
        return $this->hasMany(PasakumuPieteikums::class, 'lietotajs_id', 'ID');
    }

    public function atsauksmes()
    {
        return $this->hasMany(PasakumuAtsauksme::class, 'lietotajs_id', 'ID');
    }
}
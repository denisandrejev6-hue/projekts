<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Lietotajs extends Authenticatable
{
    use Notifiable;

    protected $table = 'lietotaji';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'vards',
        'uzvards',
        'loma',
        'epasts',
        'parole',
        'registracijas_statuss',
        'apstiprinaja_id',
        'apstiprinats_at',
    ];

    protected $hidden = [
        'parole',
        'remember_token',
    ];

    public function getAuthPassword(): string
    {
        return $this->parole;
    }

    public function irApstiprinats(): bool
    {
        return $this->registracijas_statuss === 'Apstiprinats';
    }

    public function pieteikumi()
    {
        return $this->hasMany(PasakumuPieteikums::class, 'lietotajs_id', 'ID');
    }

    public function atsauksmes()
    {
        return $this->hasMany(PasakumuAtsauksme::class, 'lietotajs_id', 'ID');
    }

    public function apstiprinatajs()
    {
        return $this->belongsTo(self::class, 'apstiprinaja_id', 'ID');
    }
}
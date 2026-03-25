<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasakumuPieteikums extends Model
{
    protected $table = 'pasakumu_pieteikumi';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'pasakums_id',
        'lietotajs_id',
        'statuss',
        'pieteikts_at',
        'apmeklets_at',
    ];

    public function pasakums()
    {
        return $this->belongsTo(Pasakumi::class, 'pasakums_id', 'ID');
    }

    public function lietotajs()
    {
        return $this->belongsTo(Lietotajs::class, 'lietotajs_id', 'ID');
    }
}
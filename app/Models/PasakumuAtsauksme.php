<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasakumuAtsauksme extends Model
{
    protected $table = 'pasakumu_atsauksmes';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'pasakums_id',
        'lietotajs_id',
        'vertejums',
        'atsauksme',
        'izveidots_at',
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
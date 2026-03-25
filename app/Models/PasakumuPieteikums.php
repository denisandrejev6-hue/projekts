<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasakumi extends Model
{
    protected $table = 'pasakumi';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'nosaukums',
        'kategorija',
        'datums_no',
        'datums_lidz',
        'sakuma_laiks',
        'beigu_laiks',
        'apraksts',
        'darbinieks_id',
        'telpa_id',
        'registracijas_beigu_datums',
        'registracijas_beigu_laiks',
    ];

    public function images()
    {
        return $this->hasMany(PasakumiImage::class, 'pasakumi_id', 'ID');
    }

    public function telpa()
    {
        return $this->belongsTo(Telpa::class, 'telpa_id', 'ID');
    }

    public function darbinieks()
    {
        return $this->belongsTo(Lietotajs::class, 'darbinieks_id', 'ID');
    }

    public function pieteikumi()
    {
        return $this->hasMany(PasakumuPieteikums::class, 'pasakums_id', 'ID');
    }

    public function atsauksmes()
    {
        return $this->hasMany(PasakumuAtsauksme::class, 'pasakums_id', 'ID');
    }

    public function aktiviePieteikumi()
    {
        return $this->hasMany(PasakumuPieteikums::class, 'pasakums_id', 'ID')
            ->whereIn('statuss', ['Pieteikts', 'Apmeklets']);
    }
}
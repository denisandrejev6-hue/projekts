<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasakumi extends Model
{
    // table uses legacy schema from your PHP project
    protected $table = 'pasakumi';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false; // nav created_at/updated_at lauku

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nosaukums',
        'kategorija',
        'datums_no',
        'datums_lidz',
        'laiks_no',
        'laiks_lidz',
        'registracijas_beigu_datums',
        'registracijas_beigu_laiks',
        'apraksts',
        'darbinieks_id',
        'telpa_id',
    ];

    // relationships
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

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jaunumi extends Model
{
    protected $table = 'jaunumi';
    protected $fillable = [
        'virsraksts',
        'apraksts',
        'publicets_datums',
    ];

    // relationships
    public function images()
    {
        return $this->hasMany(JaunumiImage::class, 'jaunumi_id', 'id');
    }
}

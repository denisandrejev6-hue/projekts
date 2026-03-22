<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JaunumiImage extends Model
{
    protected $table = 'jaunumi_images';

    protected $fillable = [
        'jaunumi_id',
        'image_path',
    ];

    public function jaunumi()
    {
        return $this->belongsTo(Jaunumi::class, 'jaunumi_id', 'id');
    }
}

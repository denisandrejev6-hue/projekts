<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasakumiImage extends Model
{
    protected $table = 'pasakumi_images';

    protected $fillable = [
        'pasakumi_id',
        'image_path',
    ];

    public function pasakumi()
    {
        return $this->belongsTo(Pasakumi::class, 'pasakumi_id', 'ID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telpa extends Model
{
    // Modelis izmanto vēsturisko tabulas nosaukumu.
    protected $table = 'telpa';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nosaukums',
        'ietilpiba',
    ];
}

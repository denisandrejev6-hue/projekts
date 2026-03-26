<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    // Modelis izmanto esošo tabulas nosaukumu no datubāzes.
    protected $table = 'kategorijas';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nosaukums',
    ];
}

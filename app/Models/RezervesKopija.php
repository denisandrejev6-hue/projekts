<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RezervesKopija extends Model
{
    // Tabulas nosaukums tiek noteikts izpildes laikā, jo datubāzē var būt vairāki varianti.
    protected $table;
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'fails',
        'izveides_datums',
    ];

    /**
     * Atrod pareizo tabulas nosaukumu, izveidojot modeli.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Pārbauda iespējamos nosaukumus prioritārā secībā.
        $possible = ['rezerves_kopija', 'rezerveskopija', 'rezerveskopijas'];
        foreach ($possible as $name) {
            if (\Illuminate\Support\Facades\Schema::hasTable($name)) {
                $this->table = $name;
                break;
            }
        }

        // Ja tabula nav atrasta, izmanto pirmo variantu kā noklusējumu.
        $this->table ??= $possible[0];
    }
}

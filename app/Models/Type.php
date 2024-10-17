<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pokemon;

class Type extends Model
{
    protected $fillable = ['pokeid', 'name'];

    protected $table = 'types';

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_types', 'type_id', 'pokemon_id');
    }
}

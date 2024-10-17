<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pokemon;

class Move extends Model
{
    protected $fillable = ['pokeid', 'name', 'effect', 'pp', 'type'];

    protected $table ='moves';

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_moves', 'move_id', 'pokemon_id');
    }
}

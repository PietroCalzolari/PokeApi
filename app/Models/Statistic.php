<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['pokeid', 'name'];

    protected $table = 'statistics';

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_statistics', 'statistic_id', 'pokemon_id')->withPivot('value');
    }
}

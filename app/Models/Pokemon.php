<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\Move;
use App\Models\Statistic;

class Pokemon extends Model
{
    protected $fillable = ['pokeid', 'name', 'base_experience', 'height', 'weight'];

    protected $table = 'pokemons';

    public function types()
    {
        return $this->belongsToMany(Type::class, 'pokemon_types', 'pokemon_id', 'type_id');
    }

    public function moves()
    {
        return $this->belongsToMany(Move::class, 'pokemon_moves', 'pokemon_id', 'move_id');
    }

    public function statistics()
    {
        return $this->belongsToMany(Statistic::class, 'pokemon_statistics', 'pokemon_id', 'statistic_id')->withPivot('value');
    }
}

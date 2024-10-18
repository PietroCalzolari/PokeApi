<?php

namespace App\Http\Controllers;

use App\Http\Helpers\RequestHelper;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PokemonController extends Controller
{
    protected int $perPage = 10;

    public function setPerPage(Request $request)
    {
        if ($request->has('perPage') && (int) $request->input('perPage')) {
            $this->perPage = $request->input('perPage');
        }
        return;
    }

    /**
     * Display a listing of Pokemons.
     */
    public function index(Request $request)
    {
        $pokemons = Pokemon::query();

        RequestHelper::addFilter($request, $pokemons);
        $this->setPerPage($request);

        return $pokemons->paginate($this->perPage);
    }

    /**
     * Show the pokemon by id or name
     */
    public function show(Request $request, string $id)
    {
        $pokemon = Pokemon::where('id', $id)->orWhere('name', 'like', '%' . $id . '%');

        if ($pokemon) {
            RequestHelper::addFilter($request, $pokemon);

            return $pokemon->first();
        }

        return Response::json(['message' => 'Pokemon not found'], 404);
    }

    /**
     * Display the pokemon that has stats greater than $value
     */
    public function greaterThan(Request $request, int $value)
    {
        $pokemons = Pokemon::select('pokemons.id', 'pokemons.name') // Select specific columns
            ->join('pokemon_statistics', 'pokemons.id', '=', 'pokemon_statistics.pokemon_id')
            ->groupBy('pokemons.id', 'pokemons.name') // Group by all selected columns
            ->havingRaw('SUM(pokemon_statistics.value) > ?', [$value]);

        RequestHelper::addFilter($request, $pokemons);
        $this->setPerPage($request);

        return $pokemons->paginate($this->perPage);
    }

    /**
     * Display the pokemon that has stats less than $value
     */
    public function lessThan(Request $request, int $value)
    {
        $pokemons = Pokemon::select('pokemons.id', 'pokemons.name') // Select specific columns
            ->join('pokemon_statistics', 'pokemons.id', '=', 'pokemon_statistics.pokemon_id')
            ->groupBy('pokemons.id', 'pokemons.name') // Group by all selected columns
            ->havingRaw('SUM(pokemon_statistics.value) < ?', [$value]);

        RequestHelper::addFilter($request, $pokemons);
        $this->setPerPage($request);

        return $pokemons->paginate($this->perPage);
    }

    /**
     * Display the pokemon that has stats less than $value
     */
    public function movesGreaterThan(Request $request, int $value)
    {
        $pokemons = Pokemon::withCount('moves')
            ->having('moves_count', '>', $value);

        RequestHelper::addFilter($request, $pokemons);
        $this->setPerPage($request);

        return $pokemons->paginate($this->perPage);
    }

    /**
     * Display the pokemon that has stats less than $value
     */
    public function movesLessThan(Request $request, int $value)
    {
        $pokemons = Pokemon::withCount('moves')
            ->having('moves_count', '<', $value);

        RequestHelper::addFilter($request, $pokemons);
        $this->setPerPage($request);

        return $pokemons->paginate($this->perPage);
    }
}

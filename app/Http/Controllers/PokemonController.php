<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PokemonController extends Controller
{
    protected int $perPage;


    public function __construct()
    {
        $this->perPage = env('APP_PER_PAGE', 10);
    }


    /**
     * Display a listing of Pokemons.
     */
    public function index(Request $request)
    {
        $pokemons = Pokemon::query();

        if ($request->has('name'))
            $pokemons = Pokemon::where('name', 'like', '%' . $request->input('name') . '%');

        if ($request->has('perPage') && (int) $request->input('perPage'))
            $this->perPage = $request->input('perPage');

        if ($request->has('withMoves') && (int) $request->input('withMoves') == 1)
            $pokemons = $pokemons->with('moves');

        if ($request->has('withTypes') && (int) $request->input('withTypes') == 1)
            $pokemons = $pokemons->with('types');

        if ($request->has('withStats') && (int) $request->input('withStats') == 1)
            $pokemons = $pokemons->with('statistics');

        return $pokemons->paginate($this->perPage);
    }

    /**
     * Show the pokemon by id or name
     */
    public function show(Request $request, string $id)
    {
        $pokemon = Pokemon::where('id', $id)->orWhere('name', 'like', '%' . $id . '%');

        if ($pokemon) {
            if ($request->has('withMoves') && (int) $request->input('withMoves') == 1)
                $pokemon = $pokemon->with('moves');

            if ($request->has('withTypes') && (int) $request->input('withTypes') == 1)
                $pokemon = $pokemon->with('types');

            if ($request->has('withStats') && (int) $request->input('withStats') == 1)
                $pokemon = $pokemon->with('statistics');

            return $pokemon->first();
        }

        return Response::json(['message' => 'Pokemon not found'], 404);
    }
}

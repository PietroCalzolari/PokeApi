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

        return $pokemons->paginate($this->perPage);
    }

    /**
     * Show the pokemon by id or name
     */
    public function show(string $id)
    {
        $pokemon = Pokemon::find($id);
        if ($pokemon)
            return $pokemon;

        $pokemon = Pokemon::where('name', 'like', '%' . $id . '%')->first();
        if ($pokemon)
            return $pokemon;

        return Response::json(['message' => 'Pokemon not found'], 404);
    }
}

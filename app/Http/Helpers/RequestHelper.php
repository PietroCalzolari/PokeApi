<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;

class RequestHelper
{

    /**
     * Adds filters to a collection based on the request parameters.
     *
     * @param Request $request
     * @param $collection
     * @return mixed
     */
    static function addFilter(Request $request, $collection)
    {
        if ($request->has('name')) {
            $collection = $collection->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('withMove') && $request->input('withMove') === "true") {
            $collection = $collection->with('moves');
        }

        if ($request->has('withType') && $request->input('withType') === "true") {
            $collection = $collection->with('types');
        }

        if ($request->has('withStat') && $request->input('withStat') === "true") {
            $collection = $collection->with('statistics');
        }

        if ($request->has('withPokemon') && $request->input('withPokemon') === "true") {
            $collection = $collection->with('pokemons');
        }

        return $collection;
    }
}

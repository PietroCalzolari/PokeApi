<?php

namespace App\Http\Controllers;

use App\Http\Helpers\RequestHelper;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TypeController extends Controller
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
     * Display a listing of Pokemons' types.
     */
    public function index(Request $request)
    {
        $types = Type::query();

        RequestHelper::addFilter($request, $types);
        $this->setPerPage($request);

        return $types->paginate($this->perPage);
    }

    /**
     * Show the Pokemon's type retrieving the type from the id or the name.
     */
    public function show(Request $request, string $id)
    {
        $type = Type::where('id', $id)->orWhere('name', 'like', '%' . $id . '%');
        if ($type) {
            RequestHelper::addFilter($request, $type);

            return $type->first();
        }
        return Response::json(['message' => 'Pokemon\'s type not found'], 404);
    }
}

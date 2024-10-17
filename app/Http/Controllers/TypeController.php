<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TypeController extends Controller
{
    protected int $perPage;


    public function __construct()
    {
        $this->perPage = env('APP_PER_PAGE', 10);
    }

    /**
     * Display a listing of the stats.
     */
    public function index(Request $request)
    {
        $types = Type::query();

        if ($request->has('name'))
            $types = Type::where('name', 'like', '%' . $request->input('name') . '%');

        if ($request->has('perPage') && (int) $request->input('perPage'))
            $this->perPage = $request->input('perPage');

        return $types->paginate($this->perPage);
    }

    /**
     * Display the specified type by id or name.
     */
    public function show(string $id)
    {
        $type = Type::find($id);
        if ($type)
            return $type;

        $type = Type::where('name', 'like', '%' . $id . '%')->first();
        if ($type)
            return $type;
        return Response::json(['message' => 'Pokemon\'s type not found'], 404);
    }
}

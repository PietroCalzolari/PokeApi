<?php

namespace App\Http\Controllers;

use App\Models\Move;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MoveController extends Controller
{

    protected int $perPage;


    public function __construct()
    {
        $this->perPage = env('APP_PER_PAGE', 10);
    }

    /**
     * Display a listing of the moves.
     */
    public function index(Request $request)
    {
        $moves = Move::query();

        if ($request->has('name'))
            $moves = Move::where('name', 'like', '%' . $request->input('name') . '%');

        if ($request->has('perPage') && (int) $request->input('perPage'))
            $this->perPage = $request->input('perPage');

        return $moves->paginate($this->perPage);
    }

    /**
     * Display the move by id or name.
     */
    public function show(string $id)
    {
        $move = Move::find($id);
        if ($move)
            return $move;

        $move = Move::where('name', 'like', '%' . $id . '%')->first();
        if ($move)
            return $move;

        return Response::json(['message' => 'Pokemon\'s move not found'], 404);
    }
}

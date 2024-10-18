<?php

namespace App\Http\Controllers;

use App\Models\Move;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Helpers\RequestHelper;

class MoveController extends Controller
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
     * Display a listing of the moves.
     */
    public function index(Request $request)
    {
        $moves = Move::query();

        RequestHelper::addFilter($request, $moves);
        $this->setPerPage($request);

        return $moves->paginate($this->perPage);
    }

    /**
     * Display the move by id or name.
     */
    public function show(Request $request, string $id)
    {
        $move = Move::where('id', $id)->orWhere('name', 'like', '%' . $id . '%');
        if ($move) {
            RequestHelper::addFilter($request, $move);

            return $move->first();
        }

        return Response::json(['message' => 'Pokemon\'s move not found'], 404);
    }
}

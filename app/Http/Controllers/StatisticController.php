<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StatisticController extends Controller
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
        $stats = Statistic::query();

        // dd($stats);
        if ($request->has('name'))
            $stats = Statistic::where('name', 'like', '%' . $request->input('name') . '%');

        if ($request->has('perPage') && (int) $request->input('perPage'))
            $this->perPage = $request->input('perPage');

        return $stats->paginate($this->perPage);
    }

    /**
     * Display the specified stat by id or name.
     */
    public function show(string $id)
    {
        $stat = Statistic::find($id);
        if ($stat)
            return $stat;

        $stat = Statistic::where('name', 'like', '%' . $id . '%')->first();
        if ($stat)
            return $stat;
        return Response::json(['message' => 'Pokemon\'s statistic not found'], 404);
    }
}

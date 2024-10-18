<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Helpers\RequestHelper;

class StatisticController extends Controller
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
     * Display a listing of the stats.
     */
    public function index(Request $request)
    {
        $stats = Statistic::query();

        RequestHelper::addFilter($request, $stats);
        $this->setPerPage($request);

        return $stats->paginate($this->perPage);
    }

    /**
     * Show the Pokemon's statistic retrieving it from the id or the name
     */
    public function show(Request $request, string $id)
    {
        $stat = Statistic::where('id', $id)->orWhere('name', 'like', '%' . $id . '%');
        if ($stat) {
            RequestHelper::addFilter($request, $stat);
            return $stat->first();
        }
        return Response::json(['message' => 'Pokemon\'s statistic not found'], 404);
    }
}

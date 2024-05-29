<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stations\GetManyRequest;
use App\Models\Station;
use App\Http\Resources\StationCollection;

class StationController extends Controller
{
    public function index(GetManyRequest $request)
    {
        $q = $request->validated()['query'];

        $stations = Station::query()
            ->where('name', 'ilike', '%' . $q . '%')
            ->orWhereHas('city', function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->with('city')
            ->get();

        $stations = new StationCollection($stations);

        return response()->json($stations);
    }
}

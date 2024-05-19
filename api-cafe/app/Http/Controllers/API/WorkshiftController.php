<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkshiftCreateRequest;
use App\Http\Resources\WorkshiftResource;
use App\Models\Workshift;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WorkshiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkshiftCreateRequest $request)
    {
        if (request()->user()->role->name !== 'admin') {
            throw new AccessDeniedHttpException();
        };

        $data = $request->validated();
        $data['active'] = false;
        $workshift = Workshift::create($data);
        $workshift = new WorkshiftResource($workshift);

        return response()->json($workshift, 201);
    }

    public function open(Workshift $workshift)
    {
        if (request()->user()->role->name !== 'admin') {
            throw new AccessDeniedHttpException();
        };

        $open_shifts = Workshift::where('active', true)->get();

        if (any($open_shifts)) {
            throw new AccessDeniedHttpException('Forbidden. There are open shifts!');
        }

        $workshift->active = true;
        $workshift->save();

        return response()->json(new WorkshiftResource($workshift), 200);
    }

    public function close(Workshift $workshift)
    {
        if (request()->user()->role->name !== 'admin') {
            throw new AccessDeniedHttpException();
        };

        if (!$workshift->active) {
            throw new AccessDeniedHttpException('Forbidden. The shift is already closed!');
        }

        $workshift->active = true;
        $workshift->save();

        return response()->json(new WorkshiftResource($workshift), 200);
    }
}

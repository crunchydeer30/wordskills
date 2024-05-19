<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->user()->role->name !== 'admin') {
            throw new AccessDeniedHttpException();
        };

        $users = User::query()->with('role')->get();
        $users = new UserCollection($users);
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        if (request()->user()->role->name !== 'admin') {
            throw new AccessDeniedHttpException();
        };

        $data = $request->validated();
        $user = User::create(Arr::except($data, 'photo_file'));

        if (isset($data['photo_file'])) {
            $path = Storage::put('', $data['photo_file']);
            $user->update(['photo_file' => $path]);
            $user->save();
        }

        return response()->json([
            'data' => [
                'id' => $user->id,
                'status' => 'created'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

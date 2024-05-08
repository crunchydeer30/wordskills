<?php

namespace App\Http\Controllers\Api;

use App\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
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
    public function store(StorePhotoRequest $request)
    {
        $data = $request->validated();
        $photo = $data['photo'];
        $path = Storage::put('', $photo);

        $photo = Photo::create(
            [
                'path' => $path,
                'name' => 'Untitled',
                'owner_id' => $request->user()->id
            ]
        );

        $photo->accessed_by()->attach(
            $request->user()->id
        );
        $photo->save();

        return response()->json(new PhotoResource($photo), 201);
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

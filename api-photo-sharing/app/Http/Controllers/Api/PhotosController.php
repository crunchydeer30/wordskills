<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::query()->with('accessed_by')->whereHas('accessed_by', function ($query) {
            $query->where('user_id', request()->user()->id);
        })->get();

        return PhotoResource::collection($photos);
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

        return response()->json([
            'id' => $photo->id,
            'name' => $photo->name,
            'url' => request()->getSchemeAndHttpHost() . "/{$photo->id}"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        $photo->load('accessed_by');
        $photo = new PhotoResource($photo);
        return $photo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Photo $photo, UpdatePhotoRequest $request)
    {
        $data = $request->validated();

        if (isset($data['photo'])) {
            $imageData = explode(',', $data['photo'])[1];
            $decodedImage = base64_decode($imageData);
            Storage::delete($photo->path);
            Storage::put($photo->path, $decodedImage);
        }

        if (isset($data['name'])) {
            $photo->name = $data['name'];
        }

        $photo->save();
        return new PhotoResource($photo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);
        $photo->delete();
        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Helpers;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class FilesController extends Controller
{
    private int $MAX_FILE_SIZE = 2 * 1000 * 1000;
    private $ALLOWED_MIMES = [
        "application/msword",
        "application/pdf",
        "application/zip",
        "image/jpeg",
        "image/jpg",
        "image/png"
    ];

    public function store(Request $request): JsonResponse
    {
        $files = $request->allFiles();
        $res_data = [];

        foreach ($files as $file) {
            if ($file->getSize() > $this->MAX_FILE_SIZE || !in_array($file->getMimeType(), $this->ALLOWED_MIMES)) {
                $res_data[] = [
                    "success" => false,
                    "message" => "File not loaded",
                    "name" => $file->getClientOriginalName()
                ];
            } else {
                $name = Helpers::createUniqueFilename($file);
                Storage::put($name, $file->getContent());

                $new_file = File::create([
                    "name" => $name,
                    "user_id" => $request->user()->id
                ]);
                $new_file->accessed_by()->attach($request->user()->id);
                $new_file->save();

                $res_data[] = [
                    "success" => true,
                    "message" => "File loaded",
                    "url" => Helpers::getHostName($request) . "/" . $new_file->id,
                    "name" => $new_file->name
                ];
            }
        };

        return response()->json($res_data, 200);
    }

    public function update(UpdateFileRequest $request, File $file): JsonResponse
    {
        $data = $request->validated();

        if ($file->user_id !== $request->user()->id)
            throw new AccessDeniedHttpException();

        $file->update($data);

        return response()->json([
            "success" => true,
            "message" => "Renamed"
        ]);
    }

    public function destroy(Request $request, File $file): JsonResponse
    {
        if ($file->user_id !== $request->user()->id)
            throw new AccessDeniedHttpException();

        $file->delete();

        return response()->json([
            "success" => true,
            "message" => "File already deleted"
        ]);
    }
}

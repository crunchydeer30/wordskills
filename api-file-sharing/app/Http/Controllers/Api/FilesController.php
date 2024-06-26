<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Helpers;
use App\Http\Requests\GrantAccessRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\User;

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

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            "success" => true,
        ]);
    }

    public function show(Request $request, File $file)
    {
        if (!$file->accessed_by()->find($request->user()->id))
            throw new AccessDeniedHttpException();

        return Storage::download($file->name);
    }

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

    public function grantAccess(GrantAccessRequest $request, File $file): JsonResponse
    {
        $data = $request->validated();

        if ($file->user_id !== $request->user()->id)
            throw new AccessDeniedHttpException();

        $user_to_access = User::where('email', $data['email'])->first();
        $file->accessed_by()->syncWithoutDetaching($user_to_access->id);

        $users_with_access = $file->accessed_by()->get();
        $users_with_access = $users_with_access->map(
            fn ($user) =>
            [
                'fullname' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'type' => $file->user_id === $user->id ? 'author' : 'co-author'
            ]
        );

        return response()->json($users_with_access, 200);
    }

    public function revokeAccess(GrantAccessRequest $request, File $file): JsonResponse
    {
        $data = $request->validated();

        if ($file->user_id !== $request->user()->id)
            throw new AccessDeniedHttpException();

        if ($data['email'] === $request->user()->email)
            throw new AccessDeniedHttpException();

        $user_to_revoke_access = User::where('email', $data['email'])->first();

        $file->accessed_by()->detach($user_to_revoke_access->id);

        $users_with_access = $file->accessed_by()->get();
        $users_with_access = $users_with_access->map(
            fn ($user) =>
            [
                'fullname' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'type' => $file->user_id === $user->id ? 'author' : 'co-author'
            ]
        );

        return response()->json($users_with_access, 200);
    }

    public function disk(Request $request): JsonResponse
    {
        $files = File::query()->where('user_id', $request->user()->id)->with('accessed_by')->get();

        $files = $files->map(
            fn ($file) =>
            [
                'file_id' => $file->id,
                'name' => $file->name,
                'url' => Helpers::getHostName($request) . "/" . $file->id,
                'accesses' => $file->accessed_by->map(fn ($user) => [
                    'fullname' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'type' => $file->user_id === $user->id ? 'author' : 'co-author'
                ])
            ]
        );

        return response()->json($files, 200);
    }

    public function shared(Request $request): JsonResponse
    {
        $files = File::query()
            ->whereNot('user_id', $request->user()->id)
            ->whereHas('accessed_by', fn ($query) => $query->where('user_id', $request->user()->id))
            ->get();

        $files = $files->map(
            fn ($file) =>
            [
                'file_id' => $file->id,
                'name' => $file->name,
                'url' => Helpers::getHostName($request) . "/" . $file->id
            ]
        );

        return response()->json($files, 200);
    }
}

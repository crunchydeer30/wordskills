<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => request()->getSchemeAndHttpHost() . "/{$this->id}",
            'owner_id' => $this->owner_id,
            'users' => $this->accessed_by()->pluck('id')->toArray(),
        ];
    }
}

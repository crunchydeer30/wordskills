<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TripCollection extends ResourceCollection
{
    public $date;

    public function __construct($resource, $date)
    {
        parent::__construct($resource);
        $this->date = $date;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */


    public function toArray(Request $request)
    {
        return $this->collection->map(fn ($trip) => new TripResource($trip, $this->date))->toArray($request);
    }
}

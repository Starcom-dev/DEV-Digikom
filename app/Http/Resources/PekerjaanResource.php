<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PekerjaanResource extends JsonResource
{
    //define properti
public $status;
public $message;
public $resource;

public function __construct($status, $message, $resource)
{
    parent::__construct($resource);
    $this->status  = $status;
    $this->message = $message;
}

    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        if ($this->resource instanceof \Illuminate\Support\Collection || $this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        return [
            'success'   => $this->status,
            'message'   => $this->message,
            // 'data'      => $this->resource
            'data' => $this->resource->map(function ($pekerjaan) {
                return [
                    'id' => $pekerjaan->id,
                    'pekerjaan' => $pekerjaan->pekerjaan,
                    //'created_at' => $pekerjaan->created_at,
                ];
            }),
        ];
    } else {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->resource->id,
                'pekerjaan' => $this->resource->pekerjaan,
                //'created_at' => $this->resource->created_at,
            ],
        ];
    }
    }
}

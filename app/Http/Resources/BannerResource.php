<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'data' => $this->resource->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'gambar' => $banner->gambar 
                    ? url('storage/' . $banner->gambar) 
                    : null,
                    'created_at' => $banner->created_at,
                ];
            }),
        ];
    } else {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->resource->id,
                'gambar' => $this->resource->gambar 
                ? url('storage/' . $this->resource->gambar) 
                : null,
                'created_at' => $this->resource->created_at,
            ],
        ];
    }
    }
}

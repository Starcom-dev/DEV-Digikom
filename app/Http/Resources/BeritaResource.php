<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
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
            'data' => $this->resource->map(function ($berita) {
                return [
                    'id' => $berita->id,
                    'tittle' => $berita->tittle,
                    'banner' => $berita->banner 
                    ? url('storage/' . $berita->banner) 
                    : null,
                    'content' => $berita->content,
                    'created_by' => $berita->creator ? $berita->creator->full_name : null,
                    'created_at' => $berita->created_at,
                ];
            }),
        ];
    } else {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->resource->id,
                'tittle' => $this->resource->tittle,
                'banner' => $this->resource->banner 
                ? url('storage/' . $this->resource->banner) 
                : null,
                'content' => $this->resource->content,
                'created_by' => $this->resource->creator ? $this->resource->creator->full_name : null,
                'created_at' => $this->resource->created_at,
            ],
        ];
    }
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengurusResource extends JsonResource
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
            'data' => $this->resource->map(function ($pengurus) {
                return [
                    'id' => $pengurus->id,
                    'jabatan_pengurus' => $pengurus->jabatan ? $pengurus->jabatan->nama_jabatan : null,
                    'nama_pengurus' => $pengurus->user ? $pengurus->user->full_name : null,
                    'created_at' => $pengurus->created_at,
                ];
            }),
            // 'pagination' => [
            //     'current_page' => $this->resource->currentPage(),
            //     'last_page' => $this->resource->lastPage(),
            //     'per_page' => $this->resource->perPage(),
            //     'total' => $this->resource->total(),
            //     'links' => [
            //         'first' => $this->resource->url(1),
            //         'last' => $this->resource->url($this->resource->lastPage()),
            //         'next' => $this->resource->nextPageUrl(),
            //         'previous' => $this->resource->previousPageUrl(),
            //     ],
            // ],
        ];
    } else {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->resource->id,
                'jabatan_pengurus' => $this->resource->jabatan ? $this->resource->jabatan->nama_jabatan : null,
                'nama_pengurus' => $this->resource->user ? $this->resource->user->full_name : null,
                'created_at' => $this->resource->created_at,
            ],
        ];
    }
    }
}

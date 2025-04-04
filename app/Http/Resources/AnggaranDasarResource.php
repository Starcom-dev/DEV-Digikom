<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnggaranDasarResource extends JsonResource
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
            'Link'=> 'digikom.xyz/anggaranRumahTangga',
            // 'data'      => $this->resource
            'data' => $this->resource->map(function ($kegiatan) {
                return [
                    'id' => $kegiatan->id,
                    'judul_utama' => $kegiatan->judul_utama,
                    'sub_judul' => $kegiatan->sub_judul,
                    'deskripsi' => $kegiatan->deskripsi,
                    'created_by' => $kegiatan->creator ? $kegiatan->creator->full_name : null,
                    'created_at' => $kegiatan->created_at,
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
                'judul_utama' => $this->resource->judul_utama,
                'sub_judul' => $this->resource->sub_judul,
                'deskripsi' => $this->resource->deskripsi,
                'create_at' => $this->resource->create_at,
                'created_by' => $this->resource->creator ? $this->resource->creator->full_name : null,
            ],
        ];
    }
    }
}

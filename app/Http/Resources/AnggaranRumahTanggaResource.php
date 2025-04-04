<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnggaranRumahTanggaResource extends JsonResource
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
            'Link'      => 'digikom.xyz/anggaranRumahTangga',
            'data' => $this->resource->map(function ($anggaran) {
                return [
                    'id' => $anggaran->id,
                    'judul_utama' => $anggaran->judul_utama,
                    'sub_judul' => $anggaran->sub_judul,
                    'deskripsi' => $anggaran->deskripsi,
                    'created_by' => $anggaran->creator ? $anggaran->creator->full_name : null,
                    'created_at' => $anggaran->created_at,
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
                'created_at' => $this->resource->created_at,
                'created_by' => $this->resource->creator ? $this->resource->creator->full_name : null,
            ],
        ];
    }
    }
}

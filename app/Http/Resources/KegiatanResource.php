<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KegiatanResource extends JsonResource
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
            'data' => $this->resource->map(function ($kegiatan) {
                return [
                    'id' => $kegiatan->id,
                    'nama_kegiatan' => $kegiatan->nama_kegiatan,
                    'tanggal_kegiatan' => $kegiatan->tanggal_kegiatan,
                    'waktu_kegiatan' => $kegiatan->waktu_kegiatan,
                    'lokasi_kegiatan' => $kegiatan->lokasi_kegiatan,
                    'deskripsi_kegiatan' => $kegiatan->deskripsi_kegiatan,
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
                'nama_kegiatan' => $this->resource->nama_kegiatan,
                'tanggal_kegiatan' => $this->resource->tanggal_kegiatan,
                'waktu_kegiatan' => $this->resource->waktu_kegiatan,
                'lokasi_kegiatan' => $this->resource->lokasi_kegiatan,
                'deskripsi_kegiatan' => $this->resource->deskripsi_kegiatan,
                'created_by' => $this->resource->creator ? $this->resource->creator->full_name : null,
                'created_at' => $this->resource->created_at,
            ],
        ];
    }
    }
}

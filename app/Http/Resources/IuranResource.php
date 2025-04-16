<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IuranResource extends JsonResource
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
                'data' => $this->resource->map(function ($iuran) {
                    return [
                        'id' => $iuran->id,
                        'harga' => $iuran->harga,
                        'keterangan' => $iuran->keterangan,
                        'created_at' => $iuran->created_at,
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
                    'bulan' => $this->resource->bulan,
                    'jumlah' => $this->resource->jumlah,
                    'keterangan' => $this->resource->keterangan,
                    'created_at' => $this->resource->created_at,
                ],
            ];
        }
    }
}

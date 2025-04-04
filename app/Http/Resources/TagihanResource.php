<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagihanResource extends JsonResource
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
            'data' => $this->resource->map(function ($tagihan) {
                return [
                    'id' => $tagihan->id,
                    'bulan' => $tagihan->bulan,
                    'jumlah' => $tagihan->jumlah,
                    'status' => $tagihan->status,
                    'tanggal_bayar' => $tagihan->tanggal_bayar,
                    'nominal' => $tagihan->nominal,
                ];
            }),
        ];
    } else {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                    'id' => $this->resource->id,
                    'bulan' => $this->resource->bulan,
                    'jumlah' => $this->resource->jumlah,
                    'status' => $this->resource->status,
                    'tanggal_bayar' => $this->resource->tanggal_bayar,
                    'nominal' => $this->resource->nominal,
            ],
        ];
    }
    }
}

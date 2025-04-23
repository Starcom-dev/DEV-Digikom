<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryUsahaResource extends JsonResource
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
                'data' => $this->resource->map(function ($categoryUsaha) {
                    return [
                        'id' => $categoryUsaha->id,
                        'nama' => $categoryUsaha->nama,
                    ];
                }),
            ];
        } else {
            return [
                'success' => $this->status,
                'message' => $this->message,
                'data' => [
                    'id' => $this->resource->id,
                    'nama' => $this->resource->nama,
                ],
            ];
        }
    }
}

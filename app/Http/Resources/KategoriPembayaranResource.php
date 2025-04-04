<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KategoriPembayaranResource extends JsonResource
{
    // Define properties for status, message, and resource
    public $status;
    public $message;
    public $resource;

    // Constructor to set the status, message, and resource
    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }

    // Convert the resource to an array format for the response
    public function toArray(Request $request): array
    {
        // Check if the resource is a collection or a single record
        if ($this->resource instanceof \Illuminate\Support\Collection || $this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return [
                'success'   => $this->status,
                'message'   => $this->message,
                'data' => $this->resource->map(function ($kategoriBayar) {
                    return [
                        'id' => $kategoriBayar->id,
                        'kategori' => $kategoriBayar->kategori,
                        'icon' => $kategoriBayar->icon,
                    ];
                }),
            ];
        } else {
            return [
                'success' => $this->status,
                'message' => $this->message,
                'data' => [
                    'id' => $this->id,
                    'kategori' => $this->kategori,
                    'icon' => $this->icon,
                ]
            ];
        }
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpsiBayarResource extends JsonResource
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
                'data' => $this->resource->map(function ($opsiBayar) {
                    return [
                        'id' => $opsiBayar->id,
                        'opsi_bayar' => $opsiBayar->opsi_bayar,
                        'kode' => $opsiBayar->kode,
                        'status' => $opsiBayar->status,
                        'biaya_tetap' => $opsiBayar->biaya_tetap,
                        'biaya_persentase' => $opsiBayar->biaya_persentase,
                        'ppn' => $opsiBayar->ppn,
                        'deskripsi' => $opsiBayar->deskripsi,
                        'icon' => $opsiBayar->icon,
                        'kategori' => $opsiBayar->kategori ? $opsiBayar->kategori->kategori : null, // Include the category name
                        'created_at' => $opsiBayar->created_at,
                    ];
                }),
            ];
        } else {
            return [
                'success' => $this->status,
                'message' => $this->message,
                'data' => [
                    'id' => $this->resource->id,
                    'opsi_bayar' => $this->resource->opsi_bayar,
                    'kode' => $this->resource->kode,
                    'status' => $this->resource->status,
                    'biaya_tetap' => $this->resource->biaya_tetap,
                    'biaya_persentase' => $this->resource->biaya_persentase,
                    'ppn' => $this->resource->ppn,
                    'deskripsi' => $this->resource->deskripsi,
                    'icon' => $this->resource->icon,
                    'kategori' => $this->resource->kategori ? $this->resource->kategori->kategori : null, // Include the category name
                    'created_at' => $this->resource->created_at,
                ],
            ];
        }
    }
}

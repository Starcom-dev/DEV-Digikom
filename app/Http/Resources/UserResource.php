<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PekerjaanResource;
use App\Http\Resources\PendidikanResource;
use App\Http\Resources\AgamaResource;


class UserResource extends JsonResource
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
        return [
            'success'   => $this->status,
            'message'   => $this->message,
            'data' => [
                'id' => $this->resource->id,
                // 'nama_usaha' => $this->resource->nama_usaha ? $this->resource->nama_usaha : '-',
                'full_name' => $this->resource->full_name,
                'email' => $this->resource->email,
                'profile_picture' => $this->resource->profile_picture
                    ? url('storage/' . $this->resource->profile_picture)
                    : null,
                'phone_number' => $this->resource->phone_number,
                'nama_jabatan' => $this->resource->creator ? $this->resource->creator->nama_jabatan : 'Anggota',
                'nomor_ktp' => $this->resource->nomor_ktp ? $this->resource->nomor_ktp : '-',
                'ktp_picture' => $this->resource->ktp_picture ? url('storage/' .  $this->resource->ktp_picture) : null,
                'tanggal_lahir' => $this->resource->tanggal_lahir ? $this->resource->tanggal_lahir : '-',
                'tempat_lahir' => $this->resource->tempat_lahir ? $this->resource->tempat_lahir : '-',
                'alamat' => $this->resource->alamat ? $this->resource->alamat : '-',
                'pekerjaan' => $this->resource->pekerjaan ? $this->resource->pekerjaan : '-',
              	//'pekerjaan' => $this->resource->pekerjaan ? new PekerjaanResource($this->resource->pekerjaan) : null,
                'agama' => $this->resource->agama ? $this->resource->agama : '-',
                'pendidikan' => $this->resource->pendidikan ? $this->resource->pendidikan : '-',
                'updated_at' => $this->resource->updated_at,
                'created_at' => $this->resource->created_at,
            ],
        ];
    }
}

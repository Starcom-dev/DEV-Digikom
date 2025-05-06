<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'tentang_organisasi',
        'peraturan_organisasi',
        'anggaran_dasar',
        'anggaran_rumah_tangga',
        'privacy',
        'syarat_ketentuan_aplikasi'
    ];
}

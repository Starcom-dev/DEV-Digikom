<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiBayar extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'id_kategori',
        'opsi_bayar',
        'kode',
        'status',
        'biaya_tetap',
        'biaya_persentase',
        'ppn',
        'deskripsi',
        'icon'
    ];

    /**
     * Relationship with the Kategori model.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriPembayaran::class, 'id_kategori');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'metode_pembayaran', 'kode');
    }
}

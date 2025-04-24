<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usaha extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['nama_usaha', 'waktu_operational', 'lokasi_usaha', 'nomor_usaha', 'deskripsi', 'user_id', 'image_usaha', 'bidang', 'category'];
    protected $casts = [
        'created_at' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bidangUsaha()
    {
        return $this->belongsTo(BidangUsaha::class, 'bidang');
    }

    public function categoryUsaha()
    {
        return $this->belongsTo(CategoryUsaha::class, 'category');
    }
}

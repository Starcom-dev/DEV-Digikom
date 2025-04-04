<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [  'user_id', // Assuming you want to assign user_id
    'tagihan_id', // Add tagihan_id to fillable
    'opsi_id',
    'jumlah',
    'tanggal_pembayaran',
    'status_pembayaran',];
    protected $casts = [
        'tanggal_pembayaran' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
    public function opsi()
    {
        return $this->belongsTo(OpsiBayar::class, 'opsi_id');

    }
}
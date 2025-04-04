<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'transactions';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'tagihan_id',
        'status_transaction',
        'created_at',
        'updated_at',
    ];

    /**
     * Relasi ke model User
     * Setiap transaksi terkait dengan satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Tagihan
     * Setiap transaksi terkait dengan satu tagihan
     */
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}

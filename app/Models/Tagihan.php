<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['user_id', 'iuran_id', 'status', 'tanggal_bayar', 'nominal', 'metode_pembayaran', 'created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
        'updated_at' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function iuran()
    {
        return $this->belongsTo(Iuran::class, 'iuran_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'tagihan_id', 'id');
    }

}


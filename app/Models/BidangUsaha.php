<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangUsaha extends Model
{
    use HasFactory;
    public $timestamps = true;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['nama'];
    protected $casts = [
        'created_at' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
    ];

    public function usaha()
    {
        return $this->hasMany(Usaha::class, 'bidang');
    }
}

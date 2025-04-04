<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['tahun', 'jumlah', 'keterangan', 'tempo', 'created_by'];
    protected $casts = [
        'created_at' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
        'tempo' => 'datetime',
    ];
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'iuran_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}


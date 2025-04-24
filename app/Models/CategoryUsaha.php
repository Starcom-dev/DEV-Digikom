<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUsaha extends Model
{
    use HasFactory;
    public $timestamps = false;
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
        return $this->hasMany(Usaha::class, 'category');
    }
}

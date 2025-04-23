<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeraturanOrganisasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['judul', 'sub_judul', 'deskripsi', 'created_by', 'text_editor'];
    protected $casts = [
        'created_at' => 'datetime', // Pastikan tanggal dikonversi ke objek Carbon
    ];
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}

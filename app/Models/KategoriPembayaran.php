<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembayaran extends Model
{
    use HasFactory;
    
    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'kategori',
        'icon',
    ];
    
    /**
     * Relationship with the OpsiBayar model.
     */
    public function opsiBayars()
    {
        return $this->hasMany(OpsiBayar::class, 'id_kategori');
    }
}

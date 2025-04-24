<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'profile_picture',
        'phone_number',
        'jabatan_id',
        'nomor_ktp',
        'ktp_picture',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'pekerjaan_id',
        'agama_id',
        'pendidikan_id',
        'status',
        'membership_start',
        'membership_end',
        'is_membership',
        'nama_referensi_pengurus',
        'jabatan_referensi_pengurus',
        'phone_number_referensi_pengurus',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function creator()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
    // public function usaha()
    // {
    //     return $this->belongsTo(Usaha::class, 'usaha_id');
    // }
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id');
    }
    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'tagihan_id', 'id');
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

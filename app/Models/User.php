<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nik',
        'username',
        'password',
        'foto',
        'tanggal_lahir',
        'nomor_anggota',
        'pendidikan',
        'npwp',
        'periode',
        'role',
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
            'password' => 'hashed',
        ];
    }
    
    /**
     * Mendapatkan kelas di mana user ini menjadi wali kelas.
     */
    public function kelasWali(): HasOne
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }

    /**
     * Mendapatkan pembayaran yang dicatat oleh user ini.
     */
    public function pembayaranDicatat(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Memeriksa apakah pengguna memiliki peran tertentu.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role === $roleName;
    }
}
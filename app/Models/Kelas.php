<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $guarded = [];

    /**
     * Mendapatkan guru (user) yang menjadi wali kelas.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Mendapatkan semua siswa di kelas ini.
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;
    
    protected $table = 'absensis';
    protected $guarded = [];

    /**
     * Mendapatkan siswa yang memiliki absensi ini.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
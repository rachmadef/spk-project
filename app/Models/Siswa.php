<?php

namespace App\Models;

use Database\Factories\SiswaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    /** @use HasFactory<SiswaFactory> */
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama',
        'kelas',
        'jenis_kelamin',
    ];

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }
}

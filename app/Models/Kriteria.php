<?php

namespace App\Models;

use Database\Factories\KriteriaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    /** @use HasFactory<KriteriaFactory> */
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_kriteria',
        'bobot',
        'jenis',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'bobot' => 'decimal:2',
        ];
    }

    public function nilaiSiswas(): HasMany
    {
        return $this->hasMany(NilaiSiswa::class);
    }
}

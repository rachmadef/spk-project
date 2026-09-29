<?php

namespace App\Models;

use Database\Factories\PenilaianFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penilaian extends Model
{
    /** @use HasFactory<PenilaianFactory> */
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran',
        'semester',
        'nilai_v',
        'rank',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'nilai_v' => 'decimal:4',
            'rank' => 'integer',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nilaiSiswas(): HasMany
    {
        return $this->hasMany(NilaiSiswa::class);
    }

    public function getPredikatAttribute(): string
    {
        if ($this->nilai_v === null) {
            return '-';
        }

        $v = (float) $this->nilai_v;

        return match (true) {
            $v >= 0.90 => 'Sangat Baik',
            $v >= 0.80 => 'Baik',
            $v >= 0.70 => 'Cukup',
            default => 'Perlu Pembinaan',
        };
    }
}

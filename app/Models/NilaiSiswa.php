<?php

namespace App\Models;

use Database\Factories\NilaiSiswaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiSiswa extends Model
{
    /** @use HasFactory<NilaiSiswaFactory> */
    use HasFactory;

    protected $fillable = [
        'penilaian_id',
        'kriteria_id',
        'nilai_angka',
    ];

    protected function casts(): array
    {
        return [
            'nilai_angka' => 'float',
        ];
    }

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}

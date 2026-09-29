<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            [
                'kode' => 'C1',
                'nama_kriteria' => 'Nilai Rata-rata Akademik',
                'bobot' => 0.40,
                'jenis' => 'benefit',
                'deskripsi' => 'Rata-rata nilai rapor mata pelajaran utama',
            ],
            [
                'kode' => 'C2',
                'nama_kriteria' => 'Sikap & Perilaku',
                'bobot' => 0.30,
                'jenis' => 'benefit',
                'deskripsi' => 'Karakter, etika, dan catatan kedisiplinan kelas (Skala 1-4)',
            ],
            [
                'kode' => 'C3',
                'nama_kriteria' => 'Keaktifan Ekstrakurikuler',
                'bobot' => 0.20,
                'jenis' => 'benefit',
                'deskripsi' => 'Partisipasi dalam kegiatan ekstrakurikuler (Skala 1-4)',
            ],
            [
                'kode' => 'C4',
                'nama_kriteria' => 'Ketidakhadiran (Alpha)',
                'bobot' => 0.10,
                'jenis' => 'cost',
                'deskripsi' => 'Akumulasi jumlah ketidakhadiran tanpa keterangan (hari)',
            ],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::updateOrCreate(['kode' => $kriteria['kode']], $kriteria);
        }
    }
}

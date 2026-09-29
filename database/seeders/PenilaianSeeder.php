<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = Kriteria::pluck('id', 'kode');
        $waliKelas = User::where('email', 'walikelas@sdnjarak2.sch.id')->first();

        $sampleData = [
            '0012345671' => ['C1' => 85, 'C2' => 3, 'C3' => 4, 'C4' => 2],
            '0012345672' => ['C1' => 92, 'C2' => 4, 'C3' => 2, 'C4' => 0],
            '0012345673' => ['C1' => 78, 'C2' => 4, 'C3' => 3, 'C4' => 1],
        ];

        foreach ($sampleData as $nisn => $nilaiKriteria) {
            $siswa = Siswa::where('nisn', $nisn)->first();

            if ($siswa) {
                $penilaian = Penilaian::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'tahun_ajaran' => '2025/2026',
                        'semester' => 'genap',
                    ],
                    [
                        'user_id' => $waliKelas?->id,
                    ]
                );

                foreach ($nilaiKriteria as $kode => $nilai) {
                    if (isset($kriterias[$kode])) {
                        NilaiSiswa::updateOrCreate(
                            [
                                'penilaian_id' => $penilaian->id,
                                'kriteria_id' => $kriterias[$kode],
                            ],
                            [
                                'nilai_angka' => $nilai,
                            ]
                        );
                    }
                }
            }
        }
    }
}

<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SawService
{
    /**
     * Calculate SAW for a given kelas, tahunAjaran, and semester.
     *
     * @return array{
     *     kriterias: Collection,
     *     penilaians: Collection,
     *     matriksX: array<int, array<int, float>>,
     *     nilaiEkstrem: array<int, array{max: float, min: float}>,
     *     matriksR: array<int, array<int, float>>,
     *     hasilV: array<int, array{penilaian_id: int, siswa: Siswa, nilai_v: float, rank: int, predikat: string}>
     * }
     */
    public function calculate(string $kelas = 'VI-A', string $tahunAjaran = '2025/2026', string $semester = 'genap'): array
    {
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();

        $penilaians = Penilaian::with(['siswa', 'nilaiSiswas.kriteria'])
            ->whereHas('siswa', fn ($q) => $q->where('kelas', $kelas))
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get();

        if ($penilaians->isEmpty()) {
            return [
                'kriterias' => $kriterias,
                'penilaians' => $penilaians,
                'matriksX' => [],
                'nilaiEkstrem' => [],
                'matriksR' => [],
                'hasilV' => [],
            ];
        }

        // 1. Matriks Keputusan (X)
        $matriksX = [];
        foreach ($penilaians as $p) {
            foreach ($p->nilaiSiswas as $detail) {
                $matriksX[$p->id][$detail->kriteria_id] = (float) $detail->nilai_angka;
            }
        }

        // 2. Nilai Ekstrem (Max / Min Kolom)
        $nilaiEkstrem = [];
        foreach ($kriterias as $k) {
            $kolom = array_column($matriksX, $k->id);

            if (! empty($kolom)) {
                $max = max($kolom);

                // For cost criteria, find minimum positive non-zero value if available
                $positiveValues = array_filter($kolom, fn ($v) => $v > 0);
                $min = ! empty($positiveValues) ? min($positiveValues) : min($kolom);

                $nilaiEkstrem[$k->id] = [
                    'max' => (float) $max,
                    'min' => (float) $min,
                ];
            }
        }

        // 3. Normalisasi Matriks (R)
        $matriksR = [];
        foreach ($penilaians as $p) {
            foreach ($kriterias as $k) {
                $x_ij = $matriksX[$p->id][$k->id] ?? 0;

                if ($k->jenis === 'benefit') {
                    $max = $nilaiEkstrem[$k->id]['max'] ?? 1;
                    $r_ij = $max > 0 ? ($x_ij / $max) : 0;
                } else {
                    // Cost criteria: 0 alpha gets 1.0 (perfect score)
                    if ($x_ij == 0) {
                        $r_ij = 1.0;
                    } else {
                        $min = $nilaiEkstrem[$k->id]['min'] ?? 1;
                        $r_ij = $min / $x_ij;
                    }
                }

                $matriksR[$p->id][$k->id] = round($r_ij, 4);
            }
        }

        // 4. Perhitungan Nilai Preferensi (V)
        $hasilV = [];
        foreach ($penilaians as $p) {
            $totalV = 0.0;
            foreach ($kriterias as $k) {
                $r_ij = $matriksR[$p->id][$k->id] ?? 0;
                $bobot = (float) $k->bobot;
                $totalV += ($r_ij * $bobot);
            }

            $finalV = round($totalV, 4);

            $predikat = match (true) {
                $finalV >= 0.90 => 'Sangat Baik',
                $finalV >= 0.80 => 'Baik',
                $finalV >= 0.70 => 'Cukup',
                default => 'Perlu Pembinaan',
            };

            $hasilV[] = [
                'penilaian_id' => $p->id,
                'siswa' => $p->siswa,
                'nilai_v' => $finalV,
                'rank' => 0,
                'predikat' => $predikat,
            ];
        }

        // 5. Perankingan
        usort($hasilV, fn ($a, $b) => $b['nilai_v'] <=> $a['nilai_v']);

        foreach ($hasilV as $index => $item) {
            $hasilV[$index]['rank'] = $index + 1;
        }

        return [
            'kriterias' => $kriterias,
            'penilaians' => $penilaians,
            'matriksX' => $matriksX,
            'nilaiEkstrem' => $nilaiEkstrem,
            'matriksR' => $matriksR,
            'hasilV' => $hasilV,
        ];
    }

    /**
     * Save calculated V values and ranks to database.
     *
     * @param  array<int, array{penilaian_id: int, nilai_v: float, rank: int}>  $hasilV
     */
    public function saveResults(array $hasilV, ?int $userId = null): void
    {
        DB::transaction(function () use ($hasilV, $userId) {
            foreach ($hasilV as $item) {
                Penilaian::where('id', $item['penilaian_id'])->update([
                    'nilai_v' => $item['nilai_v'],
                    'rank' => $item['rank'],
                    'user_id' => $userId ?? auth()->id(),
                ]);
            }
        });
    }
}

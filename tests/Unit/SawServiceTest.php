<?php

use App\Models\Penilaian;
use App\Models\Siswa;
use App\Services\SawService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->sawService = new SawService;
});

test('it calculates SAW matching manual simulation accurately', function () {
    $result = $this->sawService->calculate('VI-A', '2025/2026', 'genap');

    $hasilV = $result['hasilV'];

    expect($hasilV)->toHaveCount(3);

    // Rank 1: Budi (V = 0.9000)
    expect($hasilV[0]['siswa']->nama)->toBe('Budi')
        ->and($hasilV[0]['nilai_v'])->toBe(0.9000)
        ->and($hasilV[0]['rank'])->toBe(1)
        ->and($hasilV[0]['predikat'])->toBe('Sangat Baik');

    // Rank 2: Citra (V = 0.8891)
    expect($hasilV[1]['siswa']->nama)->toBe('Citra')
        ->and($hasilV[1]['nilai_v'])->toBe(0.8891)
        ->and($hasilV[1]['rank'])->toBe(2)
        ->and($hasilV[1]['predikat'])->toBe('Baik');

    // Rank 3: Ahmad (V = 0.8446)
    expect($hasilV[2]['siswa']->nama)->toBe('Ahmad')
        ->and($hasilV[2]['nilai_v'])->toBe(0.8446)
        ->and($hasilV[2]['rank'])->toBe(3)
        ->and($hasilV[2]['predikat'])->toBe('Baik');
});

test('it saves calculated SAW results to database', function () {
    $result = $this->sawService->calculate('VI-A', '2025/2026', 'genap');

    $this->sawService->saveResults($result['hasilV']);

    $budi = Siswa::where('nama', 'Budi')->first();
    $penilaianBudi = Penilaian::where('siswa_id', $budi->id)->first();

    expect((float) $penilaianBudi->nilai_v)->toBe(0.9000)
        ->and($penilaianBudi->rank)->toBe(1)
        ->and($penilaianBudi->predikat)->toBe('Sangat Baik');
});

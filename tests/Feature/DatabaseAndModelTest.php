<?php

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('it seeds default criteria correctly', function () {
    expect(Kriteria::count())->toBe(4);

    $c1 = Kriteria::where('kode', 'C1')->first();
    expect($c1)->not->toBeNull()
        ->and($c1->jenis)->toBe('benefit')
        ->and((float) $c1->bobot)->toBe(0.40);
});

test('it seeds roles and default users', function () {
    $admin = User::where('email', 'admin@sdnjarak2.sch.id')->first();
    $waliKelas = User::where('email', 'walikelas@sdnjarak2.sch.id')->first();
    $kepsek = User::where('email', 'kepsek@sdnjarak2.sch.id')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->hasRole('Admin'))->toBeTrue();

    expect($waliKelas)->not->toBeNull()
        ->and($waliKelas->hasRole('Wali Kelas'))->toBeTrue();

    expect($kepsek)->not->toBeNull()
        ->and($kepsek->hasRole('Kepala Sekolah'))->toBeTrue();
});

test('it links penilaian with student and criteria values', function () {
    $ahmad = Siswa::where('nama', 'Ahmad')->first();
    expect($ahmad)->not->toBeNull();

    $penilaian = Penilaian::where('siswa_id', $ahmad->id)->first();
    expect($penilaian)->not->toBeNull()
        ->and($penilaian->nilaiSiswas)->toHaveCount(4);
});

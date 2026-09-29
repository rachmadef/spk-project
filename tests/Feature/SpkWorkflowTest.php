<?php

use App\Livewire\SawCalculator;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('email', 'admin@sdnjarak2.sch.id')->first();
});

test('authenticated user can view dashboard and master data pages', function () {
    $this->actingAs($this->user)
        ->get(route('dashboard'))
        ->assertOk();

    $this->actingAs($this->user)
        ->get(route('kriteria.index'))
        ->assertOk();

    $this->actingAs($this->user)
        ->get(route('siswa.index'))
        ->assertOk();

    $this->actingAs($this->user)
        ->get(route('user.index'))
        ->assertOk();
});

test('authenticated user can access input penilaian and saw calculator pages', function () {
    $this->actingAs($this->user)
        ->get(route('penilaian.input'))
        ->assertOk();

    $this->actingAs($this->user)
        ->get(route('saw.index'))
        ->assertOk();
});

test('it can calculate and save SAW results via Livewire', function () {
    Livewire::actingAs($this->user)
        ->test(SawCalculator::class)
        ->call('simpanHasil')
        ->assertHasNoErrors()
        ->assertSee('Hasil ranking dan predikat kinerja SAW berhasil disimpan ke database!');
});

test('it generates PDF report successfully', function () {
    $response = $this->actingAs($this->user)
        ->get(route('laporan.pdf', ['kelas' => 'VI-A', 'tahun_ajaran' => '2025/2026', 'semester' => 'genap']));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
});

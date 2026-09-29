<?php

namespace App\Livewire;

use App\Models\Kriteria;
use Livewire\Component;

class KriteriaManager extends Component
{
    public bool $showModal = false;

    public ?int $kriteriaId = null;

    public string $kode = '';

    public string $nama_kriteria = '';

    public string $bobot = '';

    public string $jenis = 'benefit';

    public string $deskripsi = '';

    protected function rules(): array
    {
        return [
            'kode' => 'required|string|max:10|unique:kriterias,kode,'.$this->kriteriaId,
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0.01|max:1.00',
            'jenis' => 'required|in:benefit,cost',
            'deskripsi' => 'nullable|string|max:255',
        ];
    }

    public function create(): void
    {
        $this->resetValidation();
        $this->reset(['kriteriaId', 'kode', 'nama_kriteria', 'bobot', 'jenis', 'deskripsi']);

        // Suggest next code C1, C2, etc.
        $count = Kriteria::count();
        $this->kode = 'C'.($count + 1);
        $this->showModal = true;
    }

    public function edit(Kriteria $kriteria): void
    {
        $this->resetValidation();
        $this->kriteriaId = $kriteria->id;
        $this->kode = $kriteria->kode;
        $this->nama_kriteria = $kriteria->nama_kriteria;
        $this->bobot = (string) $kriteria->bobot;
        $this->jenis = $kriteria->jenis;
        $this->deskripsi = $kriteria->deskripsi ?? '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Kriteria::updateOrCreate(
            ['id' => $this->kriteriaId],
            $validated
        );

        $this->showModal = false;
        session()->flash('message', 'Data kriteria berhasil disimpan.');
    }

    public function delete(Kriteria $kriteria): void
    {
        $kriteria->delete();
        session()->flash('message', 'Kriteria berhasil dihapus.');
    }

    public function render()
    {
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();
        $totalBobot = $kriterias->sum('bobot');

        return view('livewire.kriteria-manager', [
            'kriterias' => $kriterias,
            'totalBobot' => $totalBobot,
        ])->layout('layouts.app', ['title' => 'Manajemen Kriteria & Bobot']);
    }
}

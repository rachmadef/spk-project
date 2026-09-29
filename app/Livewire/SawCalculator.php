<?php

namespace App\Livewire;

use App\Services\SawService;
use Livewire\Component;

class SawCalculator extends Component
{
    public string $kelas = 'VI-A';

    public string $tahunAjaran = '2025/2026';

    public string $semester = 'genap';

    public string $activeTab = 'tabV';

    public function simpanHasil(SawService $sawService): void
    {
        $data = $sawService->calculate($this->kelas, $this->tahunAjaran, $this->semester);

        if (empty($data['hasilV'])) {
            session()->flash('error', 'Tidak ada data penilaian yang dapat disimpan.');

            return;
        }

        $sawService->saveResults($data['hasilV'], auth()->id());
        session()->flash('message', 'Hasil ranking dan predikat kinerja SAW berhasil disimpan ke database!');
    }

    public function render(SawService $sawService)
    {
        $data = $sawService->calculate($this->kelas, $this->tahunAjaran, $this->semester);

        return view('livewire.saw-calculator', array_merge($data, [
            'kelas' => $this->kelas,
            'tahunAjaran' => $this->tahunAjaran,
            'semester' => $this->semester,
        ]))->layout('layouts.app', ['title' => 'Kalkulasi & Perankingan SAW']);
    }
}

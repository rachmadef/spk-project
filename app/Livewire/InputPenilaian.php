<?php

namespace App\Livewire;

use App\Models\Kriteria;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InputPenilaian extends Component
{
    public string $kelas = 'VI-A';

    public string $tahunAjaran = '2025/2026';

    public string $semester = 'genap';

    /**
     * Structure: [siswa_id][kriteria_id] => float/int
     *
     * @var array<int, array<int, float|int|string>>
     */
    public array $nilaiInput = [];

    public function mount(): void
    {
        $this->loadNilai();
    }

    public function updatedKelas(): void
    {
        $this->loadNilai();
    }

    public function updatedTahunAjaran(): void
    {
        $this->loadNilai();
    }

    public function updatedSemester(): void
    {
        $this->loadNilai();
    }

    public function loadNilai(): void
    {
        $siswas = Siswa::where('kelas', $this->kelas)->get();
        $kriterias = Kriteria::all();
        $this->nilaiInput = [];

        foreach ($siswas as $siswa) {
            $penilaian = Penilaian::where('siswa_id', $siswa->id)
                ->where('tahun_ajaran', $this->tahunAjaran)
                ->where('semester', $this->semester)
                ->first();

            foreach ($kriterias as $k) {
                if ($penilaian) {
                    $detail = NilaiSiswa::where('penilaian_id', $penilaian->id)
                        ->where('kriteria_id', $k->id)
                        ->first();

                    $this->nilaiInput[$siswa->id][$k->id] = $detail ? $detail->nilai_angka : '';
                } else {
                    $this->nilaiInput[$siswa->id][$k->id] = '';
                }
            }
        }
    }

    public function saveAll(): void
    {
        $siswas = Siswa::where('kelas', $this->kelas)->get();
        $kriterias = Kriteria::all();

        DB::transaction(function () use ($siswas, $kriterias) {
            foreach ($siswas as $siswa) {
                $penilaian = Penilaian::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'tahun_ajaran' => $this->tahunAjaran,
                        'semester' => $this->semester,
                    ],
                    [
                        'user_id' => auth()->id(),
                    ]
                );

                foreach ($kriterias as $k) {
                    $val = $this->nilaiInput[$siswa->id][$k->id] ?? 0;

                    NilaiSiswa::updateOrCreate(
                        [
                            'penilaian_id' => $penilaian->id,
                            'kriteria_id' => $k->id,
                        ],
                        [
                            'nilai_angka' => is_numeric($val) ? (float) $val : 0,
                        ]
                    );
                }
            }
        });

        session()->flash('message', 'Data penilaian kriteria siswa berhasil disimpan!');
    }

    public function render()
    {
        $siswas = Siswa::where('kelas', $this->kelas)->orderBy('nama', 'asc')->get();
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();

        return view('livewire.input-penilaian', [
            'siswas' => $siswas,
            'kriterias' => $kriterias,
        ])->layout('layouts.app', ['title' => 'Input Penilaian Kriteria Siswa']);
    }
}

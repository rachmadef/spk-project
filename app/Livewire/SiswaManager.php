<?php

namespace App\Livewire;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;

class SiswaManager extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public ?int $siswaId = null;

    public string $nisn = '';

    public string $nama = '';

    public string $kelas = 'VI-A';

    public string $jenis_kelamin = 'L';

    public string $search = '';

    protected function rules(): array
    {
        return [
            'nisn' => 'required|string|max:20|unique:siswas,nisn,'.$this->siswaId,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetValidation();
        $this->reset(['siswaId', 'nisn', 'nama', 'kelas', 'jenis_kelamin']);
        $this->kelas = 'VI-A';
        $this->jenis_kelamin = 'L';
        $this->showModal = true;
    }

    public function edit(Siswa $siswa): void
    {
        $this->resetValidation();
        $this->siswaId = $siswa->id;
        $this->nisn = $siswa->nisn;
        $this->nama = $siswa->nama;
        $this->kelas = $siswa->kelas;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Siswa::updateOrCreate(
            ['id' => $this->siswaId],
            $validated
        );

        $this->showModal = false;
        session()->flash('message', 'Data siswa berhasil disimpan.');
    }

    public function delete(Siswa $siswa): void
    {
        $siswa->delete();
        session()->flash('message', 'Data siswa berhasil dihapus.');
    }

    public function render()
    {
        $siswas = Siswa::when($this->search, function ($query) {
            $query->where('nama', 'like', '%'.$this->search.'%')
                ->orWhere('nisn', 'like', '%'.$this->search.'%')
                ->orWhere('kelas', 'like', '%'.$this->search.'%');
        })
            ->orderBy('nama', 'asc')
            ->paginate(10);

        return view('livewire.siswa-manager', [
            'siswas' => $siswas,
        ])->layout('layouts.app', ['title' => 'Manajemen Data Siswa']);
    }
}

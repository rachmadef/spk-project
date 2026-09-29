<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [
            ['nisn' => '0012345671', 'nama' => 'Ahmad', 'kelas' => 'VI-A', 'jenis_kelamin' => 'L'],
            ['nisn' => '0012345672', 'nama' => 'Budi', 'kelas' => 'VI-A', 'jenis_kelamin' => 'L'],
            ['nisn' => '0012345673', 'nama' => 'Citra', 'kelas' => 'VI-A', 'jenis_kelamin' => 'P'],
            ['nisn' => '0012345674', 'nama' => 'Doni', 'kelas' => 'VI-A', 'jenis_kelamin' => 'L'],
            ['nisn' => '0012345675', 'nama' => 'Eka', 'kelas' => 'VI-A', 'jenis_kelamin' => 'P'],
        ];

        foreach ($siswas as $siswa) {
            Siswa::updateOrCreate(['nisn' => $siswa['nisn']], $siswa);
        }
    }
}

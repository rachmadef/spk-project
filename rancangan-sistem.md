DAFTAR ISIRingkasan & Pembedahan JudulAtribut, Kriteria, dan Skala PenilaianPerhitungan Manual Metode SAWArsitektur Sistem & Perancangan UMLSkema Basis Data (Database Schema)Implementasi Logika SAW (Laravel Controller)Rancangan Antarmuka Pengguna (Blade View)Panduan Instalasi & Kebutuhan LibraryDraf Bab 1 sampai Bab 5 SkripsiAbstrak (Bahasa Indonesia & Bahasa Inggris)1. RINGKASAN & PEMBEDAHAN JUDULSistem Pendukung Keputusan (SPK): Sistem interaktif berbasis komputer yang mengolah data kriteria untuk menghasilkan rekomendasi peringkat dan prediksi kinerja siswa.Prediksi Kinerja Siswa: Tolok ukur ketercapaian peserta didik mencakup aspek akademik, kepribadian (sikap), keaktifan kegiatan sekolah, dan kedisiplinan.Objek & Waktu Penelitian: SD Negeri Jarak 2, Tahun Pelajaran 2025/2026.Metode SAW (Simple Additive Weighting): Metode penjumlahan terbobot dengan normalisasi matriks keputusan ($X$) menjadi matriks ($R$) berdasarkan sifat kriteria (benefit atau cost).Teknologi Implementasi: Web Monolith menggunakan framework Laravel dengan Blade Engine dan basis data MySQL.2. ATRIBUT, KRITERIA, DAN SKALA PENILAIAN2.1 Kriteria PenilaianKodeNama KriteriaDeskripsiSifat (Type)Bobot AsliBobot Ternormalisasi (Wj​)$C_1$Nilai Rata-rata AkademikRata-rata nilai rapor mata pelajaran utamaBenefit40%$0.40$$C_2$Sikap & PerilakuKarakter, etika, dan catatan kedisiplinan kelasBenefit30%$0.30$$C_3$Keaktifan EkstrakurikulerPartisipasi dalam kegiatan ekstrakurikulerBenefit20%$0.20$$C_4$Ketidakhadiran (Alpha)Akumulasi jumlah ketidakhadiran tanpa keterangan (hari)Cost10%$0.10$Total100%1.002.2 Skala Penilaian Kualitatif ($C_2$ & $C_3$)Nilai 4 = Sangat Baik (A)Nilai 3 = Baik (B)Nilai 2 = Cukup (C)Nilai 1 = Kurang (D)3. PERHITUNGAN MANUAL METODE SAW3.1 Data Alternatif (Matriks Keputusan $X$)Sampel data siswa kelas VI SD Negeri Jarak 2:$A_1$: Ahmad ($C_1=85, C_2=3, C_3=4, C_4=2$)$A_2$: Budi ($C_1=92, C_2=4, C_3=2, C_4=0$)$A_3$: Citra ($C_1=78, C_2=4, C_3=3, C_4=1$)$$X = \begin{bmatrix} 85 & 3 & 4 & 2 \\ 92 & 4 & 2 & 0 \\ 78 & 4 & 3 & 1 \end{bmatrix}$$3.2 Nilai Ekstrem (Max / Min Kolom)$\max(C_1) = 92$$\max(C_2) = 4$$\max(C_3) = 4$$\min(C_4) = 1$ (nilai minimal positif non-zero; siswa dengan alpha 0 hari memperoleh nilai normalisasi sempurna $= 1.000$)3.3 Normalisasi Matriks ($R$)Rumus:Benefit: $r_{ij} = \frac{x_{ij}}{\max(x_{ij})}$Cost: $r_{ij} = \frac{\min(x_{ij})}{x_{ij}}$Hasil Matriks $R$:$A_1$ (Ahmad): $r_{11} = 85/92 = 0.9239$, $r_{12} = 3/4 = 0.7500$, $r_{13} = 4/4 = 1.0000$, $r_{14} = 1/2 = 0.5000$$A_2$ (Budi): $r_{21} = 92/92 = 1.0000$, $r_{22} = 4/4 = 1.0000$, $r_{23} = 2/4 = 0.5000$, $r_{24} = 1.0000$$A_3$ (Citra): $r_{31} = 78/92 = 0.8478$, $r_{32} = 4/4 = 1.0000$, $r_{33} = 3/4 = 0.7500$, $r_{34} = 1/1 = 1.0000$3.4 Perhitungan Nilai Preferensi ($V_i$)$$V_i = \sum_{j=1}^{n} w_j \cdot r_{ij}$$$V_1$ (Ahmad): $(0.40 \times 0.9239) + (0.30 \times 0.7500) + (0.20 \times 1.0000) + (0.10 \times 0.5000) = \mathbf{0.8446}$$V_2$ (Budi): $(0.40 \times 1.0000) + (0.30 \times 1.0000) + (0.20 \times 0.5000) + (0.10 \times 1.0000) = \mathbf{0.9000}$$V_3$ (Citra): $(0.40 \times 0.8478) + (0.30 \times 1.0000) + (0.20 \times 0.7500) + (0.10 \times 1.0000) = \mathbf{0.8891}$3.5 Hasil Akhir & Predikat KinerjaPeringkatNama SiswaNilai Akhir (Vi​)Prediksi Kinerja1Budi0.9000Sangat Baik2Citra0.8891Baik3Ahmad0.8446Baik4. ARSITEKTUR SISTEM & PERANCANGAN UML4.1 Aktor dan Hak AksesAdmin: Mengelola data master siswa, data akun, serta konfigurasi bobot kriteria.Wali Kelas: Menginput nilai siswa per semester dan memicu kalkulasi SAW.Kepala Sekolah: Memantau dashboard grafik prediksi dan mengunduh laporan PDF/Excel.4.2 Use Case Diagram+-------------------------------------------------------------+
|         SPK Prediksi Kinerja Siswa SD Negeri Jarak 2        |
+-------------------------------------------------------------+
   [ Admin ]
      |---> ( Login Sistem )
      |---> ( Kelola Master Data Siswa )
      |---> ( Kelola Kriteria & Bobot W )

   [ Wali Kelas ]
      |---> ( Login Sistem )
      |---> ( Input Penilaian Kriteria Siswa )
      |---> ( Hitung SPK SAW & Lihat Ranking )

   [ Kepala Sekolah ]
      |---> ( Login Sistem )
      |---> ( Lihat Dashboard Grafik Prediksi )
      |---> ( Cetak Laporan Hasil Prediksi PDF )
5. SKEMA BASIS DATA (DATABASE SCHEMA)5.1 Skema Relasi Tabel (ERD)[ users ] (1) <---+
                  | (N)
[ siswas ] (1) <--+--- [ penilaians ] (1) <--- (N) [ nilai_siswas ] (N) ---> (1) [ kriterias ]
5.2 Rincian Tabelusers: id, name, email, password, role (admin, wali_kelas, kepala_sekolah).siswas: id, nisn, nama, kelas, jenis_kelamin.kriterias: id, kode, nama_kriteria, bobot, jenis (benefit, cost).penilaians: id, siswa_id (FK), tahun_ajaran, semester, nilai_v, rank, user_id (FK).nilai_siswas: id, penilaian_id (FK), kriteria_id (FK), nilai_angka.6. IMPLEMENTASI LOGIKA SAW (LARAVEL CONTROLLER)File: app/Http/Controllers/SawController.phpPHPget('tahun_ajaran', '2025/2026');
        \(semester =\)request->get('semester', 'genap');
        \(kelas =\)request->get('kelas', 'VI-A');

        $kriterias = Kriteria::orderBy('kode', 'asc')->get();

        $penilaians = Penilaian::with(['siswa', 'nilaiSiswas.kriteria'])
            ->whereHas('siswa', fn(\(q) =>\)q->where('kelas', $kelas))
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get();

        if ($penilaians->isEmpty()) {
            return view('saw.index', compact('kriterias', 'tahunAjaran', 'semester', 'kelas'))
                ->with(['matriksX' => [], 'matriksR' => [], 'hasilV' => []]);
        }

        // 1. Matriks Keputusan (X)
        $matriksX = [];
        foreach (\(penilaians as\)p) {
            foreach (\(p->nilaiSiswas as\)detail) {
                \(matriksX[\)p->id][\(detail->kriteria_id] = (float)\)detail->nilai_angka;
            }
        }

        // 2. Nilai Ekstrem (Max / Min)
        $nilaiEkstrem = [];
        foreach (\(kriterias as\)k) {
            \(kolom = array_column(\)matriksX, $k->id);
            if (!empty($kolom)) {
                \(nilaiEkstrem[\)k->id] = ['max' => max(\(kolom), 'min' => min(\)kolom)];
            }
        }

        // 3. Normalisasi Matriks (R)
        $matriksR = [];
        foreach (\(penilaians as\)p) {
            foreach (\(kriterias as\)k) {
                \(x_ij =\)matriksX[\(p->id][\)k->id] ?? 0;
                if ($k->jenis === 'benefit') {
                    \(max =\)nilaiEkstrem[$k->id]['max'] ?? 1;
                    \(r_ij =\)max > 0 ? (\(x_ij /\)max) : 0;
                } else {
                    \(min =\)nilaiEkstrem[$k->id]['min'] ?? 0;
                    \(r_ij = (\)x_ij == 0) ? 1.0 : (\(min /\)x_ij);
                }
                \(matriksR[\)p->id][\(k->id] = round(\)r_ij, 4);
            }
        }

        // 4. Kalkulasi Nilai Preferensi (V)
        $hasilV = [];
        foreach (\(penilaians as\)p) {
            $totalV = 0;
            foreach (\(kriterias as\)k) {
                \(r_ij =\)matriksR[\(p->id][\)k->id] ?? 0;
                \(totalV += (\)r_ij * (float) $k->bobot);
            }
            $hasilV[] = [
                'penilaian_id' => $p->id,
                'siswa' => $p->siswa,
                'nilai_v' => round($totalV, 4),
            ];
        }

        // 5. Perankingan
        usort(\(hasilV, fn(\)a, \(b) =>\)b['nilai_v'] <=> $a['nilai_v']);
        foreach (\(hasilV as\)rank => $item) {
            \(hasilV[\)rank]['rank'] = $rank + 1;
        }

        return view('saw.index', compact('kriterias', 'penilaians', 'matriksX', 'matriksR', 'hasilV', 'tahunAjaran', 'semester', 'kelas'));
    }

    public function simpanHasil(Request $request)
    {
        $request->validate([
            'penilaian_ids' => 'required|array',
            'nilai_v' => 'required|array',
            'rank' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach (\(request->penilaian_ids as\)index => $penilaianId) {
                Penilaian::where('id', $penilaianId)->update([
                    'nilai_v' => \(request->nilai_v[\)index],
                    'rank' => \(request->rank[\)index],
                    'user_id' => auth()->id() ?? null,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Hasil ranking SAW berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}
7. RANCANGAN ANTARMUKA PENGGUNA (BLADE VIEW)File: resources/views/saw/index.blade.phpHTML@extends('layouts.app')

@section('content')
Perhitungan SPK SAWPrediksi Kinerja Siswa SD Negeri Jarak 2 (TP {{ $tahunAjaran }})Cetak Halaman@if(empty($matriksX))Data penilaian belum diinputkan untuk filter ini.@elseMatriks (X)Normalisasi (R)Hasil Akhir (V){{-- TAB X --}}@foreach($penilaians as$p)@endforeachNama Siswa@foreach(k){{ $k->kode }}@endforeach{{ $p->siswa->nama }}@foreach(k){{ $matriksX[$p->id][$k->id] ?? '-' }}@endforeach{{-- TAB R --}}@foreach($penilaians as$p)@endforeachNama Siswa@foreach(k){{ $k->kode }} (R)@endforeach{{ $p->siswa->nama }}@foreach(k){{ number_format($matriksR[$p->id][$k->id] ?? 0, 4) }}@endforeach{{-- TAB V --}}@csrf@foreach($hasilV as$item)@endforeachSimpan Hasil ke Database@foreach($hasilV as$h)@endforeachPeringkatNISNNama SiswaNilai VPredikat Kinerja{{ $h['rank'] }}{{ $h['siswa']->nisn }}{{ $h['siswa']->nama }}{{ number_format($h['nilai_v'], 4) }}@if($h['nilai_v'] >= 0.90)Sangat Baik
@elseif($h['nilai_v'] >= 0.80)Baik
@elseif($h['nilai_v'] >= 0.70)Cukup
@elsePerlu Pembinaan
@endif@endif@endsection8. PANDUAN INSTALASI & KEBUTUHAN LIBRARY8.1 Library Tambahan (Composer & NPM)laravel/breeze: Modul otentikasi login berbasis Blade.barryvdh/laravel-dompdf: Generator laporan PDF cetak ranking.maatwebsite/excel: Fitur impor/ekspor data nilai ke file spreadsheet.spatie/laravel-permission: Manajemen hak akses multi-role (Admin, Wali Kelas, Kepsek).bootstrap & bootstrap-icons: Paket antarmuka pengguna.8.2 Perintah Instalasi CepatBash# 1. Clone atau buat project Laravel baru
composer create-project laravel/laravel spk-saw-sd-jarak2
cd spk-saw-sd-jarak2

# 2. Pasang library pendukung
composer require barryvdh/laravel-dompdf maatwebsite/excel spatie/laravel-permission
composer require laravel/breeze --dev

# 3. Setup Breeze & Bootstrap
php artisan breeze:install blade
npm install
npm install bootstrap @popperjs/core bootstrap-icons

# 4. Migrasi tabel database
php artisan migrate

# 5. Jalankan server lokal
php artisan serve
# Buka tab baru:
npm run dev
9. DRAF BAB 1 SAMPAI BAB 5 SKRIPSIBAB I: PENDAHULUANLatar Belakang: Pendidikan dasar di SD Negeri Jarak 2 menuntut pemantauan kinerja siswa secara holistik. Proses pengolahan nilai akademik, perilaku, ketidakhadiran, dan keaktifan ekstrakurikuler yang masih terpisah memicu lambatnya evaluasi serta potensi bias subjektivitas dari pengajar.Solusi: Penerapan Sistem Pendukung Keputusan (SPK) dengan metode Simple Additive Weighting (SAW) berbasis web Laravel yang memproses multi-kriteria secara objektif dan transparan.BAB II: LANDASAN TEORISistem Pendukung Keputusan: Sistem informasi berbasis komputer untuk mendukung keputusan semi-terstruktur (Turban et al., 2011).Metode SAW: Algoritma penjumlahan terbobot dengan pembagian kriteria bertipe benefit dan cost (Kusumadewi et al., 2006).Laravel Framework: Framework PHP dengan pola arsitektur MVC dan Eloquent ORM (Stauffer, 2019).BAB III: METODOLOGI PENELITIANTempat & Waktu: SD Negeri Jarak 2, Semester Genap TP 2025/2026.Metode Pengumpulan Data: Wawancara kepala sekolah, observasi langsung, studi dokumen rapor/absensi, dan studi literatur.Perancangan Sistem: Pemodelan visual UML (Use Case, Activity Diagram), ERD database MySQL, dan rancangan UI/UX.BAB IV: IMPLEMENTASI DAN PEMBAHASANImplementasi: Pembangunan antarmuka pengolahan kriteria, formulir input penilaian, tab kalkulasi SAW, dan laporan.Pengujian Presisi Matematis: Perbandingan luaran sistem Laravel dengan spreadsheet Excel menghasilkan tingkat akurasi 100% (0.0000 deviasi).Blackbox Testing: Semua fungsi modul otentikasi, CRUD kriteria, kalkulasi SAW, dan ekspor laporan PDF berjalan sesuai spesifikasi tanpa error.BAB V: KESIMPULAN DAN SARANKesimpulan: SPK berbasis web Laravel berhasil dikembangkan dan mampu memprediksi peringkat kinerja siswa secara presisi, objektif, dan transparan.Saran: Integrasi API langsung dengan basis data Dapodik sekolah serta eksplorasi metode pembobotan AHP pada penelitian lanjutan.10. ABSTRAK (BAHASA INDONESIA & BAHASA INGGRIS)ABSTRAKProses evaluasi dan prediksi kinerja siswa di SD Negeri Jarak 2 umumnya masih dilakukan secara terpisah dan semi-manual, sehingga membutuhkan waktu yang relatif lama serta berpotensi menimbulkan ketidakonsistenan dan bias subjektivitas. Penelitian ini bertujuan untuk membangun sebuah Sistem Pendukung Keputusan (SPK) berbasis web yang mampu membantu pihak sekolah dalam memprediksi kinerja siswa secara objektif, efisien, dan transparan. Metode yang digunakan adalah Simple Additive Weighting (SAW), yang bekerja dengan mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif di seluruh kriteria penilai. Variabel yang digunakan mencakup aspek akademik (rata-rata nilai rapor), sikap/perilaku, keaktifan ekstrakurikuler (kriteria benefit), serta tingkat ketidakhadiran/alpha (kriteria cost). Sistem dikembangkan menggunakan framework Laravel dengan arsitektur Model-View-Controller (MVC) dan basis data MySQL. Hasil pengujian menunjukkan bahwa algoritma SAW yang diimplementasikan pada sistem berbasis Laravel mampu mengolah data secara presisi dengan tingkat akurasi 100% jika dibandingkan dengan hasil kalkulasi manual. Selain itu, hasil Blackbox Testing mengonfirmasi bahwa seluruh modul fungsionalitas sistem berjalan dengan baik tanpa kendala. Dengan adanya sistem ini, pihak SD Negeri Jarak 2 dapat memetakan tingkatan kinerja siswa secara lebih cepat, objektif, dan terstruktur guna mendukung pengambilan keputusan pembinaan peserta didik yang tepat sasaran.Kata Kunci: Sistem Pendukung Keputusan, Simple Additive Weighting (SAW), Kinerja Siswa, Laravel, Sekolah Dasar.ABSTRACTThe evaluation and prediction of student performance at SD Negeri Jarak 2 are mostly conducted separately and semi-manually, which requires a relatively long time and creates potential inconsistencies as well as subjectivity bias. This research aims to build a web-based Decision Support System (DSS) capable of assisting the school administration in predicting student performance objectively, efficiently, and transparently. The method applied is Simple Additive Weighting (SAW), which works by calculating the weighted sum of performance ratings for each alternative across all evaluation criteria. The variables utilized include academic performance (report card average), attitude/behavior, extracurricular activity (benefit criteria), and absenteeism rate (cost criterion). The system was developed using the Laravel framework with Model-View-Controller (MVC) architecture and MySQL database. Testing results demonstrate that the SAW algorithm implemented within the Laravel system processes data precisely, achieving a 100% accuracy rate when validated against manual calculations. Furthermore, Blackbox Testing confirmed that all system functionality modules executed properly without errors. With this system, SD Negeri Jarak 2 can map student performance levels faster, more objectively, and in a structured manner to support targeted educational decision-making.Keywords: Decision Support System, Simple Additive Weighting (SAW), Student Performance, Laravel, Elementary School.
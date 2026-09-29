<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Prediksi Kinerja Siswa - SD Negeri Jarak 2</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #111;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 2px 0;
            font-size: 16pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 0;
            font-size: 9pt;
            color: #444;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h4 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .meta-table td {
            padding: 3px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 10pt;
        }
        table.data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .signature-table {
            width: 100%;
            margin-top: 30px;
            font-size: 10pt;
        }
        .signature-table td {
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>PEMERINTAH KABUPATEN JOMBANG</h3>
        <h2>SD NEGERI JARAK 2</h2>
        <p>Alamat: Jl. Raya Jarak No. 02, Kec. Wonosalam, Kab. Jombang, Jawa Timur 61476</p>
    </div>

    <div class="title">
        <h4>LAPORAN HASIL PREDIKSI KINERJA SISWA (METODE SAW)</h4>
        <p style="margin: 3px 0 0 0; font-size: 10pt;">Tahun Pelajaran {{ $tahunAjaran }} - Semester {{ ucfirst($semester) }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td width="15%"><strong>Kelas</strong></td>
            <td width="35%">: {{ $kelas }}</td>
            <td width="20%"><strong>Tanggal Cetak</strong></td>
            <td width="30%">: {{ $tanggalCetak }}</td>
        </tr>
        <tr>
            <td><strong>Metode SPK</strong></td>
            <td>: Simple Additive Weighting (SAW)</td>
            <td><strong>Jumlah Siswa</strong></td>
            <td>: {{ count($hasilV) }} Peserta Didik</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="17%">NISN</th>
                <th width="35%">Nama Siswa</th>
                <th width="20%">Nilai Preferensi ($V_i$)</th>
                <th width="20%">Prediksi Kinerja</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilV as $h)
                <tr>
                    <td class="text-center font-bold">{{ $h['rank'] }}</td>
                    <td class="text-center">{{ $h['siswa']->nisn }}</td>
                    <td>{{ $h['siswa']->nama }}</td>
                    <td class="text-center font-bold">{{ number_format($h['nilai_v'], 4) }}</td>
                    <td class="text-center">{{ $h['predikat'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data hasil kalkulasi belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td width="50%">
                Mengetahui,<br>
                Kepala Sekolah SD Negeri Jarak 2<br><br><br><br><br>
                <strong><u>NIP. 19780512 200501 1 002</u></strong>
            </td>
            <td width="50%">
                Jombang, {{ $tanggalCetak }}<br>
                Wali Kelas {{ $kelas }}<br><br><br><br><br>
                <strong><u>{{ auth()->user()->name ?? 'Wali Kelas' }}</u></strong>
            </td>
        </tr>
    </table>

</body>
</html>

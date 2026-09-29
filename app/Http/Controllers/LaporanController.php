<?php

namespace App\Http\Controllers;

use App\Services\SawService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LaporanController extends Controller
{
    public function cetakPdf(Request $request, SawService $sawService): Response
    {
        $kelas = $request->get('kelas', 'VI-A');
        $tahunAjaran = $request->get('tahun_ajaran', '2025/2026');
        $semester = $request->get('semester', 'genap');

        $data = $sawService->calculate($kelas, $tahunAjaran, $semester);

        $pdf = Pdf::loadView('laporan.pdf', array_merge($data, [
            'kelas' => $kelas,
            'tahunAjaran' => $tahunAjaran,
            'semester' => $semester,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ]))->setPaper('a4', 'portrait');

        return $pdf->stream("Laporan-SPK-SAW-Kelas-{$kelas}.pdf");
    }
}

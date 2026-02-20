<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\Kehadiran;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pegawai = $user->pegawai;

        $totalCutiDisetujui = 0;
        $totalCutiPending = 0;
        $totalCutiDitolak = 0;
        $totalHadirBulanIni = 0;
        $sisaCuti = 0;
        $kuotaCuti = 0;
        $kehadiranBulanIni = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
        ];
        $riwayatCutiTerbaru = collect();
        $riwayatKehadiranTerbaru = collect();

        if ($pegawai) {
            $totalCutiDisetujui = Cuti::where('pegawai_id', $pegawai->id)
                ->where('status', 'disetujui')
                ->count();

            $totalCutiPending = Cuti::where('pegawai_id', $pegawai->id)
                ->where('status', 'pending')
                ->count();

            $totalCutiDitolak = Cuti::where('pegawai_id', $pegawai->id)
                ->where('status', 'ditolak')
                ->count();

            $kuotaCuti = (int) ($pegawai->kuota_cuti ?? 0);
            $sisaCuti = (int) ($pegawai->sisa_cuti ?? 0);

            $queryKehadiranBulanIni = Kehadiran::where('pegawai_id', $pegawai->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);

            $totalHadirBulanIni = (clone $queryKehadiranBulanIni)
                ->where('status', 'hadir')
                ->count();

            $kehadiranBulanIni = [
                'hadir' => (clone $queryKehadiranBulanIni)->where('status', 'hadir')->count(),
                'izin' => (clone $queryKehadiranBulanIni)->where('status', 'izin')->count(),
                'sakit' => (clone $queryKehadiranBulanIni)->where('status', 'sakit')->count(),
                'alpha' => (clone $queryKehadiranBulanIni)->where('status', 'alpha')->count(),
            ];

            $riwayatCutiTerbaru = Cuti::where('pegawai_id', $pegawai->id)
                ->latest()
                ->limit(5)
                ->get();

            $riwayatKehadiranTerbaru = Kehadiran::where('pegawai_id', $pegawai->id)
                ->orderByDesc('tanggal')
                ->limit(7)
                ->get();
        }

        return view('pegawai.dashboard', compact(
            'user',
            'pegawai',
            'totalCutiDisetujui',
            'totalCutiPending',
            'totalCutiDitolak',
            'totalHadirBulanIni',
            'kuotaCuti',
            'sisaCuti',
            'kehadiranBulanIni',
            'riwayatCutiTerbaru',
            'riwayatKehadiranTerbaru',
        ));
    }
}

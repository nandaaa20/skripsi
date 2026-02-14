<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::with('pegawai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.cuti.index', compact('cuti'));
    }

    public function show(Cuti $cuti)
    {
        $cuti->load('pegawai.user');

        return view('admin.cuti.show', compact('cuti'));
    }

    public function updateStatus(Request $request, Cuti $cuti)
    {
        if ($cuti->status !== 'pending') {
            return redirect()
                ->route('admin.cuti.show', $cuti)
                ->with('error', 'Keputusan cuti sudah ditetapkan dan tidak dapat diubah lagi.');
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        if ($request->status === 'disetujui' && $cuti->pegawai && $cuti->pegawai->sisa_cuti < $cuti->jumlah_hari) {
            return redirect()
                ->route('admin.cuti.show', $cuti)
                ->with('error', 'Sisa cuti pegawai tidak mencukupi untuk menyetujui pengajuan ini.');
        }

        DB::transaction(function () use ($request, $cuti) {
            $cuti->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
            ]);

            if ($request->status === 'disetujui') {
                $pegawai = $cuti->pegawai()->lockForUpdate()->first();

                if ($pegawai) {
                    $pegawai->sisa_cuti -= $cuti->jumlah_hari;
                    $pegawai->save();
                }
            }
        });

        $cuti->refresh();

        $emailPegawai = $cuti->pegawai?->user?->email;
        if ($emailPegawai) {
            $statusText = ucfirst($cuti->status);
            $statusColor = $cuti->status === 'disetujui' ? '#059669' : '#DC2626';

            $html = view('emails.cuti.status-pegawai', [
                'namaPegawai' => $cuti->pegawai->nama_lengkap,
                'statusText' => $statusText,
                'statusColor' => $statusColor,
                'jenisCuti' => $cuti->jenis_cuti,
                'tanggalMulai' => Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y'),
                'tanggalSelesai' => Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y'),
                'jumlahHari' => $cuti->jumlah_hari,
                'catatanAdmin' => $cuti->catatan_admin,
            ])->render();

            Mail::send([], [], function ($message) use ($emailPegawai, $statusText, $html) {
                $message->to($emailPegawai)
                    ->subject("📌 Status Pengajuan Cuti: {$statusText}")
                    ->html($html);
            });
        }

        return redirect()
            ->route('admin.cuti.show', $cuti)
            ->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }
}

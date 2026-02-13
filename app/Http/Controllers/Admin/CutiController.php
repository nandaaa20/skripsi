<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
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
            Mail::raw("Status cuti Anda: {$cuti->status}.", function ($message) use ($emailPegawai) {
                $message->to($emailPegawai)
                    ->subject('Status Pengajuan Cuti');
            });
        }

        return redirect()
            ->route('admin.cuti.show', $cuti)
            ->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }
}

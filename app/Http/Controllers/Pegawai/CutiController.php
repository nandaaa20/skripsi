<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $pegawai = auth()->user()->pegawai;

        if (!$pegawai) {
            $cuti = collect();
        } else {
            $cuti = Cuti::where('pegawai_id', $pegawai->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pegawai.cuti.index', compact('cuti', 'pegawai'));
    }

    public function create()
    {
        $pegawai = auth()->user()->pegawai;

        if (!$pegawai) {
            abort(403, 'Data pegawai belum terdaftar');
        }

        return view('pegawai.cuti.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $pegawai = auth()->user()->pegawai;

        if (!$pegawai) {
            abort(403, 'Data pegawai belum terdaftar');
        }

        $validated = $request->validate([
            'tanggal_mulai' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value);
                    if ($date->isWeekend()) {
                        $fail('Tanggal mulai cuti harus di hari kerja (Senin-Jumat), tidak boleh di akhir pekan.');
                    }
                },
            ],
            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value);
                    if ($date->isWeekend()) {
                        $fail('Tanggal selesai cuti harus di hari kerja (Senin-Jumat), tidak boleh di akhir pekan.');
                    }
                },
            ],
            'jenis_cuti' => 'required|string|max:100',
            'alasan' => 'required|string',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai cuti harus diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai cuti tidak boleh di masa lampau.',
            'tanggal_selesai.required' => 'Tanggal selesai cuti harus diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
            'jenis_cuti.required' => 'Jenis cuti harus dipilih.',
            'alasan.required' => 'Alasan pengajuan cuti harus diisi.',
        ]);

        // Hitung jumlah hari kerja (exclude weekend)
        $start = Carbon::parse($validated['tanggal_mulai']);
        $end = Carbon::parse($validated['tanggal_selesai']);
        
        $jumlahHariKerja = 0;
        $currentDate = $start->copy();
        
        while ($currentDate->lte($end)) {
            // Hitung hanya hari kerja (Senin-Jumat)
            if (!$currentDate->isWeekend()) {
                $jumlahHariKerja++;
            }
            $currentDate->addDay();
        }

        Cuti::create([
            'pegawai_id' => $pegawai->id,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'jenis_cuti' => $validated['jenis_cuti'],
            'alasan' => $validated['alasan'],
            'status' => 'pending',
            'jumlah_hari' => $jumlahHariKerja, // Simpan jumlah hari kerja saja
        ]);

        return redirect()
            ->route('pegawai.cuti.index')
            ->with('success', "Pengajuan cuti berhasil dikirim ({$jumlahHariKerja} hari kerja) dan menunggu persetujuan admin.");
    }
}

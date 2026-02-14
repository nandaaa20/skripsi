<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CutiController extends Controller
{
    public function index()
    {
        $pegawai = auth()->user()->pegawai;

        if (! $pegawai) {
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

        if (! $pegawai) {
            abort(403, 'Data pegawai belum terdaftar');
        }

        return view('pegawai.cuti.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $pegawai = auth()->user()->pegawai;

        if (! $pegawai) {
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

        $start = Carbon::parse($validated['tanggal_mulai']);
        $end = Carbon::parse($validated['tanggal_selesai']);

        $jumlahHariKerja = 0;
        $currentDate = $start->copy();

        while ($currentDate->lte($end)) {
            if (! $currentDate->isWeekend()) {
                $jumlahHariKerja++;
            }
            $currentDate->addDay();
        }

        if ($jumlahHariKerja > $pegawai->sisa_cuti) {
            $kekuranganHari = $jumlahHariKerja - $pegawai->sisa_cuti;

            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_hari' => "Sisa cuti tidak mencukupi. Anda mengajukan {$jumlahHariKerja} hari, sisa saat ini {$pegawai->sisa_cuti} hari, kurang {$kekuranganHari} hari.",
                ]);
        }

        Cuti::create([
            'pegawai_id' => $pegawai->id,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'jenis_cuti' => $validated['jenis_cuti'],
            'alasan' => $validated['alasan'],
            'status' => 'pending',
            'jumlah_hari' => $jumlahHariKerja,
        ]);

        $admins = User::where('role', 'admin')
            ->whereNotNull('email')
            ->pluck('email')
            ->all();

        if (! empty($admins)) {
            Mail::raw("Ada pengajuan cuti baru dari {$pegawai->nama_lengkap} ({$pegawai->nip}) selama {$jumlahHariKerja} hari kerja.", function ($message) use ($admins) {
                $message->to($admins)
                    ->subject('Pengajuan Cuti Baru');
            });
        }

        return redirect()
            ->route('pegawai.cuti.index')
            ->with('success', "Pengajuan cuti berhasil dikirim ({$jumlahHariKerja} hari kerja) dan menunggu persetujuan admin.");
    }
}

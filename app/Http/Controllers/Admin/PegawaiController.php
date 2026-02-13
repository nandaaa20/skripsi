<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Tampilkan daftar pegawai.
     */
// app/Http/Controllers/Admin/PegawaiController.php

    public function index(Request $request)
    {
        $query = Pegawai::query()->with('user');

        // Search: NIP, Nama, Jabatan, Departemen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                ->orWhere('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%")
                ->orWhere('departemen', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status_kepegawaian', $request->status);
        }

        // Pagination dengan query string (preserve query parameters for pagination links)
        $pegawai = $query->latest()
                        ->paginate(10)
                        ->appends($request->query());

        return view('admin.pegawai.index', compact('pegawai'));
    }


    /**
     * Form tambah pegawai.
     */
    public function create()
    {
        $listJabatan    = $this->getListJabatan();
        $listDepartemen = $this->getListDepartemen();

        // $pegawai = null untuk form gabungan create/edit
        $pegawai = null;

        return view('admin.pegawai.create', compact('listJabatan', 'listDepartemen', 'pegawai'));
    }

     // * Simpan pegawai baru + auto buat akun user.
    public function store(Request $request)
    {
        $request->validate([
            'nip'               => 'required|string|max:50|unique:pegawai,nip|unique:users,nip',
            'nama_lengkap'      => 'required|string|max:150',
            'jabatan'           => 'nullable|string|max:100',
            'departemen'        => 'nullable|string|max:100',
            'jenis_kelamin'     => 'nullable|in:L,P',
            'tanggal_lahir'     => 'nullable|date',
            'no_telepon'        => 'nullable|string|max:20',
            'alamat'            => 'nullable|string',
            'tanggal_masuk'     => 'nullable|date',
            'status_kepegawaian'=> 'nullable|in:aktif,nonaktif,kontrak',
        ]);

        // Password awal default
        $passwordAwal = 'pegawai123';

        // 1. Buat akun user (login)
        $user = User::create([
            'nip'      => $request->nip,
            'name'     => $request->nama_lengkap, // <-- WAJIB PAKAI INI
            'email'    => null,
            'password' => Hash::make($passwordAwal),
            'role'     => 'pegawai',
        ]);


        // 2. Buat data pegawai
        Pegawai::create([
            'user_id'           => $user->id,
            'nip'               => $request->nip,
            'nama_lengkap'      => $request->nama_lengkap,
            'jabatan'           => $request->jabatan,
            'departemen'        => $request->departemen,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'no_telepon'        => $request->no_telepon,
            'alamat'            => $request->alamat,
            'tanggal_masuk'     => $request->tanggal_masuk,
            'status_kepegawaian'=> $request->status_kepegawaian ?? 'aktif',
            'kuota_cuti'        => 12,
            'sisa_cuti'         => 12,
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai dan akun login berhasil dibuat. Password awal: ' . $passwordAwal);
    }

    /**
     * Detail pegawai.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('user');

        return view('admin.pegawai.show', compact('pegawai'));
    }

    /**
     * Form edit pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        $pegawai->load('user');

        $listJabatan    = $this->getListJabatan();
        $listDepartemen = $this->getListDepartemen();

        return view('admin.pegawai.edit', compact('pegawai', 'listJabatan', 'listDepartemen'));
    }

    /**
     * Update data pegawai + update akun user.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nip'               => 'required|string|max:50|unique:pegawai,nip,' . $pegawai->id
                                                        . '|unique:users,nip,' . $pegawai->user_id,
            'nama_lengkap'      => 'required|string|max:150',
            'jabatan'           => 'nullable|string|max:100',
            'departemen'        => 'nullable|string|max:100',
            'jenis_kelamin'     => 'nullable|in:L,P',
            'tanggal_lahir'     => 'nullable|date',
            'no_telepon'        => 'nullable|string|max:20',
            'alamat'            => 'nullable|string',
            'tanggal_masuk'     => 'nullable|date',
            'status_kepegawaian'=> 'nullable|in:aktif,nonaktif,kontrak',
        ]);

        // Update data user (akun login)
        if ($pegawai->user) {
            $pegawai->user->update([
                'nip'  => $request->nip,
                'name' => $request->nama_lengkap, // <-- WAJIB DICANTUMKAN
            ]);
        }


        // Update data pegawai
        $pegawai->update([
            'nip'               => $request->nip,
            'nama_lengkap'      => $request->nama_lengkap,
            'jabatan'           => $request->jabatan,
            'departemen'        => $request->departemen,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'no_telepon'        => $request->no_telepon,
            'alamat'            => $request->alamat,
            'tanggal_masuk'     => $request->tanggal_masuk,
            'status_kepegawaian'=> $request->status_kepegawaian ?? $pegawai->status_kepegawaian,
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Hapus pegawai + hapus akun user terkait.
     */
    public function destroy(Pegawai $pegawai)
    {
        // Hapus user → pegawai ikut terhapus (onDelete('cascade'))
        if ($pegawai->user) {
            $pegawai->user->delete();
        } else {
            $pegawai->delete();
        }

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai dan akun login berhasil dihapus.');
    }

    /**
     * List jabatan (bisa disesuaikan dengan instansi).
     */
    protected function getListJabatan(): array
    {
        return [
            'Staff',
            'Supervisor',
            'Manager',
            'Kepala Bagian',
        ];
    }

    /**
     * List departemen (bisa disesuaikan dengan instansi).
     */
    protected function getListDepartemen(): array
    {
        return [
            'Keuangan',
            'SDM',
            'Umum',
            'IT',
            'Produksi',
        ];
    }

    public function resetPassword(Pegawai $pegawai)
    {
        if ($pegawai->user) {
            $pegawai->user->update([
                'password' => Hash::make('pegawai123'), // password default
            ]);

            return back()->with('success', 'Password berhasil direset ke: pegawai123');
        }

        return back()->with('error', 'Akun user belum terhubung dengan pegawai ini.');
    }

}

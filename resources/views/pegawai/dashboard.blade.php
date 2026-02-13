<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Dashboard Pegawai</h2>
                <p class="text-sm text-gray-500 mt-1">Sistem Informasi Manajemen Pegawai</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                    {{ now()->locale('id')->isoFormat('dddd') }}
                </p>
                <p class="text-sm text-gray-700 font-bold">
                    {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-gray-200 p-8">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $user->name }}</h3>
                    <p class="text-sm text-gray-600 max-w-2xl mb-6">
                        Pantau data profil, cuti, dan kehadiran Anda secara lengkap dari satu halaman dashboard.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pegawai.cuti.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold text-sm rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Ajukan Cuti</a>
                        <a href="{{ route('pegawai.cuti.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-50 transition-colors">Riwayat Cuti</a>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-indigo-300 text-indigo-700 font-semibold text-sm rounded-lg hover:bg-indigo-50 transition-colors">Ubah Profil</a>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                        <span class="text-white font-bold text-xl">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:col-span-2">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Ringkasan Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="rounded-lg border border-emerald-200 p-4 bg-emerald-50">
                        <p class="text-xs font-semibold text-emerald-700 uppercase">Cuti Disetujui</p>
                        <p class="text-2xl font-bold text-emerald-900 mt-1">{{ $totalCutiDisetujui }}</p>
                    </div>
                    <div class="rounded-lg border border-amber-200 p-4 bg-amber-50">
                        <p class="text-xs font-semibold text-amber-700 uppercase">Cuti Pending</p>
                        <p class="text-2xl font-bold text-amber-900 mt-1">{{ $totalCutiPending }}</p>
                    </div>
                    <div class="rounded-lg border border-red-200 p-4 bg-red-50">
                        <p class="text-xs font-semibold text-red-700 uppercase">Cuti Ditolak</p>
                        <p class="text-2xl font-bold text-red-900 mt-1">{{ $totalCutiDitolak }}</p>
                    </div>
                    <div class="rounded-lg border border-indigo-200 p-4 bg-indigo-50">
                        <p class="text-xs font-semibold text-indigo-700 uppercase">Hadir Bulan Ini</p>
                        <p class="text-2xl font-bold text-indigo-900 mt-1">{{ $totalHadirBulanIni }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Informasi Cuti</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3">
                        <span class="text-sm text-gray-600">Kuota Cuti</span>
                        <span class="text-sm font-bold text-gray-900">{{ $kuotaCuti }} hari</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 px-4 py-3 border border-emerald-200">
                        <span class="text-sm text-emerald-700">Sisa Cuti</span>
                        <span class="text-sm font-bold text-emerald-900">{{ $sisaCuti }} hari</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                        @php
                            $persenCuti = $kuotaCuti > 0 ? max(0, min(100, round(($sisaCuti / $kuotaCuti) * 100))) : 0;
                        @endphp
                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $persenCuti }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500">Sisa cuti Anda saat ini: {{ $persenCuti }}% dari kuota tahunan.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Profil Pegawai</h3>
                @if($pegawai)
                    <div class="space-y-3 text-sm">
                        <div><span class="text-gray-500">NIP:</span> <span class="font-semibold text-gray-900">{{ $pegawai->nip }}</span></div>
                        <div><span class="text-gray-500">Nama:</span> <span class="font-semibold text-gray-900">{{ $pegawai->nama_lengkap }}</span></div>
                        <div><span class="text-gray-500">Jabatan:</span> <span class="font-semibold text-gray-900">{{ $pegawai->jabatan ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Departemen:</span> <span class="font-semibold text-gray-900">{{ $pegawai->departemen ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Status:</span> <span class="font-semibold text-gray-900 capitalize">{{ $pegawai->status_kepegawaian ?? '-' }}</span></div>
                        <div><span class="text-gray-500">No Telepon:</span> <span class="font-semibold text-gray-900">{{ $pegawai->no_telepon ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Email:</span> <span class="font-semibold text-gray-900">{{ $user->email ?? '-' }}</span></div>
                    </div>
                @else
                    <p class="text-sm text-red-600">Data pegawai belum terhubung ke akun Anda.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:col-span-2">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Rekap Kehadiran Bulan Ini</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-center">
                        <p class="text-xs text-emerald-700 font-semibold uppercase">Hadir</p>
                        <p class="text-2xl font-bold text-emerald-900 mt-1">{{ $kehadiranBulanIni['hadir'] }}</p>
                    </div>
                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-4 text-center">
                        <p class="text-xs text-amber-700 font-semibold uppercase">Izin</p>
                        <p class="text-2xl font-bold text-amber-900 mt-1">{{ $kehadiranBulanIni['izin'] }}</p>
                    </div>
                    <div class="rounded-lg bg-orange-50 border border-orange-200 p-4 text-center">
                        <p class="text-xs text-orange-700 font-semibold uppercase">Sakit</p>
                        <p class="text-2xl font-bold text-orange-900 mt-1">{{ $kehadiranBulanIni['sakit'] }}</p>
                    </div>
                    <div class="rounded-lg bg-red-50 border border-red-200 p-4 text-center">
                        <p class="text-xs text-red-700 font-semibold uppercase">Alpha</p>
                        <p class="text-2xl font-bold text-red-900 mt-1">{{ $kehadiranBulanIni['alpha'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">5 Pengajuan Cuti Terbaru</h3>
                <div class="space-y-3">
                    @forelse($riwayatCutiTerbaru as $item)
                        <div class="rounded-lg border border-gray-200 px-4 py-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900">{{ $item->jenis_cuti ?? 'Cuti' }}</p>
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $item->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }} ({{ $item->jumlah_hari }} hari)</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada data pengajuan cuti.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">7 Catatan Kehadiran Terbaru</h3>
                <div class="space-y-3">
                    @forelse($riwayatKehadiranTerbaru as $item)
                        <div class="rounded-lg border border-gray-200 px-4 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $item->keterangan ?? '-' }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full capitalize
                                {{ $item->status === 'hadir' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'izin' ? 'bg-amber-100 text-amber-800' : ($item->status === 'sakit' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $item->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada data kehadiran.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

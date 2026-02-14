{{-- resources/views/admin/cuti/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pengajuan Cuti
            </h2>
            <a href="{{ route('admin.cuti.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tutup
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="this.closest('.mb-6').remove()" class="ml-auto text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                    <button type="button" onclick="this.closest('.mb-6').remove()" class="ml-auto text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Status Badge Header --}}
        <div class="mb-6">
            @php
                $st = strtolower($cuti->status);
                $statusConfig = match($st) {
                    'pending' => [
                        'class' => 'bg-amber-100 border-amber-300 text-amber-900',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                        'label' => 'Menunggu Persetujuan'
                    ],
                    'disetujui' => [
                        'class' => 'bg-green-100 border-green-300 text-green-900',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'label' => 'Disetujui'
                    ],
                    'ditolak' => [
                        'class' => 'bg-red-100 border-red-300 text-red-900',
                        'icon' => 'M6 18L18 6M6 6l12 12',
                        'label' => 'Ditolak'
                    ],
                    default => [
                        'class' => 'bg-gray-100 border-gray-300 text-gray-900',
                        'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'label' => ucfirst($cuti->status)
                    ],
                };
            @endphp

            <div class="bg-white border-2 {{ $statusConfig['class'] }} rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center border-2 {{ $statusConfig['class'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider opacity-75">Status Pengajuan</p>
                        <p class="text-lg font-bold">{{ $statusConfig['label'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Data Pegawai --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Data Pegawai
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $cuti->pegawai->nama_lengkap }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</label>
                            <p class="mt-1 text-sm font-mono text-gray-900">{{ $cuti->pegawai->nip }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $cuti->pegawai->jabatan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $cuti->pegawai->departemen ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Cuti</label>
                            <p class="mt-1 text-sm font-semibold text-emerald-700">{{ $cuti->pegawai->sisa_cuti }} hari (kuota: {{ $cuti->pegawai->kuota_cuti }} hari)</p>
                        </div>
                    </div>
                </div>

                {{-- Detail Cuti --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Detail Pengajuan Cuti
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Cuti</label>
                            <div class="mt-1 flex items-center gap-2 text-sm">
                                <span class="font-mono bg-gray-100 px-3 py-1.5 rounded text-gray-900">
                                    {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }}
                                </span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                                <span class="font-mono bg-gray-100 px-3 py-1.5 rounded text-gray-900">
                                    {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}
                                </span>
                            </div>
                            @php
                                $durasi = \Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1;
                            @endphp
                            <p class="mt-1 text-xs text-gray-500">Durasi: {{ $durasi }} hari</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $cuti->jenis_cuti ?? '-' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan Pengajuan</label>
                            <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded border border-gray-200">
                                {{ $cuti->alasan ?? '-' }}
                            </p>
                        </div>

                        @if($cuti->catatan_admin)
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Admin</label>
                                <p class="mt-1 text-sm text-gray-900 bg-blue-50 p-3 rounded border border-blue-200">
                                    {{ $cuti->catatan_admin }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar: Action Panel --}}
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Tindakan Admin
                    </h3>

                    @if($cuti->status === 'pending')
                        <form action="{{ route('admin.cuti.updateStatus', $cuti) }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Keputusan</label>
                                <select name="status" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="disetujui">✓ Setujui Pengajuan</option>
                                    <option value="ditolak">✗ Tolak Pengajuan</option>
                                </select>
                                <p class="mt-1.5 text-xs text-gray-500">
                                    Setelah disimpan, keputusan bersifat final dan tidak dapat diubah.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin (opsional)</label>
                                <textarea name="catatan_admin" 
                                          rows="4"
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                          placeholder="Tambahkan catatan atau keterangan tambahan...">{{ $cuti->catatan_admin }}</textarea>
                            </div>

                            <div class="pt-4 border-t border-gray-200 space-y-2">
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Keputusan
                                </button>
                                <a href="{{ route('admin.cuti.index') }}" 
                                   class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Kembali
                                </a>
                            </div>
                        </form>

                    @else
                        <div class="space-y-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start gap-3 mb-3">
                                    <svg class="w-5 h-5 text-gray-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 mb-1">Status Final</p>
                                        <p class="text-sm text-gray-700">
                                            Pengajuan ini telah 
                                            <span class="font-semibold capitalize">{{ $cuti->status }}</span>
                                        </p>
                                    </div>
                                </div>

                                @if($cuti->catatan_admin)
                                    <div class="pt-3 border-t border-gray-300">
                                        <p class="text-xs font-medium text-gray-600 mb-1">Catatan Admin:</p>
                                        <p class="text-sm text-gray-900">{{ $cuti->catatan_admin }}</p>
                                    </div>
                                @endif

                                <div class="mt-3 pt-3 border-t border-gray-300">
                                    <p class="text-xs text-gray-600 flex items-start gap-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Keputusan ini bersifat final dan tidak dapat diubah.</span>
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('admin.cuti.index') }}" 
                               class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Daftar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Back Link --}}
        <div class="mt-6">
            <a href="{{ route('admin.cuti.index') }}" 
               class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke daftar pengajuan cuti
            </a>
        </div>
    </div>
</x-app-layout>

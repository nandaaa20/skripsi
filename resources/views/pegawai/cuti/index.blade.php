<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Cuti Saya
            </h2>
            <a href="{{ route('pegawai.cuti.create') }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajukan Cuti
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
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

        {{-- Stats Summary --}}
        @if($cuti->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pending</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $cuti->where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $cuti->where('status', 'disetujui')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Ditolak</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $cuti->where('status', 'ditolak')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Riwayat Cuti</h3>
                <p class="text-sm text-gray-500 mt-0.5">Total {{ $cuti->count() }} pengajuan cuti</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Durasi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alasan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($cuti as $c)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1">
                                            <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">
                                                {{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d M Y') }}
                                            </span>
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                            <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">
                                                {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        // Hitung jumlah hari kerja (exclude weekend)
                                        $start = \Carbon\Carbon::parse($c->tanggal_mulai);
                                        $end = \Carbon\Carbon::parse($c->tanggal_selesai);
                                        $jumlahHariKerja = 0;
                                        $currentDate = $start->copy();
                                        
                                        while ($currentDate->lte($end)) {
                                            if (!$currentDate->isWeekend()) {
                                                $jumlahHariKerja++;
                                            }
                                            $currentDate->addDay();
                                        }
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-800 text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $c->jumlah_hari ?? $jumlahHariKerja }} hari
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-medium">
                                        {{ $c->jenis_cuti ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $status = strtolower($c->status);
                                        $statusConfig = match($status) {
                                            'pending' => [
                                                'class' => 'bg-amber-100 text-amber-900',
                                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'disetujui' => [
                                                'class' => 'bg-green-100 text-green-900',
                                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'ditolak' => [
                                                'class' => 'bg-red-100 text-red-800',
                                                'icon' => 'M6 18L18 6M6 6l12 12'
                                            ],
                                            default => [
                                                'class' => 'bg-gray-100 text-gray-700',
                                                'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ]
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig['class'] }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"/>
                                        </svg>
                                        {{ ucfirst($c->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="max-w-xs">
                                        <p class="text-xs text-gray-700 line-clamp-2">
                                            {{ $c->alasan ?? '-' }}
                                        </p>
                                        @if($c->catatan_admin)
                                            <p class="text-xs text-blue-600 mt-1 italic">
                                                Admin: {{ $c->catatan_admin }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <h4 class="text-lg font-medium text-gray-900 mb-1">Belum ada pengajuan cuti</h4>
                                        <p class="text-sm mb-4">Mulai ajukan cuti untuk merencanakan waktu istirahat Anda.</p>
                                        <a href="{{ route('pegawai.cuti.create') }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Ajukan Cuti Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Info Note --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900 mb-1">Informasi Penting</p>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• Durasi cuti hanya menghitung hari kerja (Senin-Jumat), weekend tidak dihitung</li>
                        <li>• Status "Pending" berarti pengajuan sedang menunggu persetujuan admin</li>
                        <li>• Catatan admin akan muncul jika ada keterangan tambahan dari admin kepegawaian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

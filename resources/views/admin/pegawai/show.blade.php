<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pegawai
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        {{-- Header Card --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h3 class="text-2xl font-bold">{{ $pegawai->nama_lengkap }}</h3>
                        <p class="text-blue-100 mt-1">{{ $pegawai->nip }}</p>
                    </div>

                    <div class="flex gap-3">
                        {{-- Tombol Edit Data --}}
                        <a href="{{ route('admin.pegawai.edit', $pegawai) }}"
                           class="px-5 py-2.5 bg-white text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT SIDE --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Data Pegawai --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Data Pegawai
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">NIP</label>
                            <p class="mt-1 text-gray-900">{{ $pegawai->nip }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Nama Lengkap</label>
                            <p class="mt-1 text-gray-900">{{ $pegawai->nama_lengkap }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Jabatan</label>
                            <p class="mt-1 text-gray-900">{{ $pegawai->jabatan ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Departemen</label>
                            <p class="mt-1 text-gray-900">{{ $pegawai->departemen ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Status Kepegawaian</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ ($pegawai->status_kepegawaian ?? 'aktif') === 'aktif'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($pegawai->status_kepegawaian ?? 'aktif') }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Tanggal Masuk</label>
                            <p class="mt-1 text-gray-900">
                                {{ $pegawai->tanggal_masuk
                                    ? \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d M Y')
                                    : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Informasi Kontak
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">No. Telepon</label>
                            <p class="mt-1 text-gray-900">{{ $pegawai->no_telepon ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Alamat</label>
                            <p class="mt-1 text-gray-900">{{ $pegawai->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="lg:col-span-1">

                {{-- Akun Login --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Akun Login
                    </h3>

                    @if($pegawai->user)
                        <div class="space-y-4">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-xs font-medium text-green-800">Akun Terhubung</span>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-600">Username (NIP)</label>
                                        <p class="mt-0.5 text-sm text-gray-900 font-medium">
                                            {{ $pegawai->user->nip }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="text-xs font-medium text-gray-600">Nama User</label>
                                        <p class="mt-0.5 text-sm text-gray-900">
                                            {{ $pegawai->user->name }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="text-xs font-medium text-gray-600">Email</label>
                                        <p class="mt-0.5 text-sm text-gray-900">
                                            {{ $pegawai->user->email ?? '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="text-xs font-medium text-gray-600">Role</label>
                                        <p class="mt-0.5">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($pegawai->user->role) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                {{-- Reset Password --}}
                                <div class="mt-4 pt-3 border-t border-dashed border-green-200">
                                    <form method="POST"
                                          action="{{ route('admin.pegawai.reset-password', $pegawai) }}"
                                          onsubmit="return confirm('Reset password akun ini ke password default?');">
                                        @csrf
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-amber-600 text-white hover:bg-amber-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 11c0-1.105.895-2 2-2h4V7a5 5 0 00-9.584-1.761M9 11H7a2 2 0 00-2 2v4h6m2-4v6m0 0l-2-2m2 2l2-2"/>
                                            </svg>
                                            Reset Password ke Default
                                        </button>
                                    </form>
                                    <p class="mt-2 text-[11px] text-gray-500">
                                        Password akan diset menjadi password default yang telah ditentukan.
                                    </p>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- Tidak ada akun --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>

                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Akun Belum Terhubung</p>
                                    <p class="mt-1 text-xs text-yellow-700">
                                        Akun login belum dibuat untuk pegawai ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="mt-6">
            <a href="{{ route('admin.pegawai.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke daftar pegawai
            </a>
        </div>

    </div>
</x-app-layout>

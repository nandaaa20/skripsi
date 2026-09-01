<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Input Kehadiran Pegawai
            </h2>
            <a href="{{ route('admin.kehadiran.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-red-800 mb-2">Terdapat kesalahan pada input:</p>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="this.closest('.mb-6').remove()" class="ml-auto text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Info Banner --}}
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-800">
                        Pastikan memilih tanggal dan pegawai yang tepat sebelum menyimpan data kehadiran.
                    </p>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Form Input Kehadiran</h3>
                        <p class="text-sm text-gray-600">Isi data kehadiran pegawai dengan lengkap dan akurat</p>
                    </div>
                </div>
            </div>

            {{-- Form Content --}}
            <form action="{{ route('admin.kehadiran.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="date" 
                               name="tanggal" 
                               value="{{ old('tanggal', $tanggalDefault) }}" 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tanggal') border-red-500 @enderror"
                               required>
                    </div>
                    @error('tanggal')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-xs text-gray-500">
                        Pilih tanggal kehadiran yang akan diinput
                    </p>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200"></div>

                {{-- Pegawai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pegawai <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <select name="nip" 
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none @error('nip') border-red-500 @enderror"
                                required>
                            <option value="">- Pilih Pegawai -</option>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->nip }}" @selected(old('nip') == $p->nip)>
                                    {{ $p->nama_lengkap }} ({{ $p->nip }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('nip')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-xs text-gray-500">
                        Pilih pegawai yang akan diinput kehadirannya
                    </p>
                </div>

                {{-- Status Kehadiran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Kehadiran <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="relative flex cursor-pointer">
                            <input type="radio" 
                                   name="status" 
                                   value="hadir" 
                                   class="peer sr-only" 
                                   @checked(old('status', 'hadir') == 'hadir')>
                            <div class="w-full flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center peer-checked:bg-green-200">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Hadir</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer">
                            <input type="radio" 
                                   name="status" 
                                   value="izin" 
                                   class="peer sr-only" 
                                   @checked(old('status') == 'izin')>
                            <div class="w-full flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 transition-all">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center peer-checked:bg-blue-200">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Izin</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer">
                            <input type="radio" 
                                   name="status" 
                                   value="sakit" 
                                   class="peer sr-only" 
                                   @checked(old('status') == 'sakit')>
                            <div class="w-full flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-gray-300 transition-all">
                                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center peer-checked:bg-amber-200">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Sakit</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer">
                            <input type="radio" 
                                   name="status" 
                                   value="alpha" 
                                   class="peer sr-only" 
                                   @checked(old('status') == 'alpha')>
                            <div class="w-full flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300 transition-all">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center peer-checked:bg-red-200">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Alpha</span>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan (opsional)
                    </label>
                    <textarea name="keterangan" 
                              rows="4"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none @error('keterangan') border-red-500 @enderror"
                              placeholder="Tambahkan keterangan atau catatan tambahan jika diperlukan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-xs text-gray-500">
                        Contoh: Sedang dinas luar, Sakit demam, dll.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.kehadiran.index') }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        {{-- Help Section --}}
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Panduan Pengisian</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Pilih tanggal sesuai dengan hari kehadiran yang akan diinput</li>
                        <li>• Pilih pegawai dari daftar dropdown yang tersedia</li>
                        <li>• Pilih status kehadiran: Hadir (masuk kerja), Izin (ada izin tertulis), Sakit (sakit dengan/tanpa surat dokter), atau Alpha (tidak hadir tanpa keterangan)</li>
                        <li>• Tambahkan keterangan jika diperlukan untuk dokumentasi lebih lengkap</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

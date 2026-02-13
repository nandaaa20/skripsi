<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ajukan Cuti
            </h2>
            <a href="{{ route('pegawai.cuti.index') }}" 
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
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-emerald-800">
                        Pastikan mengisi semua informasi dengan lengkap dan akurat. Cuti hanya dapat diajukan untuk hari kerja (Senin-Jumat), weekend tidak dihitung.
                    </p>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Form Pengajuan Cuti</h3>
                        <p class="text-sm text-gray-600">Isi formulir berikut untuk mengajukan cuti</p>
                    </div>
                </div>
            </div>

            {{-- Form Content --}}
            <form action="{{ route('pegawai.cuti.store') }}" method="POST" class="p-6 space-y-6" id="cutiForm">
                @csrf

                {{-- Periode Cuti --}}
                <div>
                    <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Periode Cuti
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="date" 
                                       name="tanggal_mulai" 
                                       id="tanggal_mulai"
                                       value="{{ old('tanggal_mulai') }}" 
                                       min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tanggal_mulai') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('tanggal_mulai')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="date" 
                                       name="tanggal_selesai" 
                                       id="tanggal_selesai"
                                       value="{{ old('tanggal_selesai') }}" 
                                       min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tanggal_selesai') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('tanggal_selesai')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Info Durasi Hari Kerja --}}
                    <div id="info-hari-kerja" class="mt-3 hidden">
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-indigo-900" id="durasi-text"></p>
                                    <p class="text-xs text-indigo-700 mt-0.5">Weekend (Sabtu & Minggu) tidak dihitung sebagai hari cuti</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Pilih tanggal mulai dan selesai cuti. Tanggal mulai dan selesai harus hari kerja (Senin-Jumat).
                    </p>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200"></div>

                {{-- Jenis Cuti --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Cuti <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <select name="jenis_cuti" 
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none @error('jenis_cuti') border-red-500 @enderror"
                                required>
                            <option value="">- Pilih Jenis Cuti -</option>
                            <option value="Cuti Tahunan" @selected(old('jenis_cuti') == 'Cuti Tahunan')>Cuti Tahunan</option>
                            <option value="Cuti Sakit" @selected(old('jenis_cuti') == 'Cuti Sakit')>Cuti Sakit</option>
                            <option value="Cuti Melahirkan" @selected(old('jenis_cuti') == 'Cuti Melahirkan')>Cuti Melahirkan</option>
                            <option value="Cuti Menikah" @selected(old('jenis_cuti') == 'Cuti Menikah')>Cuti Menikah</option>
                            <option value="Cuti Besar" @selected(old('jenis_cuti') == 'Cuti Besar')>Cuti Besar</option>
                            <option value="Cuti Khusus" @selected(old('jenis_cuti') == 'Cuti Khusus')>Cuti Khusus</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('jenis_cuti')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        Pilih jenis cuti sesuai dengan keperluan
                    </p>
                </div>

                {{-- Alasan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Pengajuan Cuti <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan" 
                              rows="5"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none @error('alasan') border-red-500 @enderror"
                              placeholder="Jelaskan alasan pengajuan cuti secara detail..."
                              required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        Contoh: Keperluan keluarga, liburan tahunan, sakit, dll.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('pegawai.cuti.index') }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>

        {{-- Help Section --}}
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Panduan Pengajuan Cuti</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Tanggal mulai dan selesai cuti harus hari kerja (Senin-Jumat)</li>
                        <li>• Weekend (Sabtu & Minggu) di antara periode cuti tidak dihitung sebagai hari cuti</li>
                        <li>• Tanggal cuti tidak boleh di masa lampau, minimal hari ini</li>
                        <li>• Pilih jenis cuti sesuai dengan keperluan (tahunan, sakit, khusus, dll.)</li>
                        <li>• Jelaskan alasan pengajuan cuti dengan jelas dan lengkap</li>
                        <li>• Pengajuan akan diproses oleh admin kepegawaian dan status dapat dipantau di menu "Riwayat Cuti"</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript untuk validasi dan hitung hari kerja --}}
    <script>
        function hitungHariKerja() {
            const tanggalMulai = document.getElementById('tanggal_mulai').value;
            const tanggalSelesai = document.getElementById('tanggal_selesai').value;
            const infoDiv = document.getElementById('info-hari-kerja');
            const durasiText = document.getElementById('durasi-text');
            
            if (!tanggalMulai || !tanggalSelesai) {
                infoDiv.classList.add('hidden');
                return;
            }
            
            const start = new Date(tanggalMulai);
            const end = new Date(tanggalSelesai);
            
            if (end < start) {
                infoDiv.classList.add('hidden');
                return;
            }
            
            let jumlahHariKerja = 0;
            let current = new Date(start);
            
            while (current <= end) {
                const dayOfWeek = current.getDay();
                // 0 = Minggu, 6 = Sabtu, jadi hitung hanya 1-5 (Senin-Jumat)
                if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                    jumlahHariKerja++;
                }
                current.setDate(current.getDate() + 1);
            }
            
            // Tampilkan info
            infoDiv.classList.remove('hidden');
            durasiText.textContent = `Durasi Cuti: ${jumlahHariKerja} hari kerja`;
        }

        document.getElementById('tanggal_mulai').addEventListener('change', function() {
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            tanggalSelesai.min = this.value;
            
            // Reset tanggal selesai jika lebih kecil dari tanggal mulai
            if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                tanggalSelesai.value = '';
            }
            
            hitungHariKerja();
        });
        
        document.getElementById('tanggal_selesai').addEventListener('change', hitungHariKerja);

        // Validasi weekend untuk tanggal mulai dan selesai
        document.getElementById('cutiForm').addEventListener('submit', function(e) {
            const tanggalMulai = new Date(document.getElementById('tanggal_mulai').value);
            const tanggalSelesai = new Date(document.getElementById('tanggal_selesai').value);
            
            // Cek apakah tanggal mulai adalah weekend (0 = Minggu, 6 = Sabtu)
            if (tanggalMulai.getDay() === 0 || tanggalMulai.getDay() === 6) {
                e.preventDefault();
                alert('Tanggal mulai cuti harus di hari kerja (Senin-Jumat), tidak boleh di akhir pekan.');
                return false;
            }
            
            // Cek apakah tanggal selesai adalah weekend
            if (tanggalSelesai.getDay() === 0 || tanggalSelesai.getDay() === 6) {
                e.preventDefault();
                alert('Tanggal selesai cuti harus di hari kerja (Senin-Jumat), tidak boleh di akhir pekan.');
                return false;
            }
        });
    </script>
</x-app-layout>

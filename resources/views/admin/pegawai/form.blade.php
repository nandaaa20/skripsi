{{-- admin/pegawai/form.blade.php --}}
<form action="{{ $action }}" method="POST" class="max-w-6xl">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- Section Header --}}
    <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg border border-gray-200 p-5 mb-6">
        <h3 class="text-lg font-bold text-gray-900">{{ isset($pegawai) ? 'Edit Data Pegawai' : 'Tambah Data Pegawai' }}</h3>
        <p class="text-sm text-gray-600 mt-1">Lengkapi formulir di bawah ini dengan data yang valid</p>
    </div>

    {{-- Main Form Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        {{-- Kolom Kiri --}}
        <div class="space-y-6">
            
            {{-- Data Pribadi --}}
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Data Pribadi
                </h4>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nip') border-red-500 @enderror"
                               placeholder="Masukkan NIP" required>
                        @error('nip')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap" required>
                        @error('nama_lengkap')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_kelamin') border-red-500 @enderror" required>
                                <option value="">- Pilih -</option>
                                <option value="L" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin ?? '')=='L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin ?? '')=='P')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_lahir') border-red-500 @enderror">
                            @error('tanggal_lahir')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Kontak --}}
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    Informasi Kontak
                </h4>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $pegawai->no_telepon ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_telepon') border-red-500 @enderror"
                               placeholder="Contoh: 081234567890">
                        @error('no_telepon')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email', $pegawai->user->email ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="contoh: pegawai@email.com">
                        @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-xs text-gray-500">Email ini dipakai untuk notifikasi pengajuan dan keputusan cuti.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none @error('alamat') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
                        @error('alamat')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-6">
            
            {{-- Data Kepegawaian --}}
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    Data Kepegawaian
                </h4>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jabatan</label>
                        <select name="jabatan" class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jabatan') border-red-500 @enderror">
                            <option value="">- Pilih Jabatan -</option>
                            @foreach($listJabatan as $jab)
                                <option value="{{ $jab }}" @selected(old('jabatan', $pegawai->jabatan ?? '') == $jab)>{{ $jab }}</option>
                            @endforeach
                        </select>
                        @error('jabatan')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Departemen</label>
                        <select name="departemen" class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('departemen') border-red-500 @enderror">
                            <option value="">- Pilih Departemen -</option>
                            @foreach($listDepartemen as $dep)
                                <option value="{{ $dep }}" @selected(old('departemen', $pegawai->departemen ?? '') == $dep)>{{ $dep }}</option>
                            @endforeach
                        </select>
                        @error('departemen')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                            <select name="status_kepegawaian" class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status_kepegawaian') border-red-500 @enderror" required>
                                <option value="aktif" @selected(old('status_kepegawaian', $pegawai->status_kepegawaian ?? 'aktif')=='aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status_kepegawaian', $pegawai->status_kepegawaian ?? '')=='nonaktif')>Nonaktif</option>
                                <option value="kontrak" @selected(old('status_kepegawaian', $pegawai->status_kepegawaian ?? '')=='kontrak')>Kontrak</option>
                            </select>
                            @error('status_kepegawaian')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_masuk') border-red-500 @enderror">
                            @error('tanggal_masuk')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-blue-900 mb-1">Informasi Penting</p>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>• Field bertanda <span class="text-red-600 font-bold">*</span> wajib diisi</li>
                            <li>• Pastikan NIP unik dan tidak duplikat</li>
                            <li>• Data akan tersimpan otomatis setelah submit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between bg-gray-50 rounded-lg border border-gray-200 p-4">
        <p class="text-sm text-gray-600">
            <span class="text-red-500 font-bold">*</span> Field wajib diisi
        </p>
        <div class="flex gap-3">
            <a href="{{ route('admin.pegawai.index') }}" 
               class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm shadow-sm">
                {{ $buttonLabel }}
            </button>
        </div>
    </div>
</form>

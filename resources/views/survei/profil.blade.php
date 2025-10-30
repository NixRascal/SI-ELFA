@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col bg-gray-50">
    <div class="flex-1 flex items-center justify-center px-4 sm:px-0">
        <div class="bg-white w-full max-w-2xl mx-auto p-6 sm:p-8 rounded-xl shadow-sm border border-gray-200">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Profil Responden</h1>
            <p class="mt-2 text-gray-600">Isi profil Anda sebelum menjawab survei</p>
        </div>

        @if (session('error'))
            <div class="mx-auto mt-6 max-w-xl bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Anda sudah pernah mengisi survei ini. Silakan pilih survei lainnya atau hubungi admin jika ada kesalahan.</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('beranda') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mx-auto mt-6 max-w-xl bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </h3>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('survei.profil.simpan', $kuesioner->id) }}" method="POST" class="mx-auto mt-10 max-w-xl">
            @csrf
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900">Jenis Responden <span class="text-red-600">*</span></label>
                    <select name="jenis_responden"
                        class="mt-2 block w-full rounded-md border @error('jenis_responden') border-red-500 @else border-gray-300 @enderror px-3.5 py-2 focus:outline-2 focus:outline-indigo-600">
                        <option value="">Pilih jenis responden</option>
                        <option value="mahasiswa" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'mahasiswa')>Mahasiswa</option>
                        <option value="dosen" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'dosen')>Dosen</option>
                        <option value="staff" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'staff')>Staff</option>
                        <option value="alumni" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'alumni')>Alumni</option>
                        <option value="stakeholder" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'stakeholder')>Stakeholder</option>
                    </select>
                    @error('jenis_responden')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900">Nama <span class="text-red-600">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $profil['nama'] ?? '') }}"
                        class="mt-2 block w-full rounded-md border @error('nama') border-red-500 @else border-gray-300 @enderror px-3.5 py-2 focus:outline-indigo-600"
                        >
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900">NPM</label>
                    <input type="text" name="npm" value="{{ old('npm', $profil['npm'] ?? '') }}"
                        class="mt-2 block w-full rounded-md border @error('npm') border-red-500 @else border-gray-300 @enderror px-3.5 py-2"
                        >
                    @error('npm')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $profil['email'] ?? '') }}"
                        class="mt-2 block w-full rounded-md border @error('email') border-red-500 @else border-gray-300 @enderror px-3.5 py-2"
                        >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900">Fakultas <span class="text-red-600">*</span></label>
                    <select name="fakultas"
                        class="mt-2 block w-full rounded-md border @error('fakultas') border-red-500 @else border-gray-300 @enderror px-3.5 py-2 focus:outline-2 focus:outline-indigo-600">
                        <option value="">Pilih fakultas</option>
                        <option value="FKIP" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FKIP')>FKIP</option>
                        <option value="FH" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FH')>FH</option>
                        <option value="FEB" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FEB')>FEB</option>
                        <option value="FISIP" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FISIP')>FISIP</option>
                        <option value="FP" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FP')>FP</option>
                        <option value="FMIPA" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FMIPA')>FMIPA</option>
                        <option value="FT" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FT')>FT</option>
                        <option value="FKIK" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FKIK')>FKIK</option>
                    </select>
                    @error('fakultas')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900">Jurusan <span class="text-red-600">*</span></label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $profil['jurusan'] ?? '') }}"
                        class="mt-2 block w-full rounded-md border @error('jurusan') border-red-500 @else border-gray-300 @enderror px-3.5 py-2"
                        >
                    @error('jurusan')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex justify-between">
                <a href="{{ url('/') }}"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">Kembali</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500">Lanjut
                    ke pertanyaan</button>
            </div>

        </form>
        </div>
    </div>
    <div class="mt-auto">
        @include('layouts.footer')
    </div>
</div>
@endsection

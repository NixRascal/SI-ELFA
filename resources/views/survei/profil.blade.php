<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <title>Profil Responden — {{ $kuesioner->judul }}</title>
</head>
<body class="bg-gray-50">
<div class="isolate bg-white px-6 py-16 sm:py-20 lg:px-8">
  <div class="mx-auto max-w-2xl text-center">
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Profil Responden</h1>
    <p class="mt-2 text-gray-600">Isi profil Anda sebelum menjawab survei</p>
  </div>

  <form action="{{ route('survei.profil.simpan', $kuesioner->id) }}" method="POST" class="mx-auto mt-10 max-w-xl">
    @csrf
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
      
      <div class="sm:col-span-2">
        <label class="block text-sm font-semibold text-gray-900">Jenis Responden</label>
        <select name="jenis_responden" class="mt-2 block w-full rounded-md border border-gray-300 px-3.5 py-2 focus:outline-2 focus:outline-indigo-600">
          <option value="">Pilih jenis responden</option>
          <option value="mahasiswa" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'mahasiswa')>Mahasiswa</option>
          <option value="dosen" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'dosen')>Dosen</option>
          <option value="staff" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'staff')>Staff</option>
          <option value="alumni" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'alumni')>Alumni</option>
          <option value="stakeholder" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === 'stakeholder')>Stakeholder</option>
        </select>
        @error('jenis_responden') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="sm:col-span-2">
        <label class="block text-sm font-semibold text-gray-900">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $profil['nama'] ?? '') }}" class="mt-2 block w-full rounded-md border border-gray-300 px-3.5 py-2 focus:outline-indigo-600">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900">NPM</label>
        <input type="text" name="npm" value="{{ old('npm', $profil['npm'] ?? '') }}" class="mt-2 block w-full rounded-md border border-gray-300 px-3.5 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900">Email</label>
        <input type="email" name="email" value="{{ old('email', $profil['email'] ?? '') }}" class="mt-2 block w-full rounded-md border border-gray-300 px-3.5 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900">Fakultas</label>
        <input type="text" name="fakultas" value="{{ old('fakultas', $profil['fakultas'] ?? '') }}" class="mt-2 block w-full rounded-md border border-gray-300 px-3.5 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900">Jurusan</label>
        <input type="text" name="jurusan" value="{{ old('jurusan', $profil['jurusan'] ?? '') }}" class="mt-2 block w-full rounded-md border border-gray-300 px-3.5 py-2">
      </div>

    </div>

    <div class="mt-8 flex justify-between">
      <a href="{{ url('/') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">Kembali</a>
      <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500">Lanjut ke pertanyaan</button>
    </div>
  </form>
</div>
</body>
</html>

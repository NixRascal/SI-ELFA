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
                    <select name="fakultas" id="fakultas"
                        class="mt-2 block w-full rounded-md border @error('fakultas') border-red-500 @else border-gray-300 @enderror px-3.5 py-2 focus:outline-2 focus:outline-indigo-600">
                        <option value="">Pilih fakultas</option>
                        <option value="FKIP" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FKIP')>Fakultas Keguruan dan Ilmu Pendidikan</option>
                        <option value="FH" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FH')>Fakultas Hukum</option>
                        <option value="FEB" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FEB')>Fakultas Ekonomi dan Bisnis</option>
                        <option value="FISIP" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FISIP')>Fakultas Ilmu Sosial dan Ilmu Politik</option>
                        <option value="FP" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FP')>Fakultas Pertanian</option>
                        <option value="FMIPA" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FMIPA')>Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                        <option value="FT" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FT')>Fakultas Teknik</option>
                        <option value="FKIK" @selected(old('fakultas', $profil['fakultas'] ?? '') === 'FKIK')>Fakultas Kedokteran dan Ilmu Kesehatan</option>
                    </select>
                    @error('fakultas')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900">Jurusan <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $profil['jurusan'] ?? '') }}"
                            class="mt-2 block w-full rounded-md border @error('jurusan') border-red-500 @else border-gray-300 @enderror px-3.5 py-2"
                            placeholder="Pilih fakultas terlebih dahulu" autocomplete="off" readonly>
                        <div id="jurusanDropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                            <div class="sticky top-0 bg-white border-b border-gray-200 p-2">
                                <input type="text" id="jurusanSearch" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                    placeholder="Cari jurusan...">
                            </div>
                            <ul id="jurusanOptions" class="py-1">
                                <!-- Options will be populated by JavaScript -->
                            </ul>
                        </div>
                    </div>
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

<script>
// Data jurusan berdasarkan fakultas
const jurusanData = {
    'FKIP': [
        'D3 Bahasa Inggris',
        'Pendidikan Profesi Guru',
        'S1 Bimbingan dan Konseling',
        'S1 Pendidikan Bahasa Indonesia',
        'S1 Pendidikan Bahasa Inggris',
        'S1 Pendidikan Biologi',
        'S1 Pendidikan Fisika',
        'S1 Pendidikan Guru PAUD',
        'S1 Pendidikan Guru Sekolah Dasar',
        'S1 Pendidikan Jasmani',
        'S1 Pendidikan Kimia',
        'S1 Pendidikan Non Formal',
        'S1 Pendidikan Matematika',
        'S1 Pendidikan IPA',
        'S2 Administrasi Pendidikan',
        'S2 Pendidikan Bahasa Indonesia',
        'S2 Pendidikan Bahasa Inggris',
        'S2 Pendidikan Dasar',
        'S2 Pendidikan IPA',
        'S2 Pendidikan Matematika',
        'S2 Teknologi Pendidikan',
        'S3 Pendidikan',
        'S3 Linguistik Terapan'
    ],
    'FH': [
        'S1 Hukum',
        'S2 Hukum',
        'S2 Kenotariatan',
        'S3 Hukum'
    ],
    'FEB': [
        'D3 Akuntansi',
        'S1 Akuntansi',
        'S1 Ekonomi Pembangunan',
        'S1 Manajemen',
        'S2 Akuntansi',
        'S2 Manajemen',
        'S2 Ekonomi Terapan',
        'S3 Ekonomi',
        'S3 Manajemen'
    ],
    'FISIP': [
        'D3 Jurnalistik',
        'D3 Perpustakaan',
        'D3 Administrasi Perkantoran',
        'S1 Administrasi Publik',
        'S1 Kesejahteraan Sosial',
        'S1 Ilmu Komunikasi',
        'S1 Perpustakaan dan Sains Informasi',
        'S1 Jurnalistik',
        'S1 Sosiologi',
        'S2 Administrasi Publik',
        'S2 Kesejahteraan Sosial',
        'S2 Ilmu Komunikasi'
    ],
    'FP': [
        'S1 Agribisnis',
        'S1 Agroekoteknologi',
        'S1 Ilmu Kelautan',
        'S1 Ilmu Lingkungan',
        'S1 Ilmu Tanah',
        'S1 Kehutanan',
        'S1 Nutrisi dan Teknologi Pakan Ternak',
        'S1 Peternakan',
        'S1 Proteksi Tanaman',
        'S1 Sains Perikanan',
        'S1 Teknologi Industri Pertanian',
        'S2 Agribisnis',
        'S2 Agroekoteknologi',
        'S2 Pengelolaan Sumberdaya Alam',
        'S3 Ilmu Pertanian',
        'S3 Pengelolaan Sumber Daya Alam'
    ],
    'FMIPA': [
        'D3 Farmasi',
        'D3 Kebidanan',
        'D3 Keperawatan',
        'D3 Laboratorium Sains',
        'S1 Biologi',
        'S1 Fisika',
        'S1 Kimia',
        'S1 Matematika',
        'S1 Statistika',
        'S1 Geofisika',
        'S1 Farmasi',
        'S2 Kimia',
        'S2 Statistika',
        'S2 Biologi'
    ],
    'FT': [
        'S1 Arsitektur',
        'S1 Sistem Informasi',
        'S1 Teknik Elektro',
        'S1 Informatika',
        'S1 Teknik Mesin',
        'S1 Teknik Sipil',
        'S2 Teknik Mesin'
    ],
    'FKIK': [
        'Profesi Dokter',
        'S1 Kedokteran'
    ]
};

let currentJurusanList = [];

// Event listener untuk perubahan fakultas
document.getElementById('fakultas').addEventListener('change', function() {
    const fakultas = this.value;
    const jurusanInput = document.getElementById('jurusan');
    const jurusanDropdown = document.getElementById('jurusanDropdown');
    
    // Clear existing selection
    jurusanInput.value = '';
    jurusanDropdown.classList.add('hidden');
    
    if (fakultas && jurusanData[fakultas]) {
        // Enable jurusan input
        jurusanInput.disabled = false;
        jurusanInput.readOnly = false;
        jurusanInput.placeholder = 'Klik untuk memilih jurusan...';
        currentJurusanList = jurusanData[fakultas];
    } else {
        // Disable jurusan input if no fakultas selected
        jurusanInput.disabled = true;
        jurusanInput.readOnly = true;
        jurusanInput.placeholder = 'Pilih fakultas terlebih dahulu';
        currentJurusanList = [];
    }
});

// Toggle dropdown when clicking jurusan input
document.getElementById('jurusan').addEventListener('click', function() {
    if (!this.disabled && currentJurusanList.length > 0) {
        const dropdown = document.getElementById('jurusanDropdown');
        dropdown.classList.toggle('hidden');
        
        if (!dropdown.classList.contains('hidden')) {
            populateJurusanOptions(currentJurusanList);
            document.getElementById('jurusanSearch').focus();
        }
    }
});

// Search functionality
document.getElementById('jurusanSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const filteredList = currentJurusanList.filter(jurusan => 
        jurusan.toLowerCase().includes(searchTerm)
    );
    populateJurusanOptions(filteredList);
});

// Populate options
function populateJurusanOptions(jurusanList) {
    const optionsContainer = document.getElementById('jurusanOptions');
    optionsContainer.innerHTML = '';
    
    if (jurusanList.length === 0) {
        optionsContainer.innerHTML = '<li class="px-4 py-2 text-gray-500 text-sm">Tidak ada jurusan yang ditemukan</li>';
        return;
    }
    
    jurusanList.forEach(jurusan => {
        const li = document.createElement('li');
        li.className = 'px-4 py-2 hover:bg-indigo-50 cursor-pointer text-gray-800 text-sm transition-colors';
        li.textContent = jurusan;
        li.addEventListener('click', function() {
            document.getElementById('jurusan').value = jurusan;
            document.getElementById('jurusanDropdown').classList.add('hidden');
            document.getElementById('jurusanSearch').value = '';
        });
        optionsContainer.appendChild(li);
    });
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const jurusanInput = document.getElementById('jurusan');
    const jurusanDropdown = document.getElementById('jurusanDropdown');
    const jurusanSearch = document.getElementById('jurusanSearch');
    
    if (!jurusanInput.contains(e.target) && 
        !jurusanDropdown.contains(e.target) && 
        e.target !== jurusanSearch) {
        jurusanDropdown.classList.add('hidden');
        jurusanSearch.value = '';
    }
});

// Trigger change event on page load if fakultas is already selected
window.addEventListener('DOMContentLoaded', function() {
    const fakultasSelect = document.getElementById('fakultas');
    if (fakultasSelect.value) {
        fakultasSelect.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection

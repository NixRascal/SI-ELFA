@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl">
            <!-- Header Card -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-deep-sapphire-600 rounded-full mb-4">
                    <i class="fas fa-user-edit text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Profil Responden</h1>
                <p class="mt-2 text-base text-gray-600">Isi profil Anda sebelum menjawab survei</p>
            </div>

            <!-- Alert Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-semibold text-red-800">
                                {{ session('error') }}
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Anda sudah pernah mengisi survei ini. Silakan pilih survei lainnya atau hubungi admin jika ada kesalahan.</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('beranda') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-green-800">
                                {{ session('success') }}
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-visible">
                <div class="px-6 py-8 sm:px-10 sm:py-10">
                    <form action="{{ route('survei.profil.simpan', $kuesioner->id) }}" method="POST" id="profileForm">
                        @csrf
                        <div class="space-y-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Jenis Responden <span class="text-red-600">*</span></label>
                    <select name="jenis_responden" id="jenis_responden"
                        class="block w-full rounded-lg border @error('jenis_responden') border-red-500 @else border-gray-300 @enderror px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 focus:border-transparent transition-all">
                        <option value="">Pilih jenis responden</option>
                        @foreach($kuesioner->target_responden as $target)
                            <option value="{{ $target }}" @selected(old('jenis_responden', $profil['jenis_responden'] ?? '') === $target)>
                                {{ ucfirst($target) }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_responden')
                        <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nama <span class="text-red-600">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $profil['nama'] ?? '') }}"
                        class="block w-full rounded-lg border @error('nama') border-red-500 @else border-gray-300 @enderror px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 focus:border-transparent transition-all"
                        placeholder="Masukkan nama lengkap">
                    @error('nama')
                        <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div id="npmField">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <span id="npmLabel">NPM</span>
                        <span class="text-red-600" id="npmRequired">*</span>
                    </label>
                    <input type="text" name="npm" id="npm" value="{{ old('npm', $profil['npm'] ?? '') }}"
                        class="block w-full rounded-lg border @error('npm') border-red-500 @else border-gray-300 @enderror px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 focus:border-transparent transition-all"
                        placeholder="Masukkan NPM/NIP">
                    @error('npm')
                        <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $profil['email'] ?? '') }}"
                        class="block w-full rounded-lg border @error('email') border-red-500 @else border-gray-300 @enderror px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 focus:border-transparent transition-all"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div id="fakultasField">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Fakultas 
                        <span class="text-red-600" id="fakultasRequired">*</span>
                    </label>
                    <select name="fakultas" id="fakultas"
                        class="block w-full rounded-lg border @error('fakultas') border-red-500 @else border-gray-300 @enderror px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 focus:border-transparent transition-all">
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
                        <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div id="jurusanField">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Jurusan 
                        <span class="text-red-600" id="jurusanRequired">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $profil['jurusan'] ?? '') }}"
                            class="block w-full rounded-lg border @error('jurusan') border-red-500 @else border-gray-300 @enderror px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 focus:border-transparent transition-all"
                            placeholder="Pilih fakultas terlebih dahulu" autocomplete="off" readonly>
                        <div id="jurusanDropdown" class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-xl max-h-60 overflow-auto">
                            <div class="sticky top-0 bg-white border-b border-gray-200 p-3">
                                <input type="text" id="jurusanSearch" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-deep-sapphire-500 text-sm"
                                    placeholder="Cari jurusan...">
                            </div>
                            <ul id="jurusanOptions" class="py-2">
                                <!-- Options will be populated by JavaScript -->
                            </ul>
                        </div>
                    </div>
                    @error('jurusan')
                        <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-3 sm:justify-between">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-semibold text-white bg-deep-sapphire-600 hover:bg-deep-sapphire-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-deep-sapphire-500 transition-all shadow-sm">
                    Lanjut ke pertanyaan
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

        </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="w-full">
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

// Update form fields based on jenis responden
function updateFormFields() {
    const jenisResponden = document.getElementById('jenis_responden').value;
    const npmField = document.getElementById('npmField');
    const npmInput = document.getElementById('npm');
    const npmLabel = document.getElementById('npmLabel');
    const npmRequired = document.getElementById('npmRequired');
    const fakultasField = document.getElementById('fakultasField');
    const fakultasRequired = document.getElementById('fakultasRequired');
    const jurusanField = document.getElementById('jurusanField');
    const jurusanRequired = document.getElementById('jurusanRequired');
    
    // Reset all fields to visible first
    npmField.style.display = 'block';
    fakultasField.style.display = 'block';
    jurusanField.style.display = 'block';
    
    // Mahasiswa: semua field wajib, NPM ditampilkan
    if (jenisResponden === 'mahasiswa') {
        npmLabel.textContent = 'NPM';
        npmRequired.style.display = 'inline';
        npmInput.required = true;
        fakultasRequired.style.display = 'inline';
        jurusanRequired.style.display = 'inline';
        document.getElementById('fakultas').required = true;
        document.getElementById('jurusan').required = true;
    }
    // Dosen: semua field wajib, NPM diganti NIP
    else if (jenisResponden === 'dosen') {
        npmLabel.textContent = 'NIP';
        npmRequired.style.display = 'inline';
        npmInput.required = true;
        fakultasRequired.style.display = 'inline';
        jurusanRequired.style.display = 'inline';
        document.getElementById('fakultas').required = true;
        document.getElementById('jurusan').required = true;
    }
    // Staff: NPM disembunyikan, fakultas dan jurusan opsional
    else if (jenisResponden === 'staff') {
        npmField.style.display = 'none';
        npmInput.value = '';
        npmInput.required = false;
        fakultasRequired.style.display = 'none';
        jurusanRequired.style.display = 'none';
        document.getElementById('fakultas').required = false;
        document.getElementById('jurusan').required = false;
    }
    // Alumni: semua field wajib, NPM ditampilkan
    else if (jenisResponden === 'alumni') {
        npmLabel.textContent = 'NPM';
        npmRequired.style.display = 'inline';
        npmInput.required = true;
        fakultasRequired.style.display = 'inline';
        jurusanRequired.style.display = 'inline';
        document.getElementById('fakultas').required = true;
        document.getElementById('jurusan').required = true;
    }
    // Stakeholder: NPM, fakultas, dan jurusan disembunyikan
    else if (jenisResponden === 'stakeholder') {
        npmField.style.display = 'none';
        fakultasField.style.display = 'none';
        jurusanField.style.display = 'none';
        npmInput.value = '';
        npmInput.required = false;
        document.getElementById('fakultas').value = '';
        document.getElementById('fakultas').required = false;
        document.getElementById('jurusan').value = '';
        document.getElementById('jurusan').required = false;
    }
    // Default: sembunyikan NPM
    else {
        npmLabel.textContent = 'NPM';
        npmRequired.style.display = 'none';
        npmInput.required = false;
        fakultasRequired.style.display = 'inline';
        jurusanRequired.style.display = 'inline';
    }
}

// Event listener untuk perubahan jenis responden
document.getElementById('jenis_responden').addEventListener('change', function() {
    updateFormFields();
});

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
        li.className = 'px-4 py-2 hover:bg-deep-sapphire-50 cursor-pointer text-gray-800 text-sm transition-colors';
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

// Initialize on page load
window.addEventListener('DOMContentLoaded', function() {
    // Update form fields based on selected jenis responden
    updateFormFields();
    
    // Trigger change event on fakultas if already selected
    const fakultasSelect = document.getElementById('fakultas');
    if (fakultasSelect.value) {
        fakultasSelect.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection

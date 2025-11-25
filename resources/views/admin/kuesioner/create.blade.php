@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Kuesioner Baru</h1>
            <p class="mt-2 text-sm text-gray-700">Buat kuesioner dan tambahkan pertanyaan survei</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('dashboard.kuesioner.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 cursor-pointer">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('dashboard.kuesioner.store') }}" method="POST" id="formKuesioner">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Dasar</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul Kuesioner -->
                        <div class="md:col-span-1">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Kuesioner <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="judul" 
                                id="judul" 
                                value="{{ old('judul') }}"
                                class="w-full px-3.5 py-2.5 border @error('judul') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Masukkan judul kuesioner"
                                required
                            >
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Ikon -->
                        <div class="md:col-span-1">
                            <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                                Ikon <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="icon" 
                                id="icon"
                                class="w-full px-3.5 py-2.5 border @error('icon') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required
                            >
                                <option value="">Pilih Ikon</option>
                                <option value="fas fa-clipboard-list" {{ old('icon') == 'fas fa-clipboard-list' ? 'selected' : '' }}>📋 Clipboard List</option>
                                <option value="fas fa-book" {{ old('icon') == 'fas fa-book' ? 'selected' : '' }}>📚 Book</option>
                                <option value="fas fa-graduation-cap" {{ old('icon') == 'fas fa-graduation-cap' ? 'selected' : '' }}>🎓 Graduation Cap</option>
                                <option value="fas fa-chalkboard-teacher" {{ old('icon') == 'fas fa-chalkboard-teacher' ? 'selected' : '' }}>👨‍🏫 Teacher</option>
                                <option value="fas fa-flask" {{ old('icon') == 'fas fa-flask' ? 'selected' : '' }}>🧪 Flask</option>
                                <option value="fas fa-laptop" {{ old('icon') == 'fas fa-laptop' ? 'selected' : '' }}>💻 Laptop</option>
                                <option value="fas fa-chart-bar" {{ old('icon') == 'fas fa-chart-bar' ? 'selected' : '' }}>📊 Chart</option>
                                <option value="fas fa-star" {{ old('icon') == 'fas fa-star' ? 'selected' : '' }}>⭐ Star</option>
                            </select>
                            @error('icon')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-6">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea 
                            name="deskripsi" 
                            id="deskripsi" 
                            rows="4"
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Jelaskan tujuan kuesioner ini..."
                        >{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Target Responden - Multiple Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Target Responden <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2 p-3 border @error('target_responden') border-red-500 @else border-gray-300 @enderror rounded-lg">
                                @php
                                    $targets = ['mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen', 'staff' => 'Staff', 'alumni' => 'Alumni', 'stakeholder' => 'Stakeholder'];
                                    $oldTargets = old('target_responden', []);
                                @endphp
                                @foreach($targets as $value => $label)
                                    <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded">
                                        <input 
                                            type="checkbox" 
                                            name="target_responden[]" 
                                            value="{{ $value }}"
                                            {{ in_array($value, $oldTargets) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                        >
                                        <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('target_responden')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Limit Responden -->
                        <div>
                            <label for="limit_responden" class="block text-sm font-medium text-gray-700 mb-2">
                                Limit Responden
                                <span class="text-gray-500 text-xs">(opsional)</span>
                            </label>
                            <input 
                                type="number" 
                                name="limit_responden" 
                                id="limit_responden" 
                                value="{{ old('limit_responden') }}"
                                min="1"
                                class="w-full px-3.5 py-2.5 border @error('limit_responden') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Kosongkan untuk unlimited"
                            >
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>Batas maksimal responden yang dapat mengisi
                            </p>
                            @error('limit_responden')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="tanggal_mulai" 
                                id="tanggal_mulai" 
                                value="{{ old('tanggal_mulai') }}"
                                class="w-full px-3.5 py-2.5 border @error('tanggal_mulai') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required
                            >
                            @error('tanggal_mulai')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="tanggal_selesai" 
                                id="tanggal_selesai" 
                                value="{{ old('tanggal_selesai') }}"
                                class="w-full px-3.5 py-2.5 border @error('tanggal_selesai') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required
                            >
                            @error('tanggal_selesai')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan Survei -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Pertanyaan Survei</h2>
                        <button type="button" onclick="tambahPertanyaan()" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 cursor-pointer">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Pertanyaan
                        </button>
                    </div>

                    <div id="daftarPertanyaan" class="space-y-4">
                        <!-- Pertanyaan akan ditambahkan di sini via JavaScript -->
                    </div>

                    @error('pertanyaan')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Preview & Tips -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Pratinjau Ikon -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Pratinjau Ikon</h3>
                    <div class="flex items-center justify-center h-32 bg-gray-50 rounded-lg border border-gray-200">
                        <div id="iconPreview" class="text-6xl text-gray-400">
                            <i class="fas fa-image"></i>
                        </div>
                    </div>
                </div>

                <!-- Tips Membuat Kuesioner -->
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                    <h3 class="text-sm font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Tips Membuat Kuesioner
                    </h3>
                    <ul class="space-y-3 text-sm text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Gunakan judul yang jelas dan deskriptif</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Buat pertanyaan yang mudah dipahami</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Gunakan kategori untuk mengelompokkan pertanyaan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Pilih jenis pertanyaan yang sesuai</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Tentukan target responden dengan tepat</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 cursor-pointer">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Kuesioner
                        </button>
                        <a href="{{ route('dashboard.kuesioner.index') }}" class="w-full inline-flex items-center justify-center rounded-md bg-white px-4 py-3 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 cursor-pointer">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let pertanyaanCount = 0;

// Preview icon
document.getElementById('icon').addEventListener('change', function() {
    const iconClass = this.value;
    const preview = document.getElementById('iconPreview');
    if (iconClass) {
        preview.innerHTML = `<i class="${iconClass} text-blue-600"></i>`;
    } else {
        preview.innerHTML = '<i class="fas fa-image"></i>';
    }
});

function tambahPertanyaan() {
    const container = document.getElementById('daftarPertanyaan');
    const currentCount = container.querySelectorAll('.pertanyaan-item').length + 1;
    pertanyaanCount++;
    
    const pertanyaanHTML = `
        <div class="pertanyaan-item bg-gray-50 rounded-lg border border-gray-200 p-5" data-index="${pertanyaanCount}">
            <div class="flex items-start justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Pertanyaan ${currentCount}</h4>
                <button type="button" onclick="hapusPertanyaan(this)" class="text-red-600 hover:text-red-800 cursor-pointer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Teks Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="pertanyaan[${pertanyaanCount}][teks_pertanyaan]" 
                        rows="2"
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan pertanyaan..."
                        required
                    ></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="pertanyaan[${pertanyaanCount}][jenis_pertanyaan]"
                        class="jenis-pertanyaan-select w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        onchange="toggleOpsiJawaban(this)"
                        required
                    >
                        <option value="">Pilih Jenis</option>
                        <option value="likert">Skala Likert (1-5)</option>
                        <option value="pilihan_ganda">Pilihan Ganda</option>
                        <option value="isian">Isian Teks</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <input 
                        type="text" 
                        name="pertanyaan[${pertanyaanCount}][kategori]"
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: Layanan, Fasilitas, dll"
                    >
                </div>
                
                <!-- Opsi Jawaban untuk Pilihan Ganda -->
                <div class="md:col-span-2 opsi-jawaban-container" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Opsi Jawaban <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2 opsi-list" data-pertanyaan="${pertanyaanCount}">
                        <div class="flex gap-2 opsi-item">
                            <input 
                                type="text" 
                                name="pertanyaan[${pertanyaanCount}][opsi][]"
                                class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Opsi 1"
                            >
                            <button type="button" onclick="hapusOpsi(this)" class="px-3 py-2 text-red-600 hover:text-red-800 cursor-pointer">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="flex gap-2 opsi-item">
                            <input 
                                type="text" 
                                name="pertanyaan[${pertanyaanCount}][opsi][]"
                                class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Opsi 2"
                            >
                            <button type="button" onclick="hapusOpsi(this)" class="px-3 py-2 text-red-600 hover:text-red-800 cursor-pointer">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="tambahOpsi(${pertanyaanCount})" class="mt-2 text-sm text-blue-600 hover:text-blue-800 cursor-pointer">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Tambah Opsi
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', pertanyaanHTML);
}

function hapusPertanyaan(button) {
    if (confirm('Yakin ingin menghapus pertanyaan ini?')) {
        button.closest('.pertanyaan-item').remove();
        updateNomorPertanyaan();
    }
}

function updateNomorPertanyaan() {
    const items = document.querySelectorAll('.pertanyaan-item');
    items.forEach((item, index) => {
        item.querySelector('h4').textContent = `Pertanyaan ${index + 1}`;
    });
}

function toggleOpsiJawaban(selectElement) {
    const pertanyaanItem = selectElement.closest('.pertanyaan-item');
    const opsiContainer = pertanyaanItem.querySelector('.opsi-jawaban-container');
    const opsiInputs = pertanyaanItem.querySelectorAll('.opsi-jawaban-container input');
    
    if (selectElement.value === 'pilihan_ganda') {
        opsiContainer.style.display = 'block';
        // Set required untuk opsi
        opsiInputs.forEach(input => input.required = true);
    } else {
        opsiContainer.style.display = 'none';
        // Hapus required untuk opsi
        opsiInputs.forEach(input => input.required = false);
    }
}

function tambahOpsi(pertanyaanIndex) {
    const opsiList = document.querySelector(`.opsi-list[data-pertanyaan="${pertanyaanIndex}"]`);
    const opsiCount = opsiList.querySelectorAll('.opsi-item').length + 1;
    
    const opsiHTML = `
        <div class="flex gap-2 opsi-item">
            <input 
                type="text" 
                name="pertanyaan[${pertanyaanIndex}][opsi][]"
                class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Opsi ${opsiCount}"
                required
            >
            <button type="button" onclick="hapusOpsi(this)" class="px-3 py-2 text-red-600 hover:text-red-800 cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    opsiList.insertAdjacentHTML('beforeend', opsiHTML);
}

function hapusOpsi(button) {
    const opsiList = button.closest('.opsi-list');
    const opsiItems = opsiList.querySelectorAll('.opsi-item');
    
    // Minimal harus ada 2 opsi
    if (opsiItems.length > 2) {
        button.closest('.opsi-item').remove();
        updateOpsiPlaceholder(opsiList);
    } else {
        alert('Minimal harus ada 2 opsi jawaban');
    }
}

function updateOpsiPlaceholder(opsiList) {
    const opsiItems = opsiList.querySelectorAll('.opsi-item');
    opsiItems.forEach((item, index) => {
        const input = item.querySelector('input');
        input.placeholder = `Opsi ${index + 1}`;
    });
}

// Tambah pertanyaan pertama secara otomatis
document.addEventListener('DOMContentLoaded', function() {
    tambahPertanyaan();
});
</script>
@endsection

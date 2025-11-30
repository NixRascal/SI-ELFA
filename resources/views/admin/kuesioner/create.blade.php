@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header Halaman -->
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

    <!-- Pesan Sukses/Error -->
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
            <!-- Kolom Kiri - Form -->
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
                                <option value="fas fa-user-graduate" {{ old('icon') == 'fas fa-user-graduate' ? 'selected' : '' }}>🎓 User Graduate</option>
                                <option value="fas fa-user-tie" {{ old('icon') == 'fas fa-user-tie' ? 'selected' : '' }}>👔 User Tie</option>
                                <option value="fas fa-university" {{ old('icon') == 'fas fa-university' ? 'selected' : '' }}>🏛️ University</option>
                                <option value="fas fa-building" {{ old('icon') == 'fas fa-building' ? 'selected' : '' }}>🏢 Building</option>
                                <option value="fas fa-comments" {{ old('icon') == 'fas fa-comments' ? 'selected' : '' }}>💬 Comments</option>
                                <option value="fas fa-check-circle" {{ old('icon') == 'fas fa-check-circle' ? 'selected' : '' }}>✅ Check Circle</option>
                                <option value="fas fa-bullhorn" {{ old('icon') == 'fas fa-bullhorn' ? 'selected' : '' }}>📢 Bullhorn</option>
                                <option value="fas fa-calendar-alt" {{ old('icon') == 'fas fa-calendar-alt' ? 'selected' : '' }}>📅 Calendar</option>
                                <option value="fas fa-clock" {{ old('icon') == 'fas fa-clock' ? 'selected' : '' }}>⏰ Clock</option>
                                <option value="fas fa-cog" {{ old('icon') == 'fas fa-cog' ? 'selected' : '' }}>⚙️ Cog</option>
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
                        <!-- Target Responden - Pilihan Ganda -->
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
                    </div>

                    <div id="daftarPertanyaan" class="space-y-4">
                        <!-- Pertanyaan akan ditambahkan di sini via JavaScript -->
                    </div>

                    <div class="mt-4 flex justify-center border-t border-gray-100 pt-4">
                        <button type="button" onclick="tambahPertanyaan()" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 cursor-pointer shadow-sm transition-all duration-200 hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Pertanyaan
                        </button>
                    </div>

                    @error('pertanyaan')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Kolom Kanan - Preview & Tips -->
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

                <!-- Tombol Aksi -->
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

<!-- Modal Konfirmasi Hapus Pertanyaan -->
<div id="deleteQuestionModal" class="hidden fixed inset-0 z-50" style="background-color: rgba(0, 0, 0, 0.4);">
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg animate-modal-in">
                <!-- Header -->
                <div class="relative bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                    <button type="button" onclick="closeDeleteQuestionModal()" class="absolute top-4 right-4 text-white hover:text-red-100 transition-colors cursor-pointer">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                    <div class="flex items-center">
                        <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-white bg-opacity-20 backdrop-blur-sm">
                            <i class="fas fa-trash-alt text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-white">Hapus Pertanyaan</h3>
                            <p class="text-red-100 text-sm mt-0.5">Konfirmasi penghapusan pertanyaan</p>
                        </div>
                    </div>
                </div>
                <!-- Body -->
                <div class="bg-white px-6 py-5">

                    <div class="mt-5 text-center">
                        <p class="text-base font-medium text-gray-900">Apakah Anda yakin ingin melanjutkan?</p>
                    </div>
                </div>
                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row-reverse gap-3">
                    <button type="button" id="confirmDeleteQuestionBtn" class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 transition-all duration-200 cursor-pointer">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Ya, Hapus Pertanyaan
                    </button>
                    <button type="button" onclick="closeDeleteQuestionModal()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-md hover:bg-gray-50 border border-gray-300 cursor-pointer">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(-20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-modal-in { animation: modalIn 0.3s ease-out forwards; }
    body.modal-open { overflow: hidden; }
</style>

<!-- Load Assets -->
@vite(['resources/js/admin/kuesioner-form.js'])
@endsection

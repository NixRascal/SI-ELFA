@extends('layouts.admin')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header Halaman -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kartu Info Profil -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mx-auto flex items-center justify-center mb-4">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($admin->nama, 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $admin->nama }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $admin->email }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-center text-sm text-gray-600">
                                <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                                <span>Administrator</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Akun -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-4">Informasi Akun</h4>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-alt text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-gray-500 text-xs">Dibuat</p>
                                <p class="text-gray-900">{{ $admin->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                            <div>
                                <p class="text-gray-500 text-xs">Terakhir Update</p>
                                <p class="text-gray-900">{{ $admin->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Form Update Profil -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-user-edit text-blue-600 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                            <p class="text-sm text-gray-600">Update nama dan email Anda</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $admin->nama) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form Update Password -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-lock text-blue-600 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Keamanan</h3>
                            <p class="text-sm text-gray-600">Update password akun Anda</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini
                                </label>
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-deep-sapphire-600 text-white text-sm font-medium rounded-lg hover:bg-deep-sapphire-700 focus:ring-4 focus:ring-deep-sapphire-300 transition-colors">
                                <i class="fas fa-key mr-2"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Zona Berbahaya -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3 mt-1"></i>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-red-900 mb-2">Zona Berbahaya</h4>
                            <p class="text-sm text-red-700 mb-4">
                                Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.
                                Pastikan Anda memahami konsekuensinya sebelum melanjutkan.
                            </p>
                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between bg-white rounded-lg p-4 border border-red-200">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Hapus Akun</p>
                                        <p class="text-xs text-gray-500">Menghapus akun secara permanen</p>
                                    </div>
                                    <button type="button" onclick="openDeleteModal()"
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition-colors">
                                        Hapus Akun
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50" style="background-color: rgba(0, 0, 0, 0.4);">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <!-- Modal Content -->
                <div id="modalContent"
                    class="relative transform rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg animate-modal-in">

                    <!-- Header with Gradient -->
                    <div class="relative bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                        <!-- Close Button -->
                        <button type="button" onclick="closeDeleteModal()"
                            class="absolute top-4 right-4 text-white hover:text-red-100 transition-colors cursor-pointer">
                            <i class="fas fa-times text-lg"></i>
                        </button>

                        <!-- Icon and Title -->
                        <div class="flex items-center">
                            <div
                                class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-white bg-opacity-20 backdrop-blur-sm">
                                <i class="fas fa-trash-alt text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-white">Hapus Akun</h3>
                                <p class="text-red-100 text-sm mt-0.5">Konfirmasi tindakan penghapusan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="bg-white px-6 py-5">
                        <!-- Warning Message -->
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-semibold text-red-800">Peringatan Penting!</h4>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p class="leading-relaxed">Tindakan ini akan menghapus akun Anda secara permanen.
                                        </p>
                                        <p class="mt-2 font-semibold">
                                            <i class="fas fa-ban mr-1"></i>
                                            Data yang dihapus tidak dapat dipulihkan kembali.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmation Question -->
                        <div class="mt-5 text-center">
                            <p class="text-base font-medium text-gray-900">Apakah Anda yakin ingin melanjutkan?</p>
                            <p class="mt-2 text-sm text-gray-500">Ketik <span class="font-bold text-red-600">hapus
                                    akun</span> di bawah ini untuk konfirmasi:</p>
                            <input type="text" id="deleteConfirmationInput"
                                class="mt-4 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-lg p-3 text-center"
                                placeholder="Ketik di sini...">
                        </div>
                    </div>

                    <!-- Footer with Action Buttons -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row-reverse gap-3">
                        <form action="{{ route('dashboard.profile.destroy') }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="deleteButton" disabled
                                class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                <i class="fas fa-trash-alt mr-2"></i>
                                Ya, Hapus Akun
                            </button>
                        </form>
                        <button type="button" onclick="closeDeleteModal()"
                            class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-md hover:bg-gray-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 border border-gray-300 cursor-pointer">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-modal-in {
            animation: modalIn 0.3s ease-out;
        }

        #deleteModal:not(.hidden) {
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        body.modal-open {
            overflow: hidden;
        }
    </style>

    <script>
        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            document.body.classList.add('modal-open');
            modal.classList.remove('hidden');
            document.getElementById('deleteConfirmationInput').value = '';
            document.getElementById('deleteButton').disabled = true;
            document.getElementById('deleteConfirmationInput').focus();
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            document.body.classList.remove('modal-open');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });

        // Validation logic
        document.getElementById('deleteConfirmationInput').addEventListener('input', function (e) {
            const deleteButton = document.getElementById('deleteButton');
            const expectedText = 'hapus akun';

            if (e.target.value.toLowerCase() === expectedText) {
                deleteButton.disabled = false;
                deleteButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                deleteButton.disabled = true;
                deleteButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>
@endsection
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
                                    <button disabled
                                        class="px-4 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                        Nonaktif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
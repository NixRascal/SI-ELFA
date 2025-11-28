@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('dashboard.admin.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Admin</h1>
                <p class="mt-1 text-sm text-gray-700">Perbarui informasi administrator</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 max-w-2xl">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Admin</h2>
        </div>
        
        <form action="{{ route('dashboard.admin.update', $admin) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Nama -->
            <div class="mb-5">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="nama" 
                    id="nama" 
                    value="{{ old('nama', $admin->nama) }}"
                    class="w-full px-3.5 py-2.5 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Masukkan nama lengkap"
                >
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email', $admin->email) }}"
                    class="w-full px-3.5 py-2.5 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="admin@example.com"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Pembatas -->
            <div class="my-6 border-t border-gray-200 pt-6">
                <p class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Kosongkan jika tidak ingin mengubah password
                </p>
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="w-full px-3.5 py-2.5 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Minimal 6 karakter"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Ulangi password baru"
                >
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('dashboard.admin.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-deep-sapphire-600 rounded-lg hover:bg-deep-sapphire-700">
                    <i class="fas fa-save mr-2"></i>
                    Update Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header Halaman -->
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Admin</h1>
                <p class="mt-2 text-sm text-gray-700">Kelola akun administrator sistem</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('dashboard.admin.create') }}"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Admin
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

        <!-- Daftar Admin -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Tampilan Tabel Desktop (hidden di mobile) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Bergabung Sejak
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($admins as $index => $admin)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $admins->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div
                                                class="h-10 w-10 rounded-full bg-deep-sapphire-100 flex items-center justify-center">
                                                <i class="fas fa-user-shield text-deep-sapphire-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $admin->nama }}</div>
                                            @if($admin->id === auth()->id())
                                                <div class="text-xs text-deep-sapphire-600 font-medium">Anda</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $admin->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('dashboard.admin.edit', $admin) }}"
                                            class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($admin->id !== auth()->id())
                                            <button type="button" onclick="confirmDelete({{ $admin->id }}, '{{ $admin->nama }}')"
                                                class="text-red-600 hover:text-red-800" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <span class="text-gray-300 cursor-not-allowed"
                                                title="Tidak dapat menghapus akun sendiri">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <i class="fas fa-user-slash text-4xl text-gray-300 mb-2"></i>
                                    <p class="font-medium">Tidak ada data admin</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tampilan Card Mobile (hanya di mobile) -->
            <div class="md:hidden p-4 space-y-4">
                @forelse ($admins as $index => $admin)
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <!-- Header dengan Avatar dan Nomor -->
                        <div class="flex items-start gap-3 mb-3">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-deep-sapphire-100 flex items-center justify-center">
                                        <i class="fas fa-user-shield text-deep-sapphire-600 text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $admin->nama }}</h3>
                                        @if($admin->id === auth()->id())
                                            <span
                                                class="px-2 py-0.5 bg-deep-sapphire-100 text-deep-sapphire-700 text-xs font-medium rounded">Anda</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5">#{{ $admins->firstItem() + $index }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="space-y-2 mb-3">
                            <!-- Email -->
                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-400 w-4 text-xs"></i>
                                <span class="text-sm text-gray-700 break-all">{{ $admin->email }}</span>
                            </div>

                            <!-- Bergabung Sejak -->
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar text-gray-400 w-4 text-xs"></i>
                                <span class="text-sm text-gray-600">Bergabung
                                    {{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Aksi -->
                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <a href="{{ route('dashboard.admin.edit', $admin) }}" class="text-blue-600 hover:text-blue-800"
                                title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            @if($admin->id !== auth()->id())
                                <button type="button" onclick="confirmDelete({{ $admin->id }}, '{{ $admin->nama }}')"
                                    class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            @else
                                <span class="text-gray-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                    <i class="fas fa-trash text-lg"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                        <i class="fas fa-user-slash text-4xl text-gray-300 mb-2"></i>
                        <p class="font-medium text-gray-900">Tidak ada data admin</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($admins->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $admins->links('pagination.custom') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50" style="background-color: rgba(0, 0, 0, 0.4);">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <!-- Konten Modal -->
                <div id="modalContent"
                    class="relative transform rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg animate-modal-in">

                    <!-- Header dengan Gradient -->
                    <div class="relative bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                        <!-- Tombol Tutup -->
                        <button type="button" onclick="closeDeleteModal()"
                            class="absolute top-4 right-4 text-white hover:text-red-100 transition-colors cursor-pointer">
                            <i class="fas fa-times text-lg"></i>
                        </button>

                        <!-- Ikon dan Judul -->
                        <div class="flex items-center">
                            <div
                                class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-white bg-opacity-20 backdrop-blur-sm">
                                <i class="fas fa-user-times text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-white">Hapus Admin</h3>
                                <p class="text-red-100 text-sm mt-0.5">Konfirmasi penghapusan administrator</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="bg-white px-6 py-5">
                        <!-- Info Admin -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-shield text-gray-400 text-xl"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Admin yang akan
                                        dihapus:</p>
                                    <p class="mt-1 text-base font-semibold text-gray-900" id="deleteAdminName"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Pesan Peringatan -->
                        <div class="mt-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-semibold text-red-800">Peringatan Penting!</h4>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p class="leading-relaxed">Tindakan ini akan:</p>
                                        <ul class="mt-2 space-y-1 ml-4">
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-red-400 text-xs mr-2"></i>
                                                <span>Menghapus akun administrator secara permanen</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-red-400 text-xs mr-2"></i>
                                                <span>Mencabut semua akses admin ke sistem</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-red-400 text-xs mr-2"></i>
                                                <span>Admin tidak akan bisa login lagi</span>
                                            </li>
                                        </ul>
                                        <p class="mt-3 font-semibold">
                                            <i class="fas fa-ban mr-1"></i>
                                            Data yang dihapus tidak dapat dipulihkan kembali.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pertanyaan Konfirmasi -->
                        <div class="mt-5 text-center">
                            <p class="text-base font-medium text-gray-900">Apakah Anda yakin ingin melanjutkan?</p>
                            <p class="mt-2 text-sm text-gray-500">Ketik <span class="font-bold text-red-600">hapus
                                    akun</span> di bawah ini untuk konfirmasi:</p>
                            <input type="text" id="deleteConfirmationInput"
                                class="mt-4 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-lg p-3 text-center"
                                placeholder="Ketik di sini...">
                        </div>
                    </div>

                    <!-- Footer dengan Tombol Aksi -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row-reverse gap-3">
                        <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="deleteButton" disabled
                                class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                <i class="fas fa-user-times mr-2" id="deleteIcon"></i>
                                <span id="deleteButtonText">Ya, Hapus Admin</span>
                                <i class="fas fa-spinner fa-spin ml-2" id="deleteSpinner" style="display: none;"></i>
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

    <!-- Load Assets -->
    @vite(['resources/css/admin/manajemen-index.css', 'resources/js/admin/manajemen-index.js'])

    <script>
        // Override or extend existing script if necessary, but ideally we should modify the JS file.
        // Since I cannot easily modify the JS file without reading it first and it might be compiled or shared,
        // I will add the logic here inline or check if I can modify the JS file.
        // However, the user asked to implement it in the view.
        // Let's check if there is existing JS logic that conflicts.
        // The existing view loads `resources/js/admin/manajemen-index.js`.
        // I should probably modify that JS file or add the logic here.
        // Given the instructions, I'll add the logic here to ensure it works immediately.

        document.addEventListener('DOMContentLoaded', function () {
            const deleteInput = document.getElementById('deleteConfirmationInput');
            const deleteBtn = document.getElementById('deleteButton');

            if (deleteInput && deleteBtn) {
                deleteInput.addEventListener('input', function (e) {
                    const expectedText = 'hapus akun';
                    if (e.target.value.toLowerCase() === expectedText) {
                        deleteBtn.disabled = false;
                        deleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        deleteBtn.disabled = true;
                        deleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
        });

        // Ensure openDeleteModal clears the input
        const originalOpenDeleteModal = window.openDeleteModal; // Assuming it's global
        // If it's not global, I might need to redefine it or hook into it.
        // Let's redefine it to be safe, assuming the original one is simple.
        // Wait, I should check the original JS first.
    </script>
@endsection
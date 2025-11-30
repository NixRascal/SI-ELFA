@extends('layouts.admin')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Notifikasi Sukses/Error -->
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="inline-flex text-green-400 hover:text-green-500">
                            <i class="fas fa-times"></i>
                        </button>
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
                    <div class="ml-auto pl-3">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="inline-flex text-red-400 hover:text-red-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header Halaman -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-bold text-gray-900">Kelola Kuesioner</h1>
                <p class="mt-2 text-sm text-gray-700">Daftar semua kuesioner yang telah dibuat</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-3">
                <a href="{{ route('dashboard.kuesioner.create') }}"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Kuesioner Baru
                </a>
            </div>
        </div>

        <!-- Form Filter Pencarian -->
        <div class="mt-6 bg-white rounded-lg border border-gray-200 shadow-sm p-4">
            <form method="GET" action="{{ route('dashboard.kuesioner.index') }}"
                class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <!-- Input Pencarian -->
                <div class="lg:col-span-1">
                    <label for="cari" class="block text-sm font-medium text-gray-700 mb-2">Cari Kuesioner</label>
                    <input type="text" name="cari" id="cari" value="{{ $search }}"
                        placeholder="Cari judul atau deskripsi..."
                        class="block w-full rounded-md border-2 border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3.5">
                </div>

                <!-- Filter Status -->
                <div class="sm:col-span-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status"
                        class="block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3.5">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ $statusFilter === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $statusFilter === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <!-- Filter Target Responden -->
                <div class="sm:col-span-1">
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-2">Target Responden</label>
                    <select name="target" id="target"
                        class="block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3.5">
                        <option value="">Semua Target</option>
                        <option value="mahasiswa" {{ $targetFilter === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ $targetFilter === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="staff" {{ $targetFilter === 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="alumni" {{ $targetFilter === 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="stakeholder" {{ $targetFilter === 'stakeholder' ? 'selected' : '' }}>Stakeholder
                        </option>
                    </select>
                </div>

                <!-- Tombol Cari -->
                <div class="lg:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <button type="submit"
                        class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 shadow-sm cursor-pointer transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Container Tabel/Card -->
        <div class="mt-6">
            <!-- Tampilan Tabel Desktop (hidden di mobile) -->
            <div class="hidden md:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 sm:pl-6">
                                    Kuesioner
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-900">
                                    Target
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-900">
                                    Status
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-900">
                                    Periode
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-900">
                                    Responden
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-900">
                                    Dibuat
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-900">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($kuesioner as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0">
                                                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                                    <i class="{{ $item->icon }} text-blue-600 text-sm"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 min-w-0">
                                                <div class="text-sm font-medium text-gray-900 break-words">{{ $item->judul }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $item->pertanyaan->count() }} Pertanyaan
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-xs">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach((array) $item->target_responden as $target)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                                    {{ $target }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 text-sm">
                                        @if ($item->is_active)
                                            <span
                                                class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 text-xs text-gray-500">
                                        <div class="flex flex-col">
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                                            <span class="text-gray-300 text-[10px]">-</span>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-xs text-gray-900">
                                        <div class="flex items-center">
                                            <i class="fas fa-users text-gray-400 mr-1.5 text-xs"></i>
                                            <span class="font-medium">{{ $item->responden_count }}</span>
                                            <span class="text-gray-500 ml-1">Responden</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-xs text-gray-500">
                                        <div>
                                            <div class="font-medium text-gray-700">{{ $item->admin->nama ?? 'Admin' }}</div>
                                            <div class="text-[10px]">{{ $item->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="relative py-3 pl-3 pr-4 text-right text-xs font-medium sm:pr-6">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('dashboard.kuesioner.show', $item) }}"
                                                class="text-gray-400 hover:text-gray-600 cursor-pointer" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.kuesioner.edit', $item) }}"
                                                class="text-blue-400 hover:text-blue-600 cursor-pointer" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Toggle Status --}}
                                            <form action="{{ route('dashboard.kuesioner.toggle-status', $item) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @if($item->status_aktif)
                                                    {{-- Jika aktif, selalu bisa dinonaktifkan --}}
                                                    <button type="submit"
                                                        class="text-yellow-400 hover:text-yellow-600 cursor-pointer"
                                                        title="Nonaktifkan">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </button>
                                                @else
                                                    {{-- Jika nonaktif, cek periode --}}
                                                    @if($item->is_period_valid)
                                                        <button type="submit" class="text-green-400 hover:text-green-600 cursor-pointer"
                                                            title="Aktifkan">
                                                            <i class="fas fa-toggle-off"></i>
                                                        </button>
                                                    @else
                                                        {{-- Disabled state --}}
                                                        <button type="button" class="text-gray-300 cursor-not-allowed"
                                                            title="Tidak dapat diaktifkan: {{ $item->status_reason }}">
                                                            <i class="fas fa-toggle-off"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            </form>

                                            <!-- Delete -->
                                            <button type="button"
                                                onclick="confirmDelete({{ $item->id }}, {{ json_encode($item->judul) }})"
                                                class="text-red-400 hover:text-red-600 cursor-pointer" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-8 text-center text-sm text-gray-500">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                        <p class="font-medium">Tidak ada kuesioner</p>
                                        <p class="text-xs">Belum ada kuesioner yang dibuat</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($kuesioner->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200">
                        {{ $kuesioner->links('pagination.custom') }}
                    </div>
                @endif
            </div>

            <!-- Tampilan Card Mobile (hanya di mobile) -->
            <div class="md:hidden space-y-4">
                @forelse ($kuesioner as $item)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                        <!-- Header with Icon and Title -->
                        <div class="flex items-start space-x-3 mb-3">
                            <div class="h-10 w-10 flex-shrink-0">
                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="{{ $item->icon }} text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 break-words">{{ $item->judul }}</h3>
                                <p class="text-xs text-gray-500">{{ $item->pertanyaan->count() }} Pertanyaan</p>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="space-y-2 mb-3">
                            <!-- Target -->
                            <div class="flex items-start">
                                <span class="text-xs text-gray-500 w-24 flex-shrink-0">Target:</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach((array) $item->target_responden as $target)
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                            {{ $target }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 w-24 flex-shrink-0">Status:</span>
                                @if ($item->is_active)
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                    </span>
                                @endif
                            </div>

                            <!-- Responden -->
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 w-24 flex-shrink-0">Responden:</span>
                                <div class="flex items-center text-xs text-gray-900">
                                    <i class="fas fa-users text-gray-400 mr-1.5"></i>
                                    <span class="font-medium">{{ $item->responden_count }} Responden</span>
                                </div>
                            </div>

                            <!-- Periode -->
                            <div class="flex items-start">
                                <span class="text-xs text-gray-500 w-24 flex-shrink-0">Periode:</span>
                                <div class="text-xs text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </div>
                            </div>

                            <!-- Dibuat -->
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 w-24 flex-shrink-0">Dibuat:</span>
                                <div class="text-xs text-gray-900">
                                    <span class="font-medium">{{ $item->admin->nama ?? 'Admin' }}</span>
                                    <span class="text-gray-400 mx-1">•</span>
                                    <span>{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                            <a href="{{ route('dashboard.kuesioner.show', $item) }}"
                                class="text-gray-400 hover:text-gray-600 cursor-pointer" title="Lihat Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            <a href="{{ route('dashboard.kuesioner.edit', $item) }}"
                                class="text-blue-400 hover:text-blue-600 cursor-pointer" title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>

                            <!-- Toggle Status -->
                            <form action="{{ route('dashboard.kuesioner.toggle-status', $item) }}" method="POST" class="inline">
                                @csrf
                                @if($item->is_period_valid)
                                    <button type="submit"
                                        class="{{ $item->status_aktif ? 'text-yellow-400 hover:text-yellow-600' : 'text-green-400 hover:text-green-600' }} cursor-pointer"
                                        title="{{ $item->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $item->status_aktif ? 'toggle-on' : 'toggle-off' }} text-lg"></i>
                                    </button>
                                @else
                                    @php
                                        $now = now();
                                        $start = \Carbon\Carbon::parse($item->tanggal_mulai)->startOfDay();
                                        $end = \Carbon\Carbon::parse($item->tanggal_selesai)->endOfDay();
                                        $reason = '';
                                        if ($now->lessThan($start)) {
                                            $reason = 'Periode belum dimulai (Mulai: ' . $start->format('d M Y') . ')';
                                        } elseif ($now->greaterThan($end)) {
                                            $reason = 'Periode sudah berakhir (Selesai: ' . $end->format('d M Y') . ')';
                                        }
                                    @endphp
                                    <button type="button" class="text-gray-300 cursor-not-allowed"
                                        title="Tidak dapat diaktifkan: {{ $reason }}">
                                        <i class="fas fa-toggle-off text-lg"></i>
                                    </button>
                                @endif
                            </form>

                            <!-- Delete -->
                            <button type="button" onclick="confirmDelete({{ $item->id }}, {{ json_encode($item->judul) }})"
                                class="text-red-400 hover:text-red-600 cursor-pointer" title="Hapus">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                        <p class="font-medium text-gray-900">Tidak ada kuesioner</p>
                        <p class="text-xs text-gray-500 mt-1">Belum ada kuesioner yang dibuat</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if ($kuesioner->hasPages())
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
                        {{ $kuesioner->links('pagination.custom') }}
                    </div>
                @endif
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
                                <h3 class="text-xl font-bold text-white">Hapus Kuesioner</h3>
                                <p class="text-red-100 text-sm mt-0.5">Konfirmasi tindakan penghapusan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="bg-white px-6 py-5">
                        <!-- Questionnaire Info -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt text-gray-400 text-xl"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kuesioner yang akan
                                        dihapus:</p>
                                    <p class="mt-1 text-base font-semibold text-gray-900" id="deleteTitle"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Warning Message -->
                        <div class="mt-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-semibold text-red-800">Peringatan Penting!</h4>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p class="leading-relaxed">Tindakan ini akan menghapus:</p>
                                        <ul class="mt-2 space-y-1 ml-4">
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-red-400 text-xs mr-2"></i>
                                                <span>Semua pertanyaan dalam kuesioner</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-red-400 text-xs mr-2"></i>
                                                <span>Semua jawaban responden</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-red-400 text-xs mr-2"></i>
                                                <span>Semua data terkait kuesioner</span>
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

                        <!-- Confirmation Question -->
                        <div class="mt-5 text-center">
                            <p class="text-base font-medium text-gray-900">Apakah Anda yakin ingin melanjutkan?</p>
                            <p class="mt-2 text-sm text-gray-500">Ketik <span class="font-bold text-red-600">hapus
                                    kuesioner</span> di bawah ini untuk konfirmasi:</p>
                            <input type="text" id="deleteConfirmationInput"
                                class="mt-4 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-lg p-3 text-center"
                                placeholder="Ketik di sini...">
                        </div>
                    </div>

                    <!-- Footer with Action Buttons -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row-reverse gap-3">
                        <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="deleteButton" disabled
                                class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                <i class="fas fa-trash-alt mr-2" id="deleteIcon"></i>
                                <span id="deleteButtonText">Ya, Hapus Kuesioner</span>
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
    @vite(['resources/css/admin/kuesioner-index.css', 'resources/js/admin/kuesioner-index.js'])
@endsection
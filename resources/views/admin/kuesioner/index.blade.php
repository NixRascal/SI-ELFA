@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Kelola Kuesioner</h1>
            <p class="mt-2 text-sm text-gray-700">Daftar semua kuesioner yang telah dibuat</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-3">
            <button type="button" class="inline-flex items-center rounded-md bg-white px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50">
                <i class="fas fa-upload mr-2"></i>
                Import
            </button>
            <a href="{{ route('dashboard.kuesioner.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Buat Kuesioner Baru
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-6 bg-gray-100 rounded-lg p-4">
        <form method="GET" action="{{ route('dashboard.kuesioner.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <!-- Search -->
            <div class="sm:col-span-1">
                <label for="cari" class="block text-xs font-medium text-gray-700 mb-1">Cari Kuesioner</label>
                <input type="text" 
                    name="cari" 
                    id="cari" 
                    value="{{ $search }}"
                    placeholder="Cari..."
                    class="block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-gray-500 focus:ring-gray-500 text-sm py-2.5 px-3.5">
            </div>

            <!-- Status Filter -->
            <div class="sm:col-span-1">
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <select name="status" 
                    id="status"
                    class="block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-gray-500 focus:ring-gray-500 text-sm py-2.5 px-3.5">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ $statusFilter === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $statusFilter === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Target Responden Filter -->
            <div class="sm:col-span-1">
                <label for="target" class="block text-xs font-medium text-gray-700 mb-1">Target Responden</label>
                <select name="target" 
                    id="target"
                    class="block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-gray-500 focus:ring-gray-500 text-sm py-2.5 px-3.5">
                    <option value="">Semua Target</option>
                    <option value="mahasiswa" {{ $targetFilter === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="dosen" {{ $targetFilter === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="staff" {{ $targetFilter === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="alumni" {{ $targetFilter === 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="stakeholder" {{ $targetFilter === 'stakeholder' ? 'selected' : '' }}>Stakeholder</option>
                </select>
            </div>

            <!-- Filter Button -->
            <div class="sm:col-span-1 flex items-end">
                <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 shadow-sm">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="mt-6 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Kuesioner
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Target
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Status
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Periode
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Responden
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Dibuat
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($kuesioner as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                    <i class="{{ $item->icon }} text-indigo-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ $item->judul }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->pertanyaan->count() }} Pertanyaan</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                            {{ $item->target_responden }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if ($item->status_aktif)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-xs">
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - 
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <i class="fas fa-users text-gray-400 mr-2"></i>
                                            <span class="font-medium">{{ $item->responden_count }}</span>
                                            <span class="text-gray-500 ml-1">Responden</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-xs">
                                            <div class="font-medium text-gray-700">{{ $item->admin->nama ?? 'Admin' }}</div>
                                            <div>{{ $item->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button type="button" class="text-gray-400 hover:text-gray-600" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="text-blue-400 hover:text-blue-600" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="text-green-400 hover:text-green-600" title="Hasil">
                                                <i class="fas fa-chart-bar"></i>
                                            </button>
                                            <button type="button" class="text-red-400 hover:text-red-600" title="Hapus">
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
                    <div class="mt-4">
                        {{ $kuesioner->links('pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
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
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex text-green-400 hover:text-green-500">
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
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex text-red-400 hover:text-red-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Kelola Kuesioner</h1>
            <p class="mt-2 text-sm text-gray-700">Daftar semua kuesioner yang telah dibuat</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-3">
            <a href="{{ route('dashboard.kuesioner.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 cursor-pointer">
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
                <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 shadow-sm cursor-pointer">
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
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($kuesioner as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                                    <i class="{{ $item->icon }} text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ $item->judul }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->pertanyaan->count() }} Pertanyaan</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach((array) $item->target_responden as $target)
                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 capitalize">
                                                    {{ $target }}
                                                </span>
                                            @endforeach
                                        </div>
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
                                            <a href="{{ route('dashboard.kuesioner.show', $item) }}" class="text-gray-400 hover:text-gray-600 cursor-pointer" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.kuesioner.edit', $item) }}" class="text-blue-400 hover:text-blue-600 cursor-pointer" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Toggle Status -->
                                            <form action="{{ route('dashboard.kuesioner.toggle-status', $item) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="{{ $item->status_aktif ? 'text-yellow-400 hover:text-yellow-600' : 'text-green-400 hover:text-green-600' }} cursor-pointer" title="{{ $item->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i class="fas fa-{{ $item->status_aktif ? 'toggle-on' : 'toggle-off' }}"></i>
                                                </button>
                                            </form>

                                            <!-- Delete -->
                                            <button type="button" onclick="confirmDelete({{ $item->id }}, '{{ $item->judul }}')" class="text-red-400 hover:text-red-600 cursor-pointer" title="Hapus">
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

<!-- Enhanced Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-50" style="background-color: rgba(0, 0, 0, 0.4);">
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <!-- Modal Content -->
            <div id="modalContent" class="relative transform rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg animate-modal-in">
                
                <!-- Header with Gradient -->
                <div class="relative bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                    <!-- Close Button -->
                    <button type="button" onclick="closeDeleteModal()" class="absolute top-4 right-4 text-white hover:text-red-100 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                    
                    <!-- Icon and Title -->
                    <div class="flex items-center">
                        <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-white bg-opacity-20 backdrop-blur-sm">
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
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kuesioner yang akan dihapus:</p>
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
                    </div>
                </div>

                <!-- Footer with Action Buttons -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row-reverse gap-3">
                    <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="deleteButton" class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-red-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-trash-alt mr-2" id="deleteIcon"></i>
                            <span id="deleteButtonText">Ya, Hapus Kuesioner</span>
                            <i class="fas fa-spinner fa-spin ml-2" id="deleteSpinner" style="display: none;"></i>
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-md hover:bg-gray-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 border border-gray-300">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add CSS for animations -->
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
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Prevent body scroll when modal is open */
body.modal-open {
    overflow: hidden;
}
</style>

<script>
function confirmDelete(id, title) {
    console.log('Opening delete modal for:', id, title);
    
    // Set title and form action
    document.getElementById('deleteTitle').textContent = title;
    document.getElementById('deleteForm').action = `/dashboard/kuesioner/${id}`;
    
    // Show modal
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    document.body.classList.add('modal-open');
    
    // Reset button and spinner state
    const button = document.getElementById('deleteButton');
    const buttonText = document.getElementById('deleteButtonText');
    const spinner = document.getElementById('deleteSpinner');
    const icon = document.getElementById('deleteIcon');
    
    buttonText.textContent = 'Ya, Hapus Kuesioner';
    spinner.style.display = 'none';
    icon.style.display = 'inline-block';
    button.disabled = false;
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    document.body.classList.remove('modal-open');
}

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const button = document.getElementById('deleteButton');
            const buttonText = document.getElementById('deleteButtonText');
            const spinner = document.getElementById('deleteSpinner');
            const icon = document.getElementById('deleteIcon');
            
            // Show loading state
            buttonText.textContent = 'Menghapus...';
            icon.style.display = 'none';
            spinner.style.display = 'inline-block';
            button.disabled = true;
            
            console.log('Form submitting to:', deleteForm.action);
            
            // Let form submit naturally
        });
    }
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (!modal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });
    
    // Close modal when clicking outside (on backdrop)
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            // Only close if clicking the backdrop itself, not the modal content
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }
});
</script>
@endsection
```

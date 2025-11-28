/**
 * Kuesioner Form Logic
 * Handles dynamic question adding/removing and option toggling
 */

let pertanyaanCount = 0;

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Icon Preview
    const iconSelect = document.getElementById('icon');
    if (iconSelect) {
        iconSelect.addEventListener('change', updateIconPreview);
        // Trigger initial preview
        updateIconPreview.call(iconSelect);
    }

    // Initialize Questions
    const container = document.getElementById('daftarPertanyaan');
    if (container) {
        const existingData = container.dataset.questions;
        if (existingData) {
            try {
                const questions = JSON.parse(existingData);
                if (Array.isArray(questions) && questions.length > 0) {
                    questions.forEach(q => tambahPertanyaan(q));
                } else {
                    tambahPertanyaan();
                }
            } catch (e) {
                console.error('Error parsing questions data:', e);
                tambahPertanyaan();
            }
        } else {
            tambahPertanyaan();
        }
    }
});

function updateIconPreview() {
    const iconClass = this.value;
    const preview = document.getElementById('iconPreview');
    if (preview) {
        if (iconClass) {
            preview.innerHTML = `<i class="${iconClass} text-blue-600"></i>`;
        } else {
            preview.innerHTML = '<i class="fas fa-image"></i>';
        }
    }
}

function tambahPertanyaan(data = null) {
    const container = document.getElementById('daftarPertanyaan');
    if (!container) return;

    const index = pertanyaanCount;
    const currentNumber = container.querySelectorAll('.pertanyaan-item').length + 1;

    // Default values
    const teks = data ? data.teks_pertanyaan : '';
    const jenis = data ? data.jenis_pertanyaan : '';
    const kategori = data ? data.kategori || '' : '';
    const wajib = data ? (data.wajib_diisi == 1 || data.wajib_diisi === true) : true;
    const idInput = data && data.id ? `<input type="hidden" name="pertanyaan[${index}][id]" value="${data.id}">` : '';

    let opsiHtml = '';
    let displayOpsi = 'none';
    let requiredOpsi = '';

    if (jenis === 'pilihan_ganda') {
        displayOpsi = 'block';
        requiredOpsi = 'required';

        let opsiList = [];
        if (data && data.opsi_jawaban) {
            opsiList = Array.isArray(data.opsi_jawaban) ? data.opsi_jawaban : JSON.parse(data.opsi_jawaban);
        }

        // Jika tidak ada opsi (baru switch ke pilihan ganda atau data kosong), siapkan 2 opsi kosong
        if (opsiList.length === 0 && !data) {
            opsiList = ['', ''];
        }

        opsiList.forEach((opsi, i) => {
            opsiHtml += createOpsiHtml(index, i + 1, opsi);
        });
    } else {
        // Default 2 opsi kosong untuk persiapan jika user switch ke pilihan ganda
        opsiHtml += createOpsiHtml(index, 1, '');
        opsiHtml += createOpsiHtml(index, 2, '');
    }

    const html = `
        <div class="pertanyaan-item bg-gray-50 rounded-lg border border-gray-200 p-5 mb-4" data-index="${index}">
            ${idInput}
            <div class="flex items-start justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Pertanyaan ${currentNumber}</h4>
                <button type="button" onclick="hapusPertanyaan(this)" class="text-red-600 hover:text-red-800 cursor-pointer" title="Hapus Pertanyaan">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Teks Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="pertanyaan[${index}][teks_pertanyaan]" 
                        rows="2"
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan pertanyaan..."
                        required
                    >${teks}</textarea>
                </div>
                
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="pertanyaan[${index}][jenis_pertanyaan]"
                        class="jenis-pertanyaan-select w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        onchange="toggleOpsiJawaban(this)"
                        required
                    >
                        <option value="">Pilih Jenis</option>
                        <option value="likert" ${jenis === 'likert' ? 'selected' : ''}>Skala Likert (1-5)</option>
                        <option value="pilihan_ganda" ${jenis === 'pilihan_ganda' ? 'selected' : ''}>Pilihan Ganda</option>
                        <option value="isian" ${jenis === 'isian' ? 'selected' : ''}>Isian Teks</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="text" 
                            name="pertanyaan[${index}][kategori]"
                            value="${kategori}"
                            class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Contoh: Layanan, Fasilitas, dll"
                        >
                        
                        <div class="flex items-center flex-shrink-0">
                            <input 
                                type="checkbox" 
                                name="pertanyaan[${index}][wajib_diisi]"
                                value="1"
                                ${wajib ? 'checked' : ''}
                                class="rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                id="wajib_${index}"
                            >
                            <label for="wajib_${index}" class="ml-2 text-sm text-gray-700">
                                <i class="fas fa-asterisk text-red-500 text-xs mr-1"></i>
                                Wajib diisi
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Opsi Jawaban untuk Pilihan Ganda -->
                <div class="md:col-span-3 opsi-jawaban-container" style="display: ${displayOpsi};">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Opsi Jawaban <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2 opsi-list" data-pertanyaan="${index}">
                        ${opsiHtml}
                    </div>
                    <button type="button" onclick="tambahOpsi(${index})" class="mt-2 text-sm text-blue-600 hover:text-blue-800 cursor-pointer inline-flex items-center">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Tambah Opsi
                    </button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    pertanyaanCount++;
}

function createOpsiHtml(pertanyaanIndex, opsiIndex, value = '') {
    return `
        <div class="flex gap-2 opsi-item">
            <input 
                type="text" 
                name="pertanyaan[${pertanyaanIndex}][opsi][]"
                value="${value.replace(/"/g, '&quot;')}"
                class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Opsi ${opsiIndex}"
            >
            <button type="button" onclick="hapusOpsi(this)" class="px-3 py-2 text-red-600 hover:text-red-800 cursor-pointer" title="Hapus Opsi">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
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
    const opsiInputs = pertanyaanItem.querySelectorAll('.opsi-jawaban-container input[type="text"]');

    if (selectElement.value === 'pilihan_ganda') {
        opsiContainer.style.display = 'block';
        opsiInputs.forEach(input => input.required = true);
    } else {
        opsiContainer.style.display = 'none';
        opsiInputs.forEach(input => input.required = false);
    }
}

function tambahOpsi(pertanyaanIndex) {
    const opsiList = document.querySelector(`.opsi-list[data-pertanyaan="${pertanyaanIndex}"]`);
    if (!opsiList) return;

    const opsiCount = opsiList.querySelectorAll('.opsi-item').length + 1;
    const html = createOpsiHtml(pertanyaanIndex, opsiCount, '');

    opsiList.insertAdjacentHTML('beforeend', html);

    // Pastikan required jika sedang ditampilkan
    const container = opsiList.closest('.opsi-jawaban-container');
    if (container.style.display !== 'none') {
        const newInput = opsiList.lastElementChild.querySelector('input');
        if (newInput) newInput.required = true;
    }
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

// Expose functions to global scope
window.tambahPertanyaan = tambahPertanyaan;
window.hapusPertanyaan = hapusPertanyaan;
window.toggleOpsiJawaban = toggleOpsiJawaban;
window.tambahOpsi = tambahOpsi;
window.hapusOpsi = hapusOpsi;

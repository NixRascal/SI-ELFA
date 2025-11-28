function confirmDelete(id, name) {
    console.log('Opening delete modal for admin:', id, name);

    // Set nama dan action form
    const nameElement = document.getElementById('deleteAdminName');
    const formElement = document.getElementById('deleteForm');

    if (nameElement) nameElement.textContent = name;
    if (formElement) formElement.action = `/dashboard/admin/${id}`;

    // Tampilkan modal
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    }

    // Reset state tombol dan spinner
    const button = document.getElementById('deleteButton');
    const buttonText = document.getElementById('deleteButtonText');
    const spinner = document.getElementById('deleteSpinner');
    const icon = document.getElementById('deleteIcon');

    if (buttonText) buttonText.textContent = 'Ya, Hapus Admin';
    if (spinner) spinner.style.display = 'none';
    if (icon) icon.style.display = 'inline-block';
    if (button) button.disabled = false;
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('modal-open');
    }
}

// Expose functions to global scope
window.confirmDelete = confirmDelete;
window.closeDeleteModal = closeDeleteModal;

// Handle submit form
document.addEventListener('DOMContentLoaded', function () {
    const deleteForm = document.getElementById('deleteForm');

    if (deleteForm) {
        deleteForm.addEventListener('submit', function (e) {
            const button = document.getElementById('deleteButton');
            const buttonText = document.getElementById('deleteButtonText');
            const spinner = document.getElementById('deleteSpinner');
            const icon = document.getElementById('deleteIcon');

            // Tampilkan state loading
            if (buttonText) buttonText.textContent = 'Menghapus...';
            if (icon) icon.style.display = 'none';
            if (spinner) spinner.style.display = 'inline-block';
            if (button) button.disabled = true;

            console.log('Form submitting to:', deleteForm.action);

            // Biarkan form submit secara natural
        });
    }

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });

    // Tutup modal saat klik di luar (backdrop)
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function (e) {
            // Hanya tutup jika klik backdrop, bukan konten modal
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }
});

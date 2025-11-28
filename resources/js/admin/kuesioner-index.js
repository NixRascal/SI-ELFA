function confirmDelete(id, title) {
    console.log('Opening delete modal for:', id, title);

    // Set title and form action
    const titleElement = document.getElementById('deleteTitle');
    const formElement = document.getElementById('deleteForm');

    if (titleElement) titleElement.textContent = title;
    if (formElement) formElement.action = `/dashboard/kuesioner/${id}`;

    // Reset input
    const input = document.getElementById('deleteConfirmationInput');
    if (input) input.value = '';

    // Show modal
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    }

    // Reset button and spinner state
    const button = document.getElementById('deleteButton');
    const buttonText = document.getElementById('deleteButtonText');
    const spinner = document.getElementById('deleteSpinner');
    const icon = document.getElementById('deleteIcon');

    if (buttonText) buttonText.textContent = 'Ya, Hapus Kuesioner';
    if (spinner) spinner.style.display = 'none';
    if (icon) icon.style.display = 'inline-block';
    if (button) button.disabled = true; // Initially disabled

    // Focus input
    if (input) setTimeout(() => input.focus(), 100);
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

// Handle confirmation input and form submit
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('deleteConfirmationInput');
    const button = document.getElementById('deleteButton');

    if (input && button) {
        input.addEventListener('input', function () {
            if (this.value.toLowerCase() === 'hapus kuesioner') {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        });
    }

    const deleteForm = document.getElementById('deleteForm');

    if (deleteForm) {
        deleteForm.addEventListener('submit', function (e) {
            const button = document.getElementById('deleteButton');
            const buttonText = document.getElementById('deleteButtonText');
            const spinner = document.getElementById('deleteSpinner');
            const icon = document.getElementById('deleteIcon');

            // Show loading state
            if (buttonText) buttonText.textContent = 'Menghapus...';
            if (icon) icon.style.display = 'none';
            if (spinner) spinner.style.display = 'inline-block';
            if (button) button.disabled = true;

            console.log('Form submitting to:', deleteForm.action);

            // Let form submit naturally
        });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });

    // Close modal when clicking outside (on backdrop)
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function (e) {
            // Only close if clicking the backdrop itself, not the modal content
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }
});

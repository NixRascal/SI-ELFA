document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('generate-ai-btn');

    if (!generateBtn) return;

    const aiLoading = document.getElementById('ai-loading');
    const aiContent = document.getElementById('ai-content');
    const aiResult = document.getElementById('ai-result');
    const aiError = document.getElementById('ai-error');
    const aiErrorMessage = document.getElementById('ai-error-message');
    const aiPlaceholder = document.getElementById('ai-placeholder');

    generateBtn.addEventListener('click', async function () {
        // Ambil URL dan Token dari data attributes
        const routeUrl = generateBtn.dataset.route;
        const csrfToken = generateBtn.dataset.csrf;

        if (!routeUrl) {
            console.error('Route URL not found');
            return;
        }

        // Sembunyikan semua bagian
        aiPlaceholder.classList.add('hidden');
        aiContent.classList.add('hidden');
        aiError.classList.add('hidden');

        // Tampilkan loading
        aiLoading.classList.remove('hidden');
        generateBtn.disabled = true;
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menganalisis...';

        try {
            const response = await fetch(routeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const data = await response.json();

            // Sembunyikan loading
            aiLoading.classList.add('hidden');

            if (data.success) {
                // Tampilkan hasil
                aiContent.classList.remove('hidden');

                // Parse markdown ke HTML (menggunakan marked.js yang sudah di-load via CDN di blade)
                // Pastikan marked tersedia global
                if (typeof marked !== 'undefined') {
                    const htmlContent = marked.parse(data.analysis);
                    aiResult.innerHTML = htmlContent;
                } else {
                    aiResult.textContent = data.analysis;
                    console.warn('Marked.js not loaded');
                }

                // Update tombol
                generateBtn.innerHTML = '<i class="fas fa-sync mr-2"></i> Generate Ulang';
            } else {
                // Tampilkan error
                aiError.classList.remove('hidden');
                aiErrorMessage.textContent = data.error || 'Terjadi kesalahan saat menganalisis data';
            }

        } catch (error) {
            // Sembunyikan loading
            aiLoading.classList.add('hidden');

            // Tampilkan error
            aiError.classList.remove('hidden');
            aiErrorMessage.textContent = 'Gagal terhubung ke server: ' + error.message;
        } finally {
            generateBtn.disabled = false;
            if (!aiContent.classList.contains('hidden')) {
                generateBtn.innerHTML = '<i class="fas fa-sync mr-2"></i> Generate Ulang';
            } else {
                generateBtn.innerHTML = '<i class="fas fa-magic mr-2"></i> Generate Analisis';
            }
        }
    });
});

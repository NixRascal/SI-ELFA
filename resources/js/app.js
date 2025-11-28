import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const scrollBtn = document.getElementById('scrollToSurvey');
    if (scrollBtn) {
        scrollBtn.addEventListener('click', e => {
            e.preventDefault();
            const section = document.getElementById('survey-section');
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
                history.replaceState(null, null, ' ');
            }
        });
    }

    // Auto-scroll ke survey section saat pindah halaman pagination atau menggunakan filter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('page') || urlParams.has('cariSurvei') || urlParams.has('target')) {
        const section = document.getElementById('survey-section');
        if (section) {
            // Delay sedikit untuk memastikan konten sudah dimuat
            setTimeout(() => {
                section.scrollIntoView({ behavior: 'auto' });
            }, 100);
        }
    }
});

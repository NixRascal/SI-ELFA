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
});

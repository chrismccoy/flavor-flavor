/**
 * Flavor Flavor Theme Scripts
 */
document.addEventListener('DOMContentLoaded', function () {
    // Scroll to top button
    var scrollBtn = document.getElementById('scrolltop');

    if (scrollBtn) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 350) {
                scrollBtn.classList.remove('hidden');
                scrollBtn.classList.add('flex');
            } else {
                scrollBtn.classList.add('hidden');
                scrollBtn.classList.remove('flex');
            }
        });

        scrollBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Mobile menu toggle
    var menuBtn = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});

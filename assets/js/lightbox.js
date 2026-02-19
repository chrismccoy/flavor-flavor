/**
 * Flavor Flavor – Brutalism Lightbox
 * Click any gallery image to open; supports prev/next, keyboard, and swipe.
 */
(function () {
    'use strict';

    var overlay   = null;
    var imgEl     = null;
    var captionEl = null;
    var counterEl = null;
    var current   = 0;
    var items     = [];

    function buildOverlay() {
        if (overlay) return;

        overlay = document.createElement('div');
        overlay.id = 'flavor-lightbox';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('aria-label', 'Image lightbox');
        overlay.className = [
            'fixed inset-0 z-50 hidden',
            'bg-pop-black/90 flex flex-col items-center justify-center',
            'p-4 md:p-8'
        ].join(' ');

        // Close button
        var closeBtn = document.createElement('button');
        closeBtn.className = [
            'absolute top-4 right-4 z-10',
            'btn-physics w-14 h-14 bg-pop-yellow border-2 border-pop-black shadow-hard-sm',
            'flex items-center justify-center text-2xl font-black'
        ].join(' ');
        closeBtn.innerHTML = '<span class="fa-solid fa-xmark"></span>';
        closeBtn.setAttribute('aria-label', 'Close lightbox');
        closeBtn.addEventListener('click', close);

        // Prev button
        var prevBtn = document.createElement('button');
        prevBtn.className = [
            'absolute left-4 top-1/2 -translate-y-1/2 z-10',
            'btn-physics w-14 h-14 bg-white border-2 border-pop-black shadow-hard-sm',
            'flex items-center justify-center text-2xl'
        ].join(' ');
        prevBtn.innerHTML = '<span class="fa-solid fa-arrow-left"></span>';
        prevBtn.setAttribute('aria-label', 'Previous image');
        prevBtn.addEventListener('click', prev);

        // Next button
        var nextBtn = document.createElement('button');
        nextBtn.className = [
            'absolute right-4 top-1/2 -translate-y-1/2 z-10',
            'btn-physics w-14 h-14 bg-white border-2 border-pop-black shadow-hard-sm',
            'flex items-center justify-center text-2xl'
        ].join(' ');
        nextBtn.innerHTML = '<span class="fa-solid fa-arrow-right"></span>';
        nextBtn.setAttribute('aria-label', 'Next image');
        nextBtn.addEventListener('click', next);

        // Image wrapper with hard shadow
        var imgWrap = document.createElement('div');
        imgWrap.className = 'relative max-w-4xl w-full flex-shrink';

        var imgShadow = document.createElement('div');
        imgShadow.className = 'absolute inset-0 bg-pop-pink translate-x-2 translate-y-2';
        imgShadow.setAttribute('aria-hidden', 'true');

        var imgContainer = document.createElement('div');
        imgContainer.className = 'relative hard-outline bg-white overflow-hidden';

        imgEl = document.createElement('img');
        imgEl.className = 'w-full h-auto max-h-[70vh] object-contain m-0 !border-0';
        imgEl.alt = '';

        imgContainer.appendChild(imgEl);
        imgWrap.appendChild(imgShadow);
        imgWrap.appendChild(imgContainer);

        // Bottom bar: counter + caption
        var bottomBar = document.createElement('div');
        bottomBar.className = 'mt-4 flex flex-col sm:flex-row items-center gap-3 max-w-4xl w-full';

        counterEl = document.createElement('span');
        counterEl.className = 'badge bg-pop-cyan shrink-0';

        captionEl = document.createElement('p');
        captionEl.className = 'font-mono text-sm text-white text-center sm:text-left';

        bottomBar.appendChild(counterEl);
        bottomBar.appendChild(captionEl);

        overlay.appendChild(closeBtn);
        overlay.appendChild(prevBtn);
        overlay.appendChild(nextBtn);
        overlay.appendChild(imgWrap);
        overlay.appendChild(bottomBar);

        // Click overlay background to close
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) close();
        });

        document.body.appendChild(overlay);
    }

    function open(galleryLinks, index) {
        buildOverlay();
        items   = galleryLinks;
        current = index;
        show();
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', onKey);
    }

    function close() {
        if (!overlay) return;
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKey);
    }

    function show() {
        if (!items.length) return;
        var item = items[current];
        imgEl.src = item.href;
        imgEl.alt = item.alt || '';
        captionEl.textContent = item.caption || '';
        counterEl.innerHTML =
            '<span class="fa-solid fa-image" aria-hidden="true"></span> ' +
            (current + 1) + ' / ' + items.length;
    }

    function prev() {
        current = (current - 1 + items.length) % items.length;
        show();
    }

    function next() {
        current = (current + 1) % items.length;
        show();
    }

    function onKey(e) {
        if (e.key === 'Escape')                         close();
        if (e.key === 'ArrowLeft'  || e.key === 'Left') prev();
        if (e.key === 'ArrowRight' || e.key === 'Right') next();
    }

    var touchStartX = 0;

    document.addEventListener('touchstart', function (e) {
        if (!overlay || overlay.classList.contains('hidden')) return;
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    document.addEventListener('touchend', function (e) {
        if (!overlay || overlay.classList.contains('hidden')) return;
        var dx = e.changedTouches[0].screenX - touchStartX;
        if (Math.abs(dx) > 50) {
            dx > 0 ? prev() : next();
        }
    }, { passive: true });

    document.addEventListener('click', function (e) {
        var link = e.target.closest('.flavor-gallery-link');
        if (!link) return;

        e.preventDefault();

        var galleryId = link.getAttribute('data-gallery');
        var allLinks  = document.querySelectorAll(
            '.flavor-gallery-link[data-gallery="' + galleryId + '"]'
        );

        var galleryItems = [];
        allLinks.forEach(function (a) {
            galleryItems.push({
                href:    a.href,
                alt:     a.getAttribute('aria-label') || '',
                caption: a.getAttribute('data-caption') || ''
            });
        });

        var idx = parseInt(link.getAttribute('data-index'), 10) || 0;
        open(galleryItems, idx);
    });
})();

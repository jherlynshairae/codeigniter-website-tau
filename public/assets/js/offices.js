document.addEventListener('DOMContentLoaded', function () {
    // Measure the real header height so the drawer/backdrop start exactly
    // below it instead of guessing a fixed pixel value.
    function syncHeaderHeight() {
        var headerEl = document.querySelector('header')
            || document.querySelector('.site-header')
            || document.querySelector('.header')
            || document.getElementById('header')
            || document.querySelector('nav.navbar');

        if (headerEl) {
            document.documentElement.style.setProperty(
                '--tau-header-height',
                headerEl.offsetHeight + 'px'
            );
        }
    }

    syncHeaderHeight();
    window.addEventListener('resize', syncHeaderHeight);

    var cards = document.querySelectorAll('.office-card');
    var drawer = document.getElementById('officeDrawer');
    var backdrop = document.getElementById('officeDrawerBackdrop');
    var closeBtn = document.getElementById('officeDrawerClose');

    var titleEl = document.getElementById('officeDrawerTitle');
    var locationEl = document.getElementById('officeDrawerLocation');
    var purposeEl = document.getElementById('officeDrawerPurpose');

    var imageWrap = document.getElementById('officeDrawerImageWrap');
    var imageEl = document.getElementById('officeDrawerImage');
    var fallbackLabelEl = document.getElementById('officeDrawerFallbackLabel');
    var cityEl = document.getElementById('officeDrawerCity');

    var lastFocusedCard = null;

    function openDrawer(card) {
        titleEl.textContent = card.dataset.title || '';
        locationEl.textContent = card.dataset.location || '';
        purposeEl.textContent = card.dataset.purpose || 'Not specified';
        fallbackLabelEl.textContent = card.dataset.title || '';
        cityEl.textContent = card.dataset.city || '';

        // Reset image + fallback state before loading the new one
        imageEl.classList.remove('img-fallback');
        imageWrap.classList.remove('is-fallback');
        imageEl.src = card.dataset.image || '';
        imageEl.alt = card.dataset.title || '';

        // Restart the staggered reveal animation even if the drawer
        // was already open for a different card: drop .is-open, force
        // a reflow, then re-add it so the CSS transitions replay.
        drawer.classList.remove('is-open');
        // eslint-disable-next-line no-unused-expressions
        drawer.offsetHeight; // force reflow
        drawer.classList.add('is-open');

        backdrop.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');

        lastFocusedCard = card;
        closeBtn.focus();
    }

    function closeDrawer() {
        drawer.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');

        if (lastFocusedCard) {
            lastFocusedCard.focus();
        }
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function () {
            openDrawer(card);
        });

        // Keyboard support: cards are focusable (tabindex="0") in the view
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openDrawer(card);
            }
        });
    });

    closeBtn.addEventListener('click', closeDrawer);
    backdrop.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeDrawer();
        }
    });
});
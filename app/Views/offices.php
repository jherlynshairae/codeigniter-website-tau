<link rel="stylesheet" href="<?= base_url('assets/css/offices.css') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
<link rel="icon" type="image/png" href="<?= base_url('assets/Images/taulogo.png') ?>">
<?= $this->include('partials/header') ?>
<!-- ===== HERO ===== -->
<section class="offices-hero">
    <div class="offices-hero__overlay"></div>
    <div class="offices-hero__card">
        <h1>Find your next office</h1>
        <p>Search TAU's offices and departments across campus</p>

        <form class="offices-hero__search" action="<?= base_url('offices') ?>" method="get">
            <input type="text" name="q" placeholder="Enter office or department">
            <button type="submit">Search</button>
        </form>
    </div>
</section>

<!-- ===== LISTINGS (grouped by city/building, from OfficeModel) ===== -->
<section class="offices-listings">
    <?php if (empty($offices)): ?>
        <p class="offices-empty">No offices found yet. Run <code>php spark db:seed OfficeSeeder</code> to load sample data.</p>
    <?php endif; ?>

    <?php foreach ($offices as $city => $cityOffices): ?>
        <div class="offices-group">
            <h2 class="offices-group__title">
                <?= esc($city) ?>
                <?php if ($cityOffices[0]['is_top_pick']): ?>
                    <span class="offices-badge">TOP PICKS</span>
                <?php endif; ?>
            </h2>

            <div class="offices-grid">
                <?php foreach ($cityOffices as $office): ?>
                    <div class="office-card"
                         tabindex="0"
                         role="button"
                         aria-haspopup="dialog"
                         data-title="<?= esc($office['title']) ?>"
                         data-location="<?= esc($office['location']) ?>"
                         data-purpose="<?= esc($office['purpose'] ?? '') ?>"
                         data-image="<?= base_url($office['image_path']) ?>"
                         data-city="<?= esc($city) ?>">
                        <div class="office-card__image-wrap">
                            <img src="<?= base_url($office['image_path']) ?>"
                                 alt="<?= esc($office['title']) ?>"
                                 onerror="this.classList.add('img-fallback'); this.parentElement.classList.add('is-fallback');">
                            <span class="office-card__fallback-label"><?= esc($office['title']) ?></span>
                        </div>
                        <div class="office-card__caption">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 21s-7-7.2-7-12a7 7 0 0 1 14 0c0 4.8-7 12-7 12z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            <?= esc($office['location']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<!-- ===== SLIDE-IN DRAWER (left -> right, photo + animated content) ===== -->
<div class="office-drawer" id="officeDrawer" aria-hidden="true">
    <button class="office-drawer__close" id="officeDrawerClose" aria-label="Close">&times;</button>

    <div class="office-drawer__image-wrap" id="officeDrawerImageWrap">
        <img id="officeDrawerImage" src="" alt=""
             onerror="this.classList.add('img-fallback'); this.parentElement.classList.add('is-fallback');">
        <span class="office-drawer__fallback-label" id="officeDrawerFallbackLabel"></span>
        <div class="office-drawer__image-fade"></div>
        <span class="office-drawer__chip" id="officeDrawerChip">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                <path d="M3 21h18M6 21V7l6-4 6 4v14M9 21v-6h6v6"/>
            </svg>
            <span id="officeDrawerCity"></span>
        </span>
    </div>

    <div class="office-drawer__body" id="officeDrawerBody">
        <h3 id="officeDrawerTitle"></h3>
        <div class="office-drawer__field">
            <span class="office-drawer__label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                    <path d="M12 21s-7-7.2-7-12a7 7 0 0 1 14 0c0 4.8-7 12-7 12z"/>
                    <circle cx="12" cy="9" r="2.5"/>
                </svg>
                Location
            </span>
            <p id="officeDrawerLocation"></p>
        </div>
        <div class="office-drawer__divider"></div>
        <div class="office-drawer__field">
            <span class="office-drawer__label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 8v5M12 16h.01"/>
                </svg>
                Purpose
            </span>
            <p id="officeDrawerPurpose"></p>
        </div>
    </div>
</div>
<div class="office-drawer__backdrop" id="officeDrawerBackdrop"></div>

<script src="<?= base_url('assets/js/offices.js') ?>"></script>
<script src="<?= base_url('assets/script.js') ?>"></script>
<?= $this->include('partials/footer') ?>
<header class="shadow-sm bg-white border-bottom mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center py-2 px-4">
        <div class="d-flex align-items-center gap-3">
            <span class="fw-bold text-success fs-5" style="color: #004d25 !important;">
                TARLAC AGRICULTURAL UNIVERSITY - ADMIN
            </span>
        </div>
        <nav class="d-flex align-items-center gap-4">
            <a href="<?= base_url('admin/dashboard') ?>" class="text-dark text-decoration-none fw-medium">Dashboard</a>
            <a href="<?= base_url('admin/research') ?>" class="text-dark text-decoration-none fw-medium">Research</a>
            <a href="<?= base_url('admin/news') ?>" class="text-dark text-decoration-none fw-medium">News</a>
            <a href="<?= base_url('admin/offices') ?>" class="text-dark text-decoration-none fw-medium">Manage Offices</a>
        </nav>
        <div>
            <a href="<?= base_url('admin/logout') ?>" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</header>
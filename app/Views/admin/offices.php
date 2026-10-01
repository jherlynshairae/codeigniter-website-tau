<?php
$mode   = $mode ?? 'list';
$isForm = in_array($mode, ['create', 'edit'], true);
$item   = $item ?? [];
$errors = session()->getFlashdata('errors') ?? [];

// After a failed validation, prefer what the user typed over the saved values
$hasOld   = old('title') !== null;
$topPick  = $hasOld ? (bool) old('is_top_pick') : (bool) ($item['is_top_pick'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Offices - TAU Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root { --tau-green: #004d25; --tau-gold: #ffcc00; }
        .bg-tau { background-color: var(--tau-green); color: white; }
        .btn-tau { background-color: var(--tau-green); color: white; border: none; }
        .btn-tau:hover { background-color: #003318; color: var(--tau-gold); }
        .office-thumb { width: 72px; height: 48px; object-fit: cover; border-radius: 6px; background: #e9ecef; }
        .preview-img { max-width: 260px; max-height: 170px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6; }
    </style>
</head>
<body class="bg-light">

    <?= view('admin/partials/header') ?>

    <div class="container my-5">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (! empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($isForm): ?>
            <!-- ===== CREATE / EDIT FORM ===== -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-tau d-flex justify-content-between align-items-center">
                    <h4 class="m-0 py-1"><?= $mode === 'edit' ? 'Edit Office' : 'Add Office' ?></h4>
                    <a href="<?= base_url('admin/offices') ?>" class="btn btn-sm btn-light">Back to List</a>
                </div>
                <div class="card-body p-4">
                    <form action="<?= $mode === 'edit'
                                    ? base_url('admin/offices/update/' . $item['id'])
                                    : base_url('admin/offices/store') ?>"
                          method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Office Name</label>
                            <input type="text" class="form-control" name="title" maxlength="150"
                                   value="<?= esc(old('title', $item['title'] ?? '')) ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Group</label>
                                <input type="text" class="form-control" name="city" maxlength="100" list="cityOptions"
                                       placeholder="e.g. TAU Main Campus"
                                       value="<?= esc(old('city', $item['city'] ?? '')) ?>" required>
                                <datalist id="cityOptions">
                                    <?php foreach (($cities ?? []) as $c): ?>
                                        <option value="<?= esc($c) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                                <small class="text-muted">Offices with the same group appear together on the public page.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" class="form-control" name="location" maxlength="255"
                                       placeholder="e.g. Admin Building, Ground Floor"
                                       value="<?= esc(old('location', $item['location'] ?? '')) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Purpose</label>
                            <textarea class="form-control" name="purpose" rows="3" maxlength="255"
                                      placeholder="What this office is for"><?= esc(old('purpose', $item['purpose'] ?? '')) ?></textarea>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Display Order</label>
                                <input type="number" class="form-control" name="sort_order"
                                       value="<?= esc(old('sort_order', $item['sort_order'] ?? 0)) ?>">
                                <small class="text-muted">Lower numbers show first within a group.</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="is_top_pick" value="1" id="topPick"
                                           <?= $topPick ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-semibold" for="topPick">Top Pick</label>
                                </div>
                                <small class="text-muted">Shows the TOP PICKS badge when it's the first office in its group.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Office Photo</label>
                            <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/webp"
                                   <?= $mode === 'create' ? 'required' : '' ?>>
                            <small class="text-muted d-block mt-1">JPG, PNG or WEBP, up to 4 MB.</small>

                            <?php if ($mode === 'edit' && ! empty($item['image_path'])): ?>
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-1">Current photo (leave the file field empty to keep it):</small>
                                    <img src="<?= base_url($item['image_path']) ?>" alt="Current photo" class="preview-img"
                                         onerror="this.style.display='none'">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('admin/offices') ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-tau px-4"><?= $mode === 'edit' ? 'Save Changes' : 'Add Office' ?></button>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <!-- ===== LIST ===== -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-tau d-flex justify-content-between align-items-center">
                    <h4 class="m-0 py-1">Manage Offices</h4>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('offices') ?>" class="btn btn-sm btn-light" target="_blank">View Page</a>
                        <a href="<?= base_url('admin/offices/create') ?>" class="btn btn-sm btn-warning fw-semibold">+ Add Office</a>
                        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-sm btn-light">Dashboard</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">Photo</th>
                                    <th>Office</th>
                                    <th>Group</th>
                                    <th>Location</th>
                                    <th>Order</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (! empty($offices)): ?>
                                    <?php foreach ($offices as $row): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <img src="<?= base_url($row['image_path']) ?>" alt="" class="office-thumb"
                                                     onerror="this.style.visibility='hidden'">
                                            </td>
                                            <td class="fw-semibold">
                                                <?= esc($row['title']) ?>
                                                <?php if ($row['is_top_pick']): ?>
                                                    <span class="badge bg-warning text-dark ms-1">Top Pick</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="badge bg-secondary"><?= esc($row['city']) ?></span></td>
                                            <td><?= esc($row['location']) ?></td>
                                            <td><?= esc($row['sort_order']) ?></td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('admin/offices/edit/' . $row['id']) ?>" class="btn btn-sm btn-tau">Edit</a>
                                                <form action="<?= base_url('admin/offices/delete/' . $row['id']) ?>" method="post" class="d-inline"
                                                      onsubmit="return confirm('Delete &quot;<?= esc($row['title'], 'js') ?>&quot;? This cannot be undone.');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No offices yet. Click "+ Add Office" to create one.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>
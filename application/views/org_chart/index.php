<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-card-head">
        <h2>Sole Shareholder</h2>
        <a href="<?= base_url('org-chart/shareholder') ?>" class="abtn abtn-ghost"><i class="fa-solid fa-pen"></i> Edit</a>
    </div>
    <div style="padding:0 20px 20px;">
        <br>
        <?php if ($shareholder): ?>
            <div class="row-title"><?= html_escape($shareholder->name) ?></div>
            <?php if ($shareholder->sub_title): ?><div class="row-sub"><?= html_escape($shareholder->sub_title) ?></div><?php endif; ?>
        <?php else: ?>
            <span class="pill pill-inactive">Not set up yet</span>
        <?php endif; ?>
    </div>
</div>

<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-card-head">
        <h2>General Manager</h2>
        <a href="<?= base_url('org-chart/manager') ?>" class="abtn abtn-ghost"><i class="fa-solid fa-pen"></i> Edit</a>
    </div>
    <br>
    <div style="padding:0 20px 20px;">
        <?php if ($manager): ?>
            <div class="row-title"><?= html_escape($manager->name) ?></div>
            <?php if ($manager->sub_title): ?><div class="row-sub"><?= html_escape($manager->sub_title) ?></div><?php endif; ?>
        <?php else: ?>
            <span class="pill pill-inactive">Not set up yet</span>
        <?php endif; ?>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Departments (<?= count($departments) ?>)</h2>
        <a href="<?= base_url('org-chart/departments/create') ?>" class="abtn abtn-lime">
            <i class="fa-solid fa-plus"></i> Add Department
        </a>
    </div>

    <?php if (empty($departments)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-sitemap"></i></div>
            <p>No departments yet.</p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Sub Title</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $d): ?>
                <tr>
                    <td><div class="row-title"><?= html_escape($d->name) ?></div></td>
                    <td><div class="row-sub"><?= html_escape($d->sub_title) ?></div></td>
                    <td><?= (int) $d->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('org-chart/departments/toggle/' . $d->id) ?>" style="text-decoration:none;">
                            <?php if ($d->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('org-chart/departments/edit/' . $d->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('org-chart/departments/delete/' . $d->id, [
                                'onsubmit' => "return confirm('Delete \"" . html_escape(addslashes($d->name)) . "\"? This cannot be undone.');"
                            ]) ?>
                                <button type="submit" class="abtn-icon danger" aria-label="Delete" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?= form_close() ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

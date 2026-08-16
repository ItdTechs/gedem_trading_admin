<div class="admin-card">
    <div class="admin-card-head">
        <h2>All Services (<?= count($services) ?>)</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form class="admin-search" method="get" action="<?= base_url('services') ?>">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
                <input type="text" name="q" placeholder="Search services…" value="<?= html_escape($search ?? '') ?>">
            </form>
            <a href="<?= base_url('services/create') ?>" class="abtn abtn-lime">
                <i class="fa-solid fa-plus"></i> Add Service
            </a>
        </div>
    </div>

    <?php if (empty($services)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-hand-holding-droplet"></i></div>
            <p><?= $search ? 'No services match "' . html_escape($search) . '".' : 'No services yet.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                <tr>
                    <td>
                        <div class="row-title"><?= html_escape($s->title) ?></div>
                        <div class="row-sub"><?= html_escape(mb_strimwidth($s->description, 0, 80, '…')) ?></div>
                    </td>
                    <td><?= (int) $s->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('services/toggle/' . $s->id) ?>" style="text-decoration:none;">
                            <?php if ($s->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('services/edit/' . $s->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('services/delete/' . $s->id, [
                                'onsubmit' => "return confirm('Delete \"" . html_escape(addslashes($s->title)) . "\"? This also removes its feature list. This cannot be undone.');"
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

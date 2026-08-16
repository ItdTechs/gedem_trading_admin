<div style="margin-bottom:16px;">
    <a href="<?= base_url('products') ?>" class="abtn abtn-ghost">
        <i class="fa-solid fa-arrow-left"></i> All Categories
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2><?= html_escape($category->name) ?> — Types (<?= count($types) ?>)</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form class="admin-search" method="get" action="<?= base_url('products/types/' . $category->id) ?>">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
                <input type="text" name="q" placeholder="Search types…" value="<?= html_escape($search ?? '') ?>">
            </form>
            <a href="<?= base_url('products/types/' . $category->id . '/create') ?>" class="abtn abtn-lime">
                <i class="fa-solid fa-plus"></i> Add Type
            </a>
        </div>
    </div>

    <?php if (empty($types)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-box"></i></div>
            <p><?= $search ? 'No types match "' . html_escape($search) . '".' : 'No product types in this category yet.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Badge</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($types as $t): ?>
                <tr>
                    <td>
                        <div class="row-title"><?= html_escape($t->name) ?></div>
                        <?php if ($t->description): ?>
                        <div class="row-sub"><?= html_escape(mb_strimwidth($t->description, 0, 80, '…')) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><?= $t->badge_text ? html_escape($t->badge_text) : '<span class="row-sub">—</span>' ?></td>
                    <td><?= (int) $t->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('products/types/toggle/' . $t->id) ?>" style="text-decoration:none;">
                            <?php if ($t->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('products/types/edit/' . $t->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('products/types/delete/' . $t->id, [
                                'onsubmit' => "return confirm('Delete \"" . html_escape(addslashes($t->name)) . "\"? This also removes its item list. This cannot be undone.');"
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

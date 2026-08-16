<div class="admin-card">
    <div class="admin-card-head">
        <h2>Product Categories (<?= count($categories) ?>)</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form class="admin-search" method="get" action="<?= base_url('products') ?>">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
                <input type="text" name="q" placeholder="Search categories…" value="<?= html_escape($search ?? '') ?>">
            </form>
            <a href="<?= base_url('products/create') ?>" class="abtn abtn-lime">
                <i class="fa-solid fa-plus"></i> Add Category
            </a>
        </div>
    </div>

    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-layer-group"></i></div>
            <p><?= $search ? 'No categories match "' . html_escape($search) . '".' : 'No categories yet.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Types</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $c): ?>
                <tr>
                    <td>
                        <div class="row-title"><?= html_escape($c->name) ?></div>
                        <?php if ($c->description): ?>
                        <div class="row-sub"><?= html_escape(mb_strimwidth($c->description, 0, 80, '…')) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><code><?= html_escape($c->slug) ?></code></td>
                    <td>
                        <a href="<?= base_url('products/types/' . $c->id) ?>">
                            <?= (int) $c->type_count ?> type<?= $c->type_count == 1 ? '' : 's' ?>
                        </a>
                    </td>
                    <td><?= (int) $c->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('products/toggle/' . $c->id) ?>" style="text-decoration:none;">
                            <?php if ($c->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('products/types/' . $c->id) ?>" class="abtn-icon" aria-label="Manage Types" title="Manage Types">
                                <i class="fa-solid fa-list"></i>
                            </a>
                            <a href="<?= base_url('products/edit/' . $c->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('products/delete/' . $c->id, [
                                'onsubmit' => "return confirm('Delete \"" . html_escape(addslashes($c->name)) . "\"? This also removes all its product types and their items. This cannot be undone.');"
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

<div class="admin-card">
    <div class="admin-card-head">
        <h2>All Testimonials (<?= count($testimonials) ?>)</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form class="admin-search" method="get" action="<?= base_url('testimonials') ?>">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
                <input type="text" name="q" placeholder="Search testimonials…" value="<?= html_escape($search ?? '') ?>">
            </form>
            <a href="<?= base_url('testimonials/create') ?>" class="abtn abtn-lime">
                <i class="fa-solid fa-plus"></i> Add Testimonial
            </a>
        </div>
    </div>

    <?php if (empty($testimonials)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-quote-left"></i></div>
            <p><?= $search ? 'No testimonials match "' . html_escape($search) . '".' : 'No testimonials yet.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Quote</th>
                    <th>Author / Label</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                <tr>
                    <td><div class="row-sub"><?= html_escape(mb_strimwidth($t->quote, 0, 90, '…')) ?></div></td>
                    <td><div class="row-title"><?= html_escape($t->author_name) ?></div></td>
                    <td><?= (int) $t->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('testimonials/toggle/' . $t->id) ?>" style="text-decoration:none;">
                            <?php if ($t->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('testimonials/edit/' . $t->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('testimonials/delete/' . $t->id, [
                                'onsubmit' => "return confirm('Delete this testimonial from \"" . html_escape(addslashes($t->author_name)) . "\"? This cannot be undone.');"
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

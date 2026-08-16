<div style="margin-bottom:16px;">
    <a href="<?= base_url('content') ?>" class="abtn abtn-ghost">
        <i class="fa-solid fa-arrow-left"></i> All Sections
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2><?= html_escape($section['label']) ?> (<?= count($cards) ?>)</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form class="admin-search" method="get" action="<?= base_url('content/' . $section_key) ?>">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
                <input type="text" name="q" placeholder="Search cards…" value="<?= html_escape($search ?? '') ?>">
            </form>
            <a href="<?= base_url('content/' . $section_key . '/create') ?>" class="abtn abtn-lime">
                <i class="fa-solid fa-plus"></i> Add Card
            </a>
        </div>
    </div>
    <div class="row-sub" style="padding:0 20px 16px;"><?= html_escape($section['hint']) ?></div>

    <?php if (empty($cards)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-note-sticky"></i></div>
            <p><?= $search ? 'No cards match "' . html_escape($search) . '".' : 'No cards in this section yet.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Meta Label</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $c): ?>
                <tr>
                    <td>
                        <div class="row-title"><?= html_escape($c->title) ?></div>
                        <?php if ($c->description): ?>
                        <div class="row-sub"><?= html_escape(mb_strimwidth($c->description, 0, 80, '…')) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><?= $c->meta_label ? html_escape($c->meta_label) : '<span class="row-sub">—</span>' ?></td>
                    <td><?= (int) $c->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('content/toggle/' . $c->id) ?>" style="text-decoration:none;">
                            <?php if ($c->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('content/edit/' . $c->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('content/delete/' . $c->id, [
                                'onsubmit' => "return confirm('Delete \"" . html_escape(addslashes($c->title)) . "\"? This cannot be undone.');"
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

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Process Steps (<?= count($steps) ?>)</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form class="admin-search" method="get" action="<?= base_url('process-steps') ?>">
                <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
                <input type="text" name="q" placeholder="Search steps…" value="<?= html_escape($search ?? '') ?>">
            </form>
            <a href="<?= base_url('process-steps/create') ?>" class="abtn abtn-lime">
                <i class="fa-solid fa-plus"></i> Add Step
            </a>
        </div>
    </div>

    <?php if (empty($steps)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-list-ol"></i></div>
            <p><?= $search ? 'No steps match "' . html_escape($search) . '".' : 'No process steps yet.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($steps as $s): ?>
                <tr>
                    <td><span class="pill">#<?= (int) $s->step_number ?></span></td>
                    <td><div class="row-title"><?= html_escape($s->title) ?></div></td>
                    <td><div class="row-sub"><?= html_escape(mb_strimwidth($s->description, 0, 60, '…')) ?></div></td>
                    <td><?= (int) $s->sort_order ?></td>
                    <td>
                        <a href="<?= base_url('process-steps/toggle/' . $s->id) ?>" style="text-decoration:none;">
                            <?php if ($s->is_active): ?>
                                <span class="pill pill-active">Active</span>
                            <?php else: ?>
                                <span class="pill pill-inactive">Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('process-steps/edit/' . $s->id) ?>" class="abtn-icon" aria-label="Edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('process-steps/delete/' . $s->id, [
                                'onsubmit' => "return confirm('Delete step \"" . html_escape(addslashes($s->title)) . "\"? This cannot be undone.');"
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

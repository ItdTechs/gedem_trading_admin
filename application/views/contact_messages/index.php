<div class="admin-card">
    <div class="admin-card-head">
        <h2>Contact Messages</h2>
        <form class="admin-search" method="get" action="<?= base_url('messages') ?>">
            <?php if ($status): ?><input type="hidden" name="status" value="<?= html_escape($status) ?>"><?php endif; ?>
            <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-gray);"></i>
            <input type="text" name="q" placeholder="Search name, email, subject…" value="<?= html_escape($search ?? '') ?>">
        </form>
    </div>
<br>
    <div style="display:flex; gap:8px; padding:0 20px 16px; flex-wrap:wrap;">
        <a href="<?= base_url('messages') ?>" class="abtn <?= !$status ? 'abtn-lime' : 'abtn-ghost' ?>">
            All
        </a>
        <a href="<?= base_url('messages?status=new') ?>" class="abtn <?= $status === 'new' ? 'abtn-lime' : 'abtn-ghost' ?>">
            New (<?= (int) $new_count ?>)
        </a>
        <a href="<?= base_url('messages?status=read') ?>" class="abtn <?= $status === 'read' ? 'abtn-lime' : 'abtn-ghost' ?>">
            Read (<?= (int) $read_count ?>)
        </a>
        <a href="<?= base_url('messages?status=closed') ?>" class="abtn <?= $status === 'closed' ? 'abtn-lime' : 'abtn-ghost' ?>">
            Closed (<?= (int) $closed_count ?>)
        </a>
    </div>

    <?php if (empty($messages)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fa-solid fa-inbox"></i></div>
            <p><?= $search ? 'No messages match "' . html_escape($search) . '".' : 'No messages here.' ?></p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $m): ?>
                <tr>
                    <td>
                        <div class="row-title"><?= html_escape($m->first_name . ' ' . $m->last_name) ?></div>
                        <div class="row-sub"><?= html_escape($m->email) ?></div>
                    </td>
                    <td><?= $m->subject ? html_escape($m->subject) : '<span class="row-sub">—</span>' ?></td>
                    <td><div class="row-sub"><?= html_escape(date('M j, Y g:ia', strtotime($m->created_at))) ?></div></td>
                    <td>
                        <?php if ($m->status === 'new'): ?>
                            <span class="pill pill-active">New</span>
                        <?php elseif ($m->status === 'read'): ?>
                            <span class="pill">Read</span>
                        <?php else: ?>
                            <span class="pill pill-inactive">Closed</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= base_url('messages/view/' . $m->id) ?>" class="abtn-icon" aria-label="View" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <?php if (($admin->role ?? '') === 'admin'): ?>
                            <?= form_open('messages/delete/' . $m->id, [
                                'onsubmit' => "return confirm('Delete this message from \"" . html_escape(addslashes($m->first_name . ' ' . $m->last_name)) . "\"? This cannot be undone.');"
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

<div style="margin-bottom:16px;">
    <a href="<?= base_url('messages') ?>" class="abtn abtn-ghost">
        <i class="fa-solid fa-arrow-left"></i> All Messages
    </a>
</div>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= html_escape($message->first_name . ' ' . $message->last_name) ?></h2>
        <?php if (($admin->role ?? '') === 'admin'): ?>
        <?= form_open('messages/delete/' . $message->id, [
            'onsubmit' => "return confirm('Delete this message? This cannot be undone.');"
        ]) ?>
            <button type="submit" class="abtn abtn-ghost"><i class="fa-solid fa-trash"></i> Delete</button>
        <?= form_close() ?>
        <?php endif; ?>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group">
                <label>Email</label>
                <div><a href="mailto:<?= html_escape($message->email) ?>"><?= html_escape($message->email) ?></a></div>
            </div>

            <div class="f-group">
                <label>Phone</label>
                <div><?= $message->phone ? html_escape($message->phone) : '<span class="row-sub">Not provided</span>' ?></div>
            </div>

            <div class="f-group">
                <label>Subject</label>
                <div><?= $message->subject ? html_escape($message->subject) : '<span class="row-sub">No subject</span>' ?></div>
            </div>

            <div class="f-group">
                <label>Received</label>
                <div><?= html_escape(date('M j, Y \a\t g:ia', strtotime($message->created_at))) ?></div>
            </div>

            <div class="f-group full">
                <label>Message</label>
                <div style="white-space:pre-wrap; padding:12px; background:var(--admin-bg, #f7f7f7); border-radius:8px;">
                    <?= html_escape($message->message) ?>
                </div>
            </div>

            <div class="f-group full">
                <label>Status</label>
                <?= form_open('messages/status/' . $message->id, ['style' => 'display:flex; gap:10px; align-items:center;']) ?>
                    <select name="status">
                        <option value="new"    <?= $message->status === 'new' ? 'selected' : '' ?>>New</option>
                        <option value="read"   <?= $message->status === 'read' ? 'selected' : '' ?>>Read</option>
                        <option value="closed" <?= $message->status === 'closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                    <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Update Status</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

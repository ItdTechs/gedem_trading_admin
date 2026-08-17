<?php
$name   = $node ? $node->name : set_value('name');
$sub    = $node ? $node->sub_title : set_value('sub_title');
$active = $node ? $node->is_active : true;
?>

<?= form_open('org-chart/' . $level, ['id' => 'nodeForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2>Edit <?= html_escape($label) ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('org-chart') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('name') ? 'has-error' : '' ?>">
                <label for="name">Name <span class="hint">— e.g. "SOLE SHAREHOLDER" or a person's name</span></label>
                <input type="text" id="name" name="name" value="<?= html_escape($name) ?>" required maxlength="150">
                <?php if (form_error('name')): ?><span class="f-error"><?= form_error('name') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('sub_title') ? 'has-error' : '' ?>">
                <label for="sub_title">Sub Title <span class="hint">— e.g. "Founder &amp; Owner"</span></label>
                <input type="text" id="sub_title" name="sub_title" value="<?= html_escape($sub) ?>" maxlength="150">
                <?php if (form_error('sub_title')): ?><span class="f-error"><?= form_error('sub_title') ?></span><?php endif; ?>
            </div>

            <div class="f-group">
                <label>Visibility</label>
                <label class="check-row">
                    <input type="checkbox" name="is_active" value="1" <?= $active ? 'checked' : '' ?>>
                    Active (shown on the public About page)
                </label>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

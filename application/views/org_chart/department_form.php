<?php
$is_edit = isset($node) && $node;
$name    = $is_edit ? $node->name : set_value('name');
$sub     = $is_edit ? $node->sub_title : set_value('sub_title');
$sort    = $is_edit ? $node->sort_order : set_value('sort_order', 10);
$active  = $is_edit ? $node->is_active : true;
?>

<?= form_open(
    $is_edit ? 'org-chart/departments/edit/' . $node->id : 'org-chart/departments/create',
    ['id' => 'deptForm']
) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Department' : 'New Department' ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('org-chart') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Department</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('name') ? 'has-error' : '' ?>">
                <label for="name">Name <span class="hint">— e.g. "Finance &amp; Administration"</span></label>
                <input type="text" id="name" name="name" value="<?= html_escape($name) ?>" required maxlength="150">
                <?php if (form_error('name')): ?><span class="f-error"><?= form_error('name') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('sub_title') ? 'has-error' : '' ?>">
                <label for="sub_title">Sub Title <span class="hint">— e.g. "Financial Management &amp; HR"</span></label>
                <input type="text" id="sub_title" name="sub_title" value="<?= html_escape($sub) ?>" maxlength="150">
                <?php if (form_error('sub_title')): ?><span class="f-error"><?= form_error('sub_title') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('sort_order') ? 'has-error' : '' ?>">
                <label for="sort_order">Sort Order <span class="hint">— lower shows first</span></label>
                <input type="number" id="sort_order" name="sort_order" value="<?= html_escape($sort) ?>" required>
                <?php if (form_error('sort_order')): ?><span class="f-error"><?= form_error('sort_order') ?></span><?php endif; ?>
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

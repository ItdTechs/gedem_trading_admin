<?php
$is_edit = isset($step);
$number  = $is_edit ? $step->step_number : set_value('step_number', 1);
$title   = $is_edit ? $step->title : set_value('title');
$desc    = $is_edit ? $step->description : set_value('description');
$sort    = $is_edit ? $step->sort_order : set_value('sort_order', 10);
$active  = $is_edit ? $step->is_active : true;
?>

<?= form_open($is_edit ? 'process-steps/edit/' . $step->id : 'process-steps/create', ['id' => 'stepForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Step' : 'New Step' ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('process-steps') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Step</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group <?= form_error('step_number') ? 'has-error' : '' ?>">
                <label for="step_number">Step Number <span class="hint">— the number shown in the numbered circle</span></label>
                <input type="number" id="step_number" name="step_number" value="<?= html_escape($number) ?>" required min="1">
                <?php if (form_error('step_number')): ?><span class="f-error"><?= form_error('step_number') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('sort_order') ? 'has-error' : '' ?>">
                <label for="sort_order">Sort Order <span class="hint">— lower shows first (usually matches Step Number)</span></label>
                <input type="number" id="sort_order" name="sort_order" value="<?= html_escape($sort) ?>" required>
                <?php if (form_error('sort_order')): ?><span class="f-error"><?= form_error('sort_order') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('title') ? 'has-error' : '' ?>">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= html_escape($title) ?>" required maxlength="100">
                <?php if (form_error('title')): ?><span class="f-error"><?= form_error('title') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('description') ? 'has-error' : '' ?>">
                <label for="description">Description</label>
                <textarea id="description" name="description" required maxlength="200"><?= html_escape($desc) ?></textarea>
                <?php if (form_error('description')): ?><span class="f-error"><?= form_error('description') ?></span><?php endif; ?>
            </div>

            <div class="f-group">
                <label>Visibility</label>
                <label class="check-row">
                    <input type="checkbox" name="is_active" value="1" <?= $active ? 'checked' : '' ?>>
                    Active (shown on the public Services page)
                </label>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

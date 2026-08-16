<?php
$is_edit = isset($card);
$title   = $is_edit ? $card->title : set_value('title');
$desc    = $is_edit ? $card->description : set_value('description');
$meta    = $is_edit ? $card->meta_label : set_value('meta_label');
$icon    = $is_edit ? $card->icon : set_value('icon');
$sort    = $is_edit ? $card->sort_order : set_value('sort_order', 10);
$active  = $is_edit ? $card->is_active : true;
?>

<?= form_open(
    $is_edit ? 'content/edit/' . $card->id : 'content/' . $section_key . '/create',
    ['id' => 'cardForm']
) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Card' : 'New Card' ?> <span class="hint">in <?= html_escape($section['label']) ?></span></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('content/' . $section_key) ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Card</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('title') ? 'has-error' : '' ?>">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= html_escape($title) ?>" required maxlength="150">
                <?php if (form_error('title')): ?><span class="f-error"><?= form_error('title') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('description') ? 'has-error' : '' ?>">
                <label for="description">Description <span class="hint">— leave blank if this section only shows a title (e.g. Expertise Tags)</span></label>
                <textarea id="description" name="description" maxlength="500"><?= html_escape($desc) ?></textarea>
                <?php if (form_error('description')): ?><span class="f-error"><?= form_error('description') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('meta_label') ? 'has-error' : '' ?>">
                <label for="meta_label">Meta Label <span class="hint">— optional extra tag, e.g. a milestone year</span></label>
                <input type="text" id="meta_label" name="meta_label" value="<?= html_escape($meta) ?>" maxlength="50">
                <?php if (form_error('meta_label')): ?><span class="f-error"><?= form_error('meta_label') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('icon') ? 'has-error' : '' ?>">
                <label for="icon">Icon <span class="hint">— optional icon class, e.g. fa-solid fa-leaf</span></label>
                <input type="text" id="icon" name="icon" value="<?= html_escape($icon) ?>" maxlength="50">
                <?php if (form_error('icon')): ?><span class="f-error"><?= form_error('icon') ?></span><?php endif; ?>
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
                    Active (shown on the public site)
                </label>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

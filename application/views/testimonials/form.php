<?php
$is_edit = isset($testimonial);
$quote   = $is_edit ? $testimonial->quote : set_value('quote');
$author  = $is_edit ? $testimonial->author_name : set_value('author_name');
$sort    = $is_edit ? $testimonial->sort_order : set_value('sort_order', 10);
$active  = $is_edit ? $testimonial->is_active : true;
?>

<?= form_open($is_edit ? 'testimonials/edit/' . $testimonial->id : 'testimonials/create', ['id' => 'testimonialForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Testimonial' : 'New Testimonial' ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('testimonials') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Testimonial</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('quote') ? 'has-error' : '' ?>">
                <label for="quote">Quote</label>
                <textarea id="quote" name="quote" required><?= html_escape($quote) ?></textarea>
                <?php if (form_error('quote')): ?><span class="f-error"><?= form_error('quote') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('author_name') ? 'has-error' : '' ?>">
                <label for="author_name">Author / Label <span class="hint">— shown under the quote, e.g. "Farmers &amp; Growers"</span></label>
                <input type="text" id="author_name" name="author_name" value="<?= html_escape($author) ?>" required maxlength="150">
                <?php if (form_error('author_name')): ?><span class="f-error"><?= form_error('author_name') ?></span><?php endif; ?>
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
                    Active (shown on the homepage)
                </label>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

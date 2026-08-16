<?php
$is_edit    = isset($slide);
$title      = $is_edit ? $slide->title : set_value('title');
$quote      = $is_edit ? $slide->quote : set_value('quote');
$location   = $is_edit ? $slide->location : set_value('location', '📍 Addis Ababa, Ethiopia');
$image      = $is_edit ? $slide->image : set_value('image');
$sort       = $is_edit ? $slide->sort_order : set_value('sort_order', 10);
$active     = $is_edit ? $slide->is_active : true;
$highlights = $is_edit && !empty($slide->highlights) ? $slide->highlights : [];
if (empty($highlights)) $highlights = [''];
?>

<?= form_open($is_edit ? 'spotlight-slides/edit/' . $slide->id : 'spotlight-slides/create', ['id' => 'slideForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Slide' : 'New Slide' ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('spotlight-slides') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Slide</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('title') ? 'has-error' : '' ?>">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= html_escape($title) ?>" required maxlength="150">
                <?php if (form_error('title')): ?><span class="f-error"><?= form_error('title') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('quote') ? 'has-error' : '' ?>">
                <label for="quote">Quote</label>
                <textarea id="quote" name="quote" required><?= html_escape($quote) ?></textarea>
                <?php if (form_error('quote')): ?><span class="f-error"><?= form_error('quote') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('location') ? 'has-error' : '' ?>">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?= html_escape($location) ?>" maxlength="150">
                <?php if (form_error('location')): ?><span class="f-error"><?= form_error('location') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('image') ? 'has-error' : '' ?>">
                <label for="image">Image Path <span class="hint">— e.g. assets/img/img-5.jpg</span></label>
                <input type="text" id="image" name="image" value="<?= html_escape($image) ?>" required maxlength="255">
                <?php if (form_error('image')): ?><span class="f-error"><?= form_error('image') ?></span><?php endif; ?>
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

            <div class="f-group full">
                <label>Highlights <span class="hint">— short bullet points shown on the slide</span></label>
                <div class="repeat-list" id="highlightList">
                    <?php foreach ($highlights as $h): ?>
                    <div class="repeat-row">
                        <input type="text" name="highlights[]" value="<?= html_escape($h) ?>" placeholder="e.g. Competitive pricing and timely delivery">
                        <button type="button" class="remove-row" aria-label="Remove">×</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="add-row-btn" id="addHighlightRow">+ Add Highlight</button>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<script>
(function () {
    const list = document.getElementById('highlightList');
    const addBtn = document.getElementById('addHighlightRow');

    function wireRemove(row) {
        row.querySelector('.remove-row').addEventListener('click', () => {
            if (list.querySelectorAll('.repeat-row').length > 1) {
                row.remove();
            } else {
                row.querySelector('input').value = '';
            }
        });
    }

    list.querySelectorAll('.repeat-row').forEach(wireRemove);

    addBtn.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'repeat-row';
        row.innerHTML = `
            <input type="text" name="highlights[]" placeholder="e.g. Competitive pricing and timely delivery">
            <button type="button" class="remove-row" aria-label="Remove">×</button>
        `;
        list.appendChild(row);
        wireRemove(row);
        row.querySelector('input').focus();
    });
})();
</script>

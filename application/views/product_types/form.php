<?php
$is_edit = isset($type);
$name    = $is_edit ? $type->name : set_value('name');
$desc    = $is_edit ? $type->description : set_value('description');
$badge   = $is_edit ? $type->badge_text : set_value('badge_text');
$sort    = $is_edit ? $type->sort_order : set_value('sort_order', 10);
$active  = $is_edit ? $type->is_active : true;
$items   = $is_edit && !empty($type->items)
    ? array_map(fn($i) => $i->item_name, $type->items)
    : [];
if (empty($items)) $items = [''];
?>

<?= form_open(
    $is_edit ? 'products/types/edit/' . $type->id : 'products/types/' . $category->id . '/create',
    ['id' => 'typeForm']
) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Product Type' : 'New Product Type' ?> <span class="hint">in <?= html_escape($category->name) ?></span></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('products/types/' . $category->id) ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Type</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('name') ? 'has-error' : '' ?>">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= html_escape($name) ?>" required maxlength="150">
                <?php if (form_error('name')): ?><span class="f-error"><?= form_error('name') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('description') ? 'has-error' : '' ?>">
                <label for="description">Description</label>
                <textarea id="description" name="description" maxlength="500"><?= html_escape($desc) ?></textarea>
                <?php if (form_error('description')): ?><span class="f-error"><?= form_error('description') ?></span><?php endif; ?>
            </div>

            <div class="f-group <?= form_error('badge_text') ? 'has-error' : '' ?>">
                <label for="badge_text">Badge Text <span class="hint">— e.g. "15+ variants", "46% Nitrogen"</span></label>
                <input type="text" id="badge_text" name="badge_text" value="<?= html_escape($badge) ?>" maxlength="100">
                <?php if (form_error('badge_text')): ?><span class="f-error"><?= form_error('badge_text') ?></span><?php endif; ?>
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
                    Active (shown on the public Products page)
                </label>
            </div>

            <div class="f-group full">
                <label>Item List <span class="hint">— optional bullet list shown inside this card (e.g. specific varieties). Leave empty for none.</span></label>
                <div class="repeat-list" id="itemList">
                    <?php foreach ($items as $i): ?>
                    <div class="repeat-row">
                        <input type="text" name="items[]" value="<?= html_escape($i) ?>" placeholder="e.g. Glyphosate 48% SL" maxlength="150">
                        <button type="button" class="remove-row" aria-label="Remove">×</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="add-row-btn" id="addItemRow">+ Add Item</button>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<script>
(function () {
    const list = document.getElementById('itemList');
    const addBtn = document.getElementById('addItemRow');

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
            <input type="text" name="items[]" placeholder="e.g. Glyphosate 48% SL" maxlength="150">
            <button type="button" class="remove-row" aria-label="Remove">×</button>
        `;
        list.appendChild(row);
        wireRemove(row);
        row.querySelector('input').focus();
    });
})();
</script>

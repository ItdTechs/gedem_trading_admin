<?php
$is_edit = isset($category);
$name    = $is_edit ? $category->name : set_value('name');
$slug    = $is_edit ? $category->slug : set_value('slug');
$desc    = $is_edit ? $category->description : set_value('description');
$sort    = $is_edit ? $category->sort_order : set_value('sort_order', 10);
$active  = $is_edit ? $category->is_active : true;
?>

<?= form_open($is_edit ? 'products/edit/' . $category->id : 'products/create', ['id' => 'categoryForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Category' : 'New Category' ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('products') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Category</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('name') ? 'has-error' : '' ?>">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= html_escape($name) ?>" required maxlength="150">
                <?php if (form_error('name')): ?><span class="f-error"><?= form_error('name') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('slug') ? 'has-error' : '' ?>">
                <label for="slug">Slug <span class="hint">— matches the #anchor on the public Products page, e.g. crop-protection</span></label>
                <input type="text" id="slug" name="slug" value="<?= html_escape($slug) ?>" required maxlength="120" pattern="[a-z0-9\-]+" <?= $is_edit ? '' : 'data-autoslug-target' ?>>
                <?php if (form_error('slug')): ?><span class="f-error"><?= form_error('slug') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('description') ? 'has-error' : '' ?>">
                <label for="description">Description <span class="hint">— the intro paragraph shown under the section heading</span></label>
                <textarea id="description" name="description" maxlength="500"><?= html_escape($desc) ?></textarea>
                <?php if (form_error('description')): ?><span class="f-error"><?= form_error('description') ?></span><?php endif; ?>
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
        </div>
    </div>
</div>

<?= form_close() ?>

<?php if (!$is_edit): ?>
<script>
// Slugify the Name field into the Slug field automatically, but only
// until the user edits the slug by hand — then leave it alone.
(function () {
    const nameField = document.getElementById('name');
    const slugField = document.getElementById('slug');
    let slugTouched = false;

    slugField.addEventListener('input', () => { slugTouched = true; });

    nameField.addEventListener('input', () => {
        if (slugTouched) return;
        slugField.value = nameField.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });
})();
</script>
<?php endif; ?>

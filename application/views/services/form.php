<?php
$is_edit  = isset($service);
$title    = $is_edit ? $service->title : set_value('title');
$desc     = $is_edit ? $service->description : set_value('description');
$sort     = $is_edit ? $service->sort_order : set_value('sort_order', 10);
$active   = $is_edit ? $service->is_active : true;
$features = $is_edit && !empty($service->features)
    ? array_map(fn($f) => $f->feature_text, $service->features)
    : [];
if (empty($features)) $features = [''];
?>

<?= form_open($is_edit ? 'services/edit/' . $service->id : 'services/create', ['id' => 'serviceForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2><?= $is_edit ? 'Edit Service' : 'New Service' ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('services') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save Service</button>
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
                <label for="description">Description</label>
                <textarea id="description" name="description" required maxlength="500"><?= html_escape($desc) ?></textarea>
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
                    Active (shown on the public Services page)
                </label>
            </div>

            <div class="f-group full">
                <label>Feature List <span class="hint">— the checkmarked bullets shown under this service</span></label>
                <div class="repeat-list" id="featureList">
                    <?php foreach ($features as $f): ?>
                    <div class="repeat-row">
                        <input type="text" name="features[]" value="<?= html_escape($f) ?>" placeholder="e.g. Nationwide delivery network" maxlength="200">
                        <button type="button" class="remove-row" aria-label="Remove">×</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="add-row-btn" id="addFeatureRow">+ Add Feature</button>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

<script>
(function () {
    const list = document.getElementById('featureList');
    const addBtn = document.getElementById('addFeatureRow');

    function wireRemove(row) {
        row.querySelector('.remove-row').addEventListener('click', () => {
            // Always keep at least one row so the form stays usable.
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
            <input type="text" name="features[]" placeholder="e.g. Nationwide delivery network" maxlength="200">
            <button type="button" class="remove-row" aria-label="Remove">×</button>
        `;
        list.appendChild(row);
        wireRemove(row);
        row.querySelector('input').focus();
    });
})();
</script>

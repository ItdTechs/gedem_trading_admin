<?= form_open('site-settings', ['id' => 'settingsForm']) ?>

<?php foreach ($groups as $group_label => $fields): ?>
<div class="admin-card admin-form-card" style="margin-bottom:20px;">
    <div class="admin-card-head">
        <h2><?= html_escape($group_label) ?></h2>
    </div>
    <div class="admin-form-body">
        <div class="form-grid">
            <?php foreach ($fields as $key => $meta): ?>
            <div class="f-group <?= form_error($key) ? 'has-error' : '' ?>">
                <label for="<?= $key ?>"><?= html_escape($meta['label']) ?></label>
                <input
                    type="text"
                    id="<?= $key ?>"
                    name="<?= $key ?>"
                    value="<?= html_escape(set_value($key, $values[$key] ?? '')) ?>"
                    maxlength="255"
                >
                <?php if (form_error($key)): ?><span class="f-error"><?= form_error($key) ?></span><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endforeach; ?>

<div style="display:flex; justify-content:flex-end; gap:10px;">
    <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save All Settings</button>
</div>

<?= form_close() ?>
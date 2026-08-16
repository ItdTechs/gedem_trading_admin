<?php
$heading = $hero ? $hero->heading : set_value('heading');
$subtext = $hero ? $hero->subtext : set_value('subtext');
$image   = $hero ? $hero->image : set_value('image');
?>

<?= form_open('page-heroes/edit/' . $page_key, ['id' => 'heroForm']) ?>

<div class="admin-card admin-form-card">
    <div class="admin-card-head">
        <h2>Edit Hero — <?= html_escape($page_label) ?></h2>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('page-heroes') ?>" class="abtn abtn-ghost">Cancel</a>
            <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-check"></i> Save</button>
        </div>
    </div>

    <div class="admin-form-body">
        <div class="form-grid">
            <div class="f-group full <?= form_error('heading') ? 'has-error' : '' ?>">
                <label for="heading">Heading</label>
                <input type="text" id="heading" name="heading" value="<?= html_escape($heading) ?>" required maxlength="200">
                <?php if (form_error('heading')): ?><span class="f-error"><?= form_error('heading') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('subtext') ? 'has-error' : '' ?>">
                <label for="subtext">Subtext</label>
                <textarea id="subtext" name="subtext" maxlength="500"><?= html_escape($subtext) ?></textarea>
                <?php if (form_error('subtext')): ?><span class="f-error"><?= form_error('subtext') ?></span><?php endif; ?>
            </div>

            <div class="f-group full <?= form_error('image') ? 'has-error' : '' ?>">
                <label for="image">Image Path <span class="hint">— e.g. assets/img/img-1.jpg</span></label>
                <input type="text" id="image" name="image" value="<?= html_escape($image) ?>" required maxlength="255">
                <?php if (form_error('image')): ?><span class="f-error"><?= form_error('image') ?></span><?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>

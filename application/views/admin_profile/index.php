<?php
$profile = $admin_profile ?? $admin;
?>

<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-head">
        <h2>Profile Details</h2>
    </div>
    <div class="admin-form-body">
        <?= form_open('profile', ['method' => 'post']) ?>
            <div class="form-grid">
                <div class="f-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= html_escape(set_value('name', $profile->name ?? '')) ?>" maxlength="150">
                    <?= form_error('name') ? '<span class="f-error">' . form_error('name') . '</span>' : '' ?>
                </div>

                <div class="f-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= html_escape(set_value('email', $profile->email ?? '')) ?>" maxlength="150">
                    <?= form_error('email') ? '<span class="f-error">' . form_error('email') . '</span>' : '' ?>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="submit" class="abtn abtn-lime"><i class="fa-solid fa-floppy-disk"></i> Save Profile</button>
            </div>
        <?= form_close() ?>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Change Password</h2>
    </div>
    <div class="admin-form-body">
        <?= form_open('profile/change_password', ['method' => 'post']) ?>
            <div class="form-grid">
                <div class="f-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" value="" maxlength="128">
                    <?= form_error('current_password') ? '<span class="f-error">' . form_error('current_password') . '</span>' : '' ?>
                </div>

                <div class="f-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" value="" maxlength="128">
                    <?= form_error('new_password') ? '<span class="f-error">' . form_error('new_password') . '</span>' : '' ?>
                </div>

                <div class="f-group full">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" value="" maxlength="128">
                    <?= form_error('confirm_password') ? '<span class="f-error">' . form_error('confirm_password') . '</span>' : '' ?>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="submit" class="abtn abtn-ghost"><i class="fa-solid fa-key"></i> Update Password</button>
            </div>
        <?= form_close() ?>
    </div>
</div>

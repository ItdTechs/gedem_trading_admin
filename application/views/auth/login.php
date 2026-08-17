<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | Gedem Trading PLC</title>
    <link rel="icon" href="<?= base_url('assets/img/favicon.png')?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Archivo:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="admin-login-body" style="background-image: url('<?php echo base_url('assets/img/bg.jpg'); ?>'); background-size: cover; background-repeat: no-repeat;">
    <div class="login-card">
        <div class="brand">
            <span class="mark">GT</span>
            <span>Gedem Trading PLC</span>
        </div>
        <h1>Admin Login</h1>
        <p class="sub">Sign in to manage site content.</p>

        <?php if (!empty($flash_error)): ?>
            <div class="form-message error">
                <div><?= html_escape($flash_error) ?></div>
                <button type="button" class="dismiss-btn" aria-label="Dismiss">×</button>
            </div>
        <?php endif; ?>

        <?php if (validation_errors()): ?>
            <div class="form-message error">
                <div><?= validation_errors('<p>', '</p>') ?></div>
                <button type="button" class="dismiss-btn" aria-label="Dismiss">×</button>
            </div>
        <?php endif; ?>

        <?= form_open('login') ?>
            <div class="f-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= set_value('email') ?>" required autofocus>
            </div>
            <div class="f-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="abtn abtn-lime">Sign In</button>
        <?= form_close() ?>
    </div>

    <script>
        document.addEventListener('click', event => {
            const dismiss = event.target.closest('.dismiss-btn');
            if (dismiss) dismiss.closest('.form-message')?.remove();
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= isset($page_title) ? html_escape($page_title) . ' | ' : '' ?>Admin | Gedem Trading PLC</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Archivo:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="admin-body">

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="brand">
            <span class="mark">GT</span>
            Gedem Admin
        </div>
        <ul class="admin-nav">
            <li><a href="<?= base_url('dashboard') ?>" class="<?= ($active_nav ?? '') === 'dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>

            <li class="nav-section-label">Content</li>
            <li><a href="<?= base_url('content') ?>" class="<?= ($active_nav ?? '') === 'content_cards' ? 'active' : '' ?>"><i class="fa-solid fa-note-sticky"></i> Content Cards</a></li>
            <li><a href="<?= base_url('products') ?>" class="<?= ($active_nav ?? '') === 'products' ? 'active' : '' ?>"><i class="fa-solid fa-layer-group"></i> Products</a></li>
            <li><a href="<?= base_url('services') ?>" class="<?= ($active_nav ?? '') === 'services' ? 'active' : '' ?>"><i class="fa-solid fa-hand-holding-droplet"></i> Services</a></li>
            <li><a href="<?= base_url('process-steps') ?>" class="<?= ($active_nav ?? '') === 'process_steps' ? 'active' : '' ?>"><i class="fa-solid fa-list-ol"></i> Process Steps</a></li>
            <li><a href="<?= base_url('testimonials') ?>" class="<?= ($active_nav ?? '') === 'testimonials' ? 'active' : '' ?>"><i class="fa-solid fa-quote-left"></i> Testimonials</a></li>
            <li><a href="<?= base_url('spotlight-slides') ?>" class="<?= ($active_nav ?? '') === 'spotlight_slides' ? 'active' : '' ?>"><i class="fa-solid fa-star"></i> Spotlight Slides</a></li>
            <li><a href="<?= base_url('page-heroes') ?>" class="<?= ($active_nav ?? '') === 'page_heroes' ? 'active' : '' ?>"><i class="fa-solid fa-image"></i> Page Heroes</a></li>

            <li class="nav-section-label">Inbox &amp; Settings</li>
            <li><a href="<?= base_url('site-settings') ?>" class="<?= ($active_nav ?? '') === 'site_settings' ? 'active' : '' ?>"><i class="fa-solid fa-gear"></i> Site Settings</a></li>
            <!-- here -->
        </ul>
        <div class="sidebar-foot">Gedem Trading PLC Admin</div>
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <div>
                <h1><?= isset($page_title) ? html_escape($page_title) : 'Dashboard' ?></h1>
                <?php if (!empty($breadcrumb)): ?><div class="breadcrumb"><?= html_escape($breadcrumb) ?></div><?php endif; ?>
            </div>
            <div class="admin-user-menu">
                <div class="who">
                    <div><?= html_escape($admin->name ?? '') ?></div>
                    <div class="role"><?= html_escape($admin->role ?? '') ?></div>
                </div>
                <div class="avatar"><?= strtoupper(substr($admin->name ?? '?', 0, 1)) ?></div>
                <a href="<?= base_url('logout') ?>" class="logout-btn">Log Out</a>
            </div>
        </div>

        <div class="admin-content">
            <?php if (!empty($flash_success)): ?>
                <div class="form-message success">
                    <div><?= html_escape($flash_success) ?></div>
                    <button type="button" class="dismiss-btn" aria-label="Dismiss">×</button>
                </div>
            <?php endif; ?>
            <?php if (!empty($flash_error)): ?>
                <div class="form-message error">
                    <div><?= html_escape($flash_error) ?></div>
                    <button type="button" class="dismiss-btn" aria-label="Dismiss">×</button>
                </div>
            <?php endif; ?>

            <?php $this->load->view($inner_view, $inner_data ?? []); ?>
        </div>
    </div>

    <script>
        document.addEventListener('click', event => {
            const dismiss = event.target.closest('.dismiss-btn');
            if (dismiss) dismiss.closest('.form-message')?.remove();
        });
    </script>
</body>
</html>
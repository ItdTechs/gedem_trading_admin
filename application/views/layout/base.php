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
    <link rel="icon" href="<?= base_url('assets/img/favicon.png')?>">
</head>
<body class="admin-body">

    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    <aside class="admin-sidebar" id="adminSidebar">
        <div class="brand">
            <div class="brand-main">
                <span class="mark">GT</span>
                <span class="brand-text">Gedem Admin</span>
            </div>
            <button type="button" class="sidebar-collapse-btn" id="sidebarCollapse" aria-label="Collapse sidebar">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
        </div>
        <ul class="admin-nav">
            <li><a href="<?= base_url('dashboard') ?>" class="<?= ($active_nav ?? '') === 'dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-gauge"></i> <span class="nav-label">Dashboard</span></a></li>

            <li class="nav-section-label">Content</li>
            <li><a href="<?= base_url('content') ?>" class="<?= ($active_nav ?? '') === 'content_cards' ? 'active' : '' ?>"><i class="fa-solid fa-note-sticky"></i> <span class="nav-label">Content Cards</span></a></li>
            <li><a href="<?= base_url('products') ?>" class="<?= ($active_nav ?? '') === 'products' ? 'active' : '' ?>"><i class="fa-solid fa-layer-group"></i> <span class="nav-label">Products</span></a></li>
            <li><a href="<?= base_url('services') ?>" class="<?= ($active_nav ?? '') === 'services' ? 'active' : '' ?>"><i class="fa-solid fa-hand-holding-droplet"></i> <span class="nav-label">Services</span></a></li>
            <li><a href="<?= base_url('process-steps') ?>" class="<?= ($active_nav ?? '') === 'process_steps' ? 'active' : '' ?>"><i class="fa-solid fa-list-ol"></i> <span class="nav-label">Process Steps</span></a></li>
            <li><a href="<?= base_url('testimonials') ?>" class="<?= ($active_nav ?? '') === 'testimonials' ? 'active' : '' ?>"><i class="fa-solid fa-quote-left"></i> <span class="nav-label">Testimonials</span></a></li>
            <li><a href="<?= base_url('spotlight-slides') ?>" class="<?= ($active_nav ?? '') === 'spotlight_slides' ? 'active' : '' ?>"><i class="fa-solid fa-star"></i> <span class="nav-label">Spotlight Slides</span></a></li>
            <li><a href="<?= base_url('page-heroes') ?>" class="<?= ($active_nav ?? '') === 'page_heroes' ? 'active' : '' ?>"><i class="fa-solid fa-image"></i> <span class="nav-label">Page Heroes</span></a></li>
            <li><a href="<?= base_url('org-chart') ?>" class="<?= ($active_nav ?? '') === 'org_chart' ? 'active' : '' ?>"><i class="fa-solid fa-sitemap"></i> <span class="nav-label">Org Chart</span></a></li>

            <li class="nav-section-label">Inbox &amp; Settings</li>
            <li><a href="<?= base_url('messages') ?>" class="<?= ($active_nav ?? '') === 'contact_messages' ? 'active' : '' ?>"><i class="fa-solid fa-inbox"></i> <span class="nav-label">Messages</span></a></li>
            <li><a href="<?= base_url('profile') ?>" class="<?= ($active_nav ?? '') === 'profile' ? 'active' : '' ?>"><i class="fa-solid fa-user"></i> <span class="nav-label">Profile</span></a></li>
            <li><a href="<?= base_url('site-settings') ?>" class="<?= ($active_nav ?? '') === 'site_settings' ? 'active' : '' ?>"><i class="fa-solid fa-gear"></i> <span class="nav-label">Site Settings</span></a></li>
        </ul>
        <div class="sidebar-foot">Gedem Trading PLC Admin</div>
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <div style="display:flex; align-items:center;">
                <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1><?= isset($page_title) ? html_escape($page_title) : 'Dashboard' ?></h1>
                    <?php if (!empty($breadcrumb)): ?><div class="breadcrumb"><?= html_escape($breadcrumb) ?></div><?php endif; ?>
                </div>
            </div>
            <div class="admin-user-menu">
                <div class="who">
                    <div><?= html_escape($admin->name ?? '') ?></div>
                    <div class="role"><?= html_escape($admin->role ?? '') ?></div>
                </div>
                
                <a href="<?= base_url('profile') ?>" class=""><div class="avatar"><?= strtoupper(substr($admin->name ?? '?', 0, 1)) ?></div></a>
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

    <script>
        (function () {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');
            const collapseBtn = document.getElementById('sidebarCollapse');

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('visible');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('visible');
            }

            function syncCollapseButton() {
                if (!collapseBtn) return;
                const collapsed = sidebar.classList.contains('collapsed');
                const icon = collapsed ? 'fa-chevron-right' : 'fa-chevron-left';
                collapseBtn.setAttribute('aria-label', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
                collapseBtn.innerHTML = '<i class="fa-solid ' + icon + '"></i>';
            }

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });

            collapseBtn.addEventListener('click', () => {
                if (window.innerWidth <= 900) return;
                const collapsed = sidebar.classList.toggle('collapsed');
                document.body.classList.toggle('sidebar-collapsed', collapsed);
                syncCollapseButton();
            });

            overlay.addEventListener('click', closeSidebar);

            sidebar.querySelectorAll('.admin-nav a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 900) closeSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 900) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('visible');
                    document.body.classList.toggle('sidebar-collapsed', sidebar.classList.contains('collapsed'));
                    syncCollapseButton();
                } else {
                    sidebar.classList.remove('collapsed');
                    document.body.classList.remove('sidebar-collapsed');
                    syncCollapseButton();
                }
            });

            syncCollapseButton();
        })();
    </script>
</body>
</html>
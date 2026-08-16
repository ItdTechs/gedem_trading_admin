<div class="admin-card">
    <div class="admin-card-head">
        <h2>Welcome, <?= html_escape($admin->name ?? 'Admin') ?>!</h2>
    </div>

    <div class="admin-form-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 0;">
            <div style="padding: 20px; background: #f5f5f5; border-radius: 8px; border-left: 4px solid #4CAF50;">
                <div style="font-size: 28px; font-weight: bold; color: #333;"><?= isset($total_services) ? $total_services : '0' ?></div>
                <div style="font-size: 12px; color: #999; margin-top: 5px;">Total Services</div>
            </div>
            <div style="padding: 20px; background: #f5f5f5; border-radius: 8px; border-left: 4px solid #2196F3;">
                <div style="font-size: 28px; font-weight: bold; color: #333;">Your Role</div>
                <div style="font-size: 12px; color: #999; margin-top: 5px;"><?= ucfirst(html_escape($admin->role ?? 'guest')) ?></div>
            </div>
            <div style="padding: 20px; background: #f5f5f5; border-radius: 8px; border-left: 4px solid #FF9800;">
                <div style="font-size: 28px; font-weight: bold; color: #333;">Last Login</div>
                <div style="font-size: 12px; color: #999; margin-top: 5px;"><?= $admin->last_login_at ? date('M d, Y', strtotime($admin->last_login_at)) : 'Never' ?></div>
            </div>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #fffbf0; border-left: 4px solid #f39c12; border-radius: 4px;">
            <strong style="display: block; margin-bottom: 10px;">Getting Started:</strong>
            <ul style="margin: 0; padding-left: 20px; font-size: 14px;">
                <li><a href="<?= base_url('services') ?>" style="color: #f39c12; text-decoration: none;">Manage Services</a> - Add, edit, and organize services</li>
                <li style="margin-top: 5px;"><a href="<?= base_url('dashboard') ?>" style="color: #f39c12; text-decoration: none;">View Dashboard</a> - See overview and statistics</li>
            </ul>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #f0f7ff; border-left: 4px solid #2196F3; border-radius: 4px;">
            <strong style="display: block; margin-bottom: 10px;">Quick Tips:</strong>
            <ul style="margin: 0; padding-left: 20px; font-size: 14px;">
                <li>Use search to find services quickly</li>
                <li style="margin-top: 5px;">Toggle service status to show/hide from public site</li>
                <li style="margin-top: 5px;"><?php if ($admin->role === 'admin'): ?>As an admin, you can delete services and manage all content<?php else: ?>As an editor, you can create and edit services<?php endif; ?></li>
            </ul>
        </div>
    </div>
</div>

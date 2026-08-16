<div class="admin-card">
    <div class="admin-card-head">
        <h2>Content Card Sections</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Section</th>
                <th>Where it's shown</th>
                <th>Cards</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sections as $s): ?>
            <tr>
                <td><div class="row-title"><?= html_escape($s['label']) ?></div></td>
                <td><div class="row-sub"><?= html_escape($s['hint']) ?></div></td>
                <td><?= (int) $s['count'] ?> card<?= $s['count'] == 1 ? '' : 's' ?></td>
                <td style="text-align:right;">
                    <a href="<?= base_url('content/' . $s['key']) ?>" class="abtn abtn-ghost">
                        Manage <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

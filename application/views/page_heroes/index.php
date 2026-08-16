<div class="admin-card">
    <div class="admin-card-head">
        <h2>Page Heroes</h2>
    </div>
    <div class="row-sub" style="padding:0 20px 16px;">
        The heading/subtext/image block shown at the top of each public page. Every page listed here already exists — there's nothing to add or remove, just edit.
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Page</th>
                <th>Heading</th>
                <th>Image</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><div class="row-title"><?= html_escape($r['label']) ?></div></td>
                <td>
                    <?php if ($r['hero']): ?>
                        <?= html_escape($r['hero']->heading) ?>
                    <?php else: ?>
                        <span class="pill pill-inactive">Not set up yet</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($r['hero']): ?>
                        <code><?= html_escape($r['hero']->image) ?></code>
                    <?php else: ?>
                        <span class="row-sub">—</span>
                    <?php endif; ?>
                </td>
                <td style="text-align:right;">
                    <a href="<?= base_url('page-heroes/edit/' . $r['key']) ?>" class="abtn abtn-ghost">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

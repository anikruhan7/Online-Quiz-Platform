<h2>Assigned Courses</h2>
<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>No assigned courses.</p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><?= htmlspecialchars($c['title']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
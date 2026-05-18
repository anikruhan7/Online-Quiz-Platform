<h2>All Courses</h2>
<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>No courses found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><strong><?= htmlspecialchars($c['title']) ?></strong> – Instructor ID: <?= $c['instructor_id'] ?> (<?= $c['status'] ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
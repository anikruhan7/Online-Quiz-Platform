<h2>My Courses</h2>
<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>No courses yet. <a href="index.php?url=instructor/create-course">Create one</a></p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><strong><?= htmlspecialchars($c['title']) ?></strong> – <?= htmlspecialchars($c['description']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
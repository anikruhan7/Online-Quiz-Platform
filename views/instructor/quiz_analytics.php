<h2>Quiz Analytics</h2>
<p>Select a course to view quiz statistics.</p>
<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>No courses available.</p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><a href="index.php?url=instructor/quiz-analytics?course_id=<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
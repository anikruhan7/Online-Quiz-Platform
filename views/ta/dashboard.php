<h2>TA Dashboard</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</p>
<h3>Assigned Courses</h3>
<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>You are not assigned to any course yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><strong><?= htmlspecialchars($c['title']) ?></strong></li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?url=ta/doubt-sessions" class="btn">Manage Doubt Sessions</a>
<?php endif; ?>
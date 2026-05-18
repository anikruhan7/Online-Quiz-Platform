<h2>Instructor Dashboard</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</p>
<h3>Your Courses</h3>
<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>You haven't created any courses yet.</p>
    <a href="index.php?url=instructor/create-course" class="btn">Create New Course</a>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><strong><?= htmlspecialchars($c['title']) ?></strong> – <?= htmlspecialchars($c['description']) ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?url=instructor/create-course" class="btn">+ Add Another Course</a>
<?php endif; ?>
<h2>Browse Courses</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="url" value="student/courses">
    <input type="text" name="search" placeholder="Search by title or instructor"
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <select name="subject_id">
        <option value="">All Subjects</option>
        <?php foreach ($subjects ?? [] as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= (isset($_GET['subject_id']) && $_GET['subject_id'] == $s['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<?php if (empty($courses)): ?>
    <p>No courses found.</p>
<?php else: ?>
    <?php foreach ($courses as $c): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3><?= htmlspecialchars($c['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($c['description'] ?? '')) ?></p>
            <p>Subject: <?= htmlspecialchars($c['subject_name'] ?? '') ?>
                | Instructor: <?= htmlspecialchars($c['instructor_name'] ?? '') ?>
                | Enrolled: <?= $c['enrolled_count'] ?? 0 ?> / <?= $c['max_students'] ?? 100 ?>
            </p>
            <form method="POST" action="index.php?url=student/enroll">
                <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                <button type="submit">Enroll</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
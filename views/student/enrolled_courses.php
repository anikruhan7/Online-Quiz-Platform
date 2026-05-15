<h2>My Enrolled Courses</h2>
<?php if (empty($courses)): ?>
    <p>You are not enrolled in any course. <a href="index.php?url=student/courses">Browse courses</a></p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li>
                <a href="index.php?url=student/course/<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></a>
                – <?= htmlspecialchars($c['instructor_name'] ?? '') ?>
                <form method="POST" action="index.php?url=student/drop-course" style="display:inline;">
                    <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                    <button type="submit" onclick="return confirm('Drop this course?')">Drop</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
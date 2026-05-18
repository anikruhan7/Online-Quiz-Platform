<h2>Welcome back, <?= htmlspecialchars($_SESSION['name']) ?>! 🎉</h2>
<p>Track your learning progress and upcoming quizzes.</p>

<h3>Your Enrolled Courses</h3>
<?php if (empty($courses)): ?>
    <p>You are not enrolled in any course yet.</p>
    <a href="index.php?url=student/courses" class="btn">Browse Courses</a>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $c): ?>
            <li><a href="index.php?url=student/course/<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($upcomingQuiz)): ?>
    <h3>Upcoming Quiz</h3>
    <p><strong><?= htmlspecialchars($upcomingQuiz['title']) ?></strong> (<?= htmlspecialchars($upcomingQuiz['course_title']) ?>)</p>
    <a href="index.php?url=student/quiz/take/<?= $upcomingQuiz['id'] ?>" class="btn">Take Quiz</a>
<?php endif; ?>
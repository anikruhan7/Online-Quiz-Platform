<h2>Quiz Result</h2>

<?php if (empty($attempt) || empty($quiz)): ?>
    <p>Result data not available.</p>
    <a href="index.php?url=student/dashboard">Back to Dashboard</a>
<?php else: ?>
    <p><strong>Quiz:</strong> <?= htmlspecialchars($quiz['title']) ?></p>
    <p><strong>Your Score:</strong> <?= $attempt['score'] ?> / <?= $quiz['total_marks'] ?></p>
    <p><strong>Pass Mark:</strong> <?= $quiz['pass_mark'] ?></p>
    <p><strong>Result:</strong> <?= ($attempt['score'] >= $quiz['pass_mark']) ? 'Passed' : 'Failed' ?></p>
    <p><strong>Completed At:</strong> <?= $attempt['completed_at'] ?></p>

    <p>
        <a href="index.php?url=student/attempts">View All Attempts</a> |
        <a href="index.php?url=student/dashboard">Dashboard</a>
    </p>
<?php endif; ?>
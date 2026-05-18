<h2>Attempt History</h2>
<?php if (empty($attempts)): ?><p>No quiz attempts yet.</p><?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>Course</th>
            <th>Quiz</th>
            <th>Score</th>
            <th>Pass Mark</th>
            <th>Result</th>
            <th>Completed At</th>
        </tr>
        <?php foreach ($attempts as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['course_title']) ?></td>
                <td><?= htmlspecialchars($a['quiz_title']) ?></td>
                <td><?= $a['score'] ?></td>
                <td><?= $a['pass_mark'] ?></td>
                <td><?= ($a['score'] >= $a['pass_mark']) ? 'Pass' : 'Fail' ?></td>
                <td><?= $a['completed_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table><?php endif; ?>
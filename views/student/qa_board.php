<h2>Q&A Board</h2>

<h3>Post a Question</h3>
<form method="POST" action="index.php?url=student/qa/post">
    <input type="hidden" name="course_id" value="<?= $course_id ?? 0 ?>">
    <input type="text" name="title" placeholder="Question title" required><br>
    <textarea name="body" placeholder="Your question..." required></textarea><br>
    <button type="submit">Post Question</button>
</form>

<h3>Existing Questions</h3>
<?php if (empty($questions)): ?>
    <p>No questions yet. Be the first to ask!</p>
<?php else: ?>
    <?php foreach ($questions as $q): ?>
        <div style="border:1px solid #ccc; margin:15px 0; padding:15px;">
            <strong><?= htmlspecialchars($q['title'] ?? '') ?></strong>
            – by <?= htmlspecialchars($q['student_name'] ?? 'Unknown') ?>
            <?php if (!empty($q['is_resolved'])): ?>
                <span style="color:green;">[Resolved]</span>
            <?php endif; ?>
            <?php if (($_SESSION['user_id'] ?? 0) == ($q['student_id'] ?? 0) && empty($q['is_resolved'])): ?>
                <form method="POST" action="index.php?url=student/qa/resolve" style="display:inline;">
                    <input type="hidden" name="qid" value="<?= $q['id'] ?? 0 ?>">
                    <button type="submit">Mark Resolved</button>
                </form>
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($q['body'] ?? '')) ?></p>

            <h4>Answers (<?= $q['answer_count'] ?? 0 ?>)</h4>
            <?php
            // Safely fetch answers only if the model and method exist
            $answers = [];
            if (class_exists('QaAnswer') && method_exists($q, 'getId')) {
                // This block is problematic because $q is an array, not an object.
                // Better to fetch answers in the controller and pass them.
                // For now, we'll skip dynamic fetching and just show a placeholder.
            }
            // Instead, we can assume the answers are already passed from controller?
            // Usually you'd pass $questions with answers pre-fetched.
            // But if you didn't, we must call the model correctly.
            if (class_exists('QaAnswer')) {
                $answerModel = new QaAnswer();
                if (method_exists($answerModel, 'getForQuestion')) {
                    $answers = $answerModel->getForQuestion($q['id'] ?? 0);
                }
            }
            ?>
            <?php if (empty($answers)): ?>
                <p>No answers yet.</p>
            <?php else: ?>
                <?php foreach ($answers as $a): ?>
                    <div style="margin-left:20px; border-left:2px solid #eee; padding-left:10px; margin-top:10px;">
                        <strong><?= htmlspecialchars($a['author_name'] ?? 'Unknown') ?></strong>
                        <?= !empty($a['is_endorsed']) ? '⭐' : '' ?>
                        <br>
                        <?= nl2br(htmlspecialchars($a['body'] ?? '')) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
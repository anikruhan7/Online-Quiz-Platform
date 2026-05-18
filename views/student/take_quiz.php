<?php if (!isset($quiz) || empty($quiz)): ?>
    <p>Error: Quiz data not found.</p>
<?php else: ?>
<h2><?= htmlspecialchars($quiz['title']) ?></h2>
<p>Time limit: <?= $quiz['time_limit_minutes'] ?> minutes</p>
<p>Total marks: <?= $quiz['total_marks'] ?> | Pass mark: <?= $quiz['pass_mark'] ?></p>

<form id="quizForm">
    <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
    <?php foreach ($quiz['questions'] as $index => $q): ?>
        <fieldset style="margin-bottom:20px;">
            <legend><?= ($index + 1) . '. ' . htmlspecialchars($q['question_text']) . ' (' . $q['marks'] . ' marks)' ?></legend>
            <?php foreach ($q['options'] as $opt): ?>
                <label style="display:block; margin:5px 0;">
                    <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $opt['id'] ?>" required>
                    <?= htmlspecialchars($opt['option_text']) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endforeach; ?>
    <button type="submit">Submit Quiz</button>
</form>

<div id="timer" style="position:fixed; top:10px; right:20px; background:#333; color:white; padding:8px;"></div>

<script>
    let timeLeft = <?= $quiz['time_limit_minutes'] * 60 ?>;
    const timerDiv = document.getElementById('timer');
    const timerInterval = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerDiv.innerText = `Time left: ${minutes}:${seconds < 10 ? '0'+seconds : seconds}`;
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('quizForm').dispatchEvent(new Event('submit'));
        }
        timeLeft--;
    }, 1000);

    document.getElementById('quizForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        try {
            const response = await fetch('index.php?url=student/quiz/submit', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                const userChoice = confirm(
                    `✅ Quiz submitted successfully!\nYour score: ${result.score} / ${result.total}\n\nClick OK to take another quiz\nClick Cancel to go to Dashboard`
                );
                if (userChoice) {
                    window.location.href = 'index.php?url=student/courses';
                } else {
                    window.location.href = 'index.php?url=student/dashboard';
                }
            } else {
                alert('❌ Error: ' + (result.error || 'Unknown error'));
            }
        } catch (err) {
            alert('❌ Network or server error. Please try again.');
            console.error(err);
        }
    });
</script>
<?php endif; ?>
<h2>Leaderboard</h2>

<select id="quizSelect">
    <option value="">-- Select a quiz --</option>
    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
            <?php if (!empty($course['quizzes'])): ?>
                <optgroup label="<?= htmlspecialchars($course['title']) ?>">
                    <?php foreach ($course['quizzes'] as $quiz): ?>
                        <option value="<?= $quiz['id'] ?>">
                            <?= htmlspecialchars($quiz['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <option disabled>No courses with quizzes available</option>
    <?php endif; ?>
</select>

<div id="leaderboardData" style="margin-top: 20px;">
    <p>Select a quiz to see the leaderboard.</p>
</div>

<script>
    document.getElementById('quizSelect').addEventListener('change', function() {
        let quizId = this.value;
        let container = document.getElementById('leaderboardData');

        if (!quizId) {
            container.innerHTML = '<p>Select a quiz to see the leaderboard.</p>';
            return;
        }

        container.innerHTML = '<p>Loading...</p>';

        fetch('index.php?url=api/leaderboard&quiz_id=' + quizId)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    container.innerHTML = '<p>No attempts yet for this quiz.</p>';
                    return;
                }
                let html = '<table border="1" cellpadding="8" style="border-collapse:collapse;">';
                html += '<tr><th>Rank</th><th>Student</th><th>Score</th></tr>';
                data.forEach((student, index) => {
                    html += `<tr>
                            <td>${index + 1}</td>
                            <td>${escapeHtml(student.name)}</td>
                            <td>${student.score}</td>
                         </tr>`;
                });
                html += '</table>';
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching leaderboard:', error);
                container.innerHTML = '<p style="color:red;">Error loading leaderboard. Please try again.</p>';
            });
    });

    // Helper function to prevent XSS
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
</script>
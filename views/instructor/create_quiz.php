<h2>Create New Quiz</h2>
<?php $courses = $courses ?? []; ?>
<form method="POST" action="index.php?url=instructor/store-quiz">
    <div class="input-group">
        <label>Course</label>
        <select name="course_id" required>
            <?php foreach ($courses as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="input-group">
        <label>Quiz Title</label>
        <input type="text" name="title" required>
    </div>
    <div class="input-group">
        <label>Description</label>
        <textarea name="description"></textarea>
    </div>
    <div class="input-group">
        <label>Time Limit (minutes)</label>
        <input type="number" name="time_limit" value="30" required>
    </div>
    <div class="input-group">
        <label>Total Marks</label>
        <input type="number" name="total_marks" value="20" required>
    </div>
    <div class="input-group">
        <label>Pass Mark</label>
        <input type="number" name="pass_mark" value="10" required>
    </div>
    <div class="input-group">
        <label>Quiz Type</label>
        <select name="quiz_type">
            <option value="graded">Graded</option>
            <option value="practice">Practice</option>
        </select>
    </div>
    <button type="submit" class="btn">Create Quiz</button>
</form>
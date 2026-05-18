<h2>Doubt Sessions</h2>

<h3>Create New Session</h3>
<form method="POST" action="index.php?url=ta/create-doubt-session">
    <div class="input-group">
        <label>Course</label>
        <select name="course_id" required>
            <option value="">Select a course</option>
            <?php foreach ((new Course())->getCoursesForTA($_SESSION['user_id']) as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="input-group">
        <label>Title</label>
        <input type="text" name="title" required>
    </div>
    <div class="input-group">
        <label>Date & Time</label>
        <input type="datetime-local" name="scheduled_at" required>
    </div>
    <div class="input-group">
        <label>Duration (minutes)</label>
        <input type="number" name="duration" value="60">
    </div>
    <div class="input-group">
        <label>Location / Meeting Link</label>
        <input type="text" name="location">
    </div>
    <div class="input-group">
        <label>Max Attendees</label>
        <input type="number" name="max_attendees" value="10">
    </div>
    <button type="submit" class="btn">Create Session</button>
</form>

<h3>Existing Sessions</h3>
<?php $sessions = $sessions ?? []; ?>
<?php if (empty($sessions)): ?>
    <p>No doubt sessions created yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($sessions as $s): ?>
            <li><strong><?= htmlspecialchars($s['title']) ?></strong> – <?= $s['scheduled_at'] ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
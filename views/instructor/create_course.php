<h2>Create New Course</h2>
<?php $subjects = $subjects ?? []; ?>
<form method="POST" action="index.php?url=instructor/store-course">
    <div class="input-group">
        <label>Title</label>
        <input type="text" name="title" required>
    </div>
    <div class="input-group">
        <label>Description</label>
        <textarea name="description" required></textarea>
    </div>
    <div class="input-group">
        <label>Subject</label>
        <select name="subject_id">
            <?php foreach ($subjects as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="input-group">
        <label>Enrollment Type</label>
        <select name="enrollment_type">
            <option value="open">Open (direct enrollment)</option>
            <option value="approval">Approval Required</option>
        </select>
    </div>
    <div class="input-group">
        <label>Max Students</label>
        <input type="number" name="max_students" value="100">
    </div>
    <button type="submit" class="btn">Create Course</button>
</form>
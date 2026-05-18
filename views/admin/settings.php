<h2>Platform Settings</h2>

<?php $settings = $settings ?? []; ?>
<form method="POST" action="index.php?url=admin/update-settings">
    <label>Max Quiz Duration (minutes)</label>
    <input type="number" name="max_quiz_duration" value="<?php echo $settings['max_quiz_duration'] ?? 60; ?>">
    <br><br>
    <label>Default Max Students per Course</label>
    <input type="number" name="default_max_students" value="<?php echo $settings['default_max_students'] ?? 100; ?>">
    <br><br>
    <button type="submit">Save Settings</button>
</form>
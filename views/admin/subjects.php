<h2>Manage Subjects</h2>

<form method="POST" action="index.php?url=admin/add-subject">
    <input type="text" name="name" placeholder="Subject Name" required>
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Add Subject</button>
</form>

<hr>

<?php $subjects = $subjects ?? []; ?>
<?php if (empty($subjects)): ?>
    <p>No subjects added yet.</p>
<?php else: ?>
    <?php foreach ($subjects as $subject): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
            <strong><?php echo htmlspecialchars($subject['name']); ?></strong><br>
            <?php echo htmlspecialchars($subject['description']); ?>
            <form method="POST" action="index.php?url=admin/edit-subject" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $subject['id']; ?>">
                <input type="text" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>">
                <input type="text" name="description" value="<?php echo htmlspecialchars($subject['description']); ?>">
                <button type="submit">Edit</button>
            </form>
            <form method="POST" action="index.php?url=admin/delete-subject" style="display:inline;" onsubmit="return confirm('Delete subject?');">
                <input type="hidden" name="id" value="<?php echo $subject['id']; ?>">
                <button type="submit">Delete</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
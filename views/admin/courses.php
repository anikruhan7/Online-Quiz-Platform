<h2>Courses</h2>

<form method="GET" action="index.php?url=admin/courses">
    <select name="subject_id">
        <option value="">All Subjects</option>
        <?php foreach (($subjects ?? []) as $subject): ?>
            <option value="<?php echo $subject['id']; ?>" <?php echo ($selected_subject ?? '') == $subject['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($subject['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="instructor_id">
        <option value="">All Instructors</option>
        <?php foreach (($instructors ?? []) as $instructor): ?>
            <option value="<?php echo $instructor['id']; ?>" <?php echo ($selected_instructor ?? '') == $instructor['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($instructor['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<?php $courses = $courses ?? []; ?>
<?php if (empty($courses)): ?>
    <p>No courses found.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Instructor</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Enrollment</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo $course['id']; ?></td>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td><?php echo htmlspecialchars($course['instructor_name'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($course['subject_name'] ?? ''); ?></td>
                    <td><?php echo $course['status']; ?></td>
                    <td><?php echo $course['enrollment_type']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
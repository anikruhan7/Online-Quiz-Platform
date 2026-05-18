<h2>Quizzes</h2>

<form method="GET" action="index.php?url=admin/quizzes">
    <select name="course_id">
        <option value="">All Courses</option>
        <?php foreach (($courses ?? []) as $course): ?>
            <option value="<?php echo $course['id']; ?>" <?php echo ($selected_course ?? '') == $course['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($course['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="status">
        <option value="">All Status</option>
        <option value="draft" <?php echo ($selected_status ?? '') == 'draft' ? 'selected' : ''; ?>>Draft</option>
        <option value="published" <?php echo ($selected_status ?? '') == 'published' ? 'selected' : ''; ?>>Published</option>
    </select>
    <select name="type">
        <option value="">All Types</option>
        <option value="graded" <?php echo ($selected_type ?? '') == 'graded' ? 'selected' : ''; ?>>Graded</option>
        <option value="practice" <?php echo ($selected_type ?? '') == 'practice' ? 'selected' : ''; ?>>Practice</option>
    </select>
    <button type="submit">Filter</button>
</form>

<?php $quizzes = $quizzes ?? []; ?>
<?php if (empty($quizzes)): ?>
    <p>No quizzes found.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Course</th>
                <th>Created By</th>
                <th>Type</th>
                <th>Status</th>
                <th>Attempts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quizzes as $quiz): ?>
                <tr>
                    <td><?php echo $quiz['id']; ?></td>
                    <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['course_title'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($quiz['created_by_name'] ?? ''); ?></td>
                    <td><?php echo $quiz['quiz_type']; ?></td>
                    <td><?php echo $quiz['status']; ?></td>
                    <td><?php echo $quiz['attempt_count'] ?? 0; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
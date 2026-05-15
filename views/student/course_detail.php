<h2><?= htmlspecialchars($course['title'] ?? '') ?></h2>
<p><strong>Instructor:</strong> <?= htmlspecialchars($course['instructor_name'] ?? '') ?></p>
<p><strong>Description:</strong> <?= nl2br(htmlspecialchars($course['description'] ?? '')) ?></p>
<h3>Teaching Assistants</h3>
<?php if (empty($tas)): ?><p>No TAs assigned.</p><?php else: ?><ul><?php foreach ($tas as $ta): ?><li><?= htmlspecialchars($ta['name']) ?></li><?php endforeach; ?></ul><?php endif; ?>
<h3>Announcements</h3>
<?php if (empty($announcements)): ?><p>No announcements.</p><?php else: ?><?php foreach ($announcements as $a): ?><div><strong><?= htmlspecialchars($a['title']) ?></strong> – <?= htmlspecialchars($a['author_name'] ?? '') ?><br><?= nl2br(htmlspecialchars($a['body'] ?? '')) ?></div>
    <hr><?php endforeach; ?><?php endif; ?>
    <h3>Materials</h3>
    <?php if (empty($materials)): ?><p>No materials uploaded.</p><?php else: ?><ul><?php foreach ($materials as $m): ?><li><a href="<?= htmlspecialchars($m['file_path']) ?>" target="_blank"><?= htmlspecialchars($m['title']) ?></a> (<?= $m['material_type'] ?? 'document' ?>)</li><?php endforeach; ?></ul><?php endif; ?>
    <h3>Quizzes</h3>
    <?php if (empty($quizzes)): ?><p>No published quizzes yet.</p><?php else: ?><ul><?php foreach ($quizzes as $q): ?><li><a href="index.php?url=student/quiz/take/<?= $q['id'] ?>"><?= htmlspecialchars($q['title']) ?></a> (<?= $q['quiz_type'] ?? 'graded' ?>, <?= $q['time_limit_minutes'] ?? 30 ?> min)</li><?php endforeach; ?></ul><?php endif; ?>
    <p><a href="index.php?url=student/qa/<?= $course['id'] ?? 0 ?>">Go to Q&A Board</a></p>
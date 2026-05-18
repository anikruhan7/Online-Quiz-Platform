<h2>Doubt Sessions</h2>
<h3>Upcoming Sessions</h3>
<?php if (empty($sessions)): ?><p>No upcoming doubt sessions.</p><?php else: ?>
    <ul><?php foreach ($sessions as $s): ?>
            <li>
                <strong><?= htmlspecialchars($s['title']) ?></strong> – <?= htmlspecialchars($s['course_title'] ?? '') ?> (TA: <?= htmlspecialchars($s['ta_name'] ?? '') ?>)<br>
                When: <?= $s['scheduled_at'] ?> | Duration: <?= $s['duration_minutes'] ?> min | Location: <?= htmlspecialchars($s['location_or_link'] ?? '') ?>
                <form method="POST" action="index.php?url=student/doubt-book">
                    <input type="hidden" name="session_id" value="<?= $s['id'] ?>">
                    <button type="submit">Book Slot</button>
                </form>
            </li><?php endforeach; ?>
    </ul><?php endif; ?>
<h3>My Bookings</h3>
<?php if (empty($bookings)): ?><p>You have not booked any sessions.</p><?php else: ?>
    <ul><?php foreach ($bookings as $b): ?><li><?= htmlspecialchars($b['title']) ?> (<?= htmlspecialchars($b['course_title'] ?? '') ?>) – <?= $b['scheduled_at'] ?></li><?php endforeach; ?></ul><?php endif; ?>
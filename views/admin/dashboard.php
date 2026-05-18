<h2>Admin Dashboard</h2>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value"><?= $totalUsers ?? 0 ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-value"><?= $totalCourses ?? 0 ?></div>
        <div class="stat-label">Total Courses</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📝</div>
        <div class="stat-value"><?= $totalAttempts ?? 0 ?></div>
        <div class="stat-label">Quiz Attempts</div>
    </div>
</div>
<a href="index.php?url=admin/manage-users" class="btn">Manage Users</a>
<a href="index.php?url=admin/courses" class="btn">Manage Courses</a>
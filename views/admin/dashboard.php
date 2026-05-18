<!DOCTYPE html>
<html>

<head>
    <style>
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 180px;
            border-left: 5px solid #800000;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #800000;
            margin: 10px 0;
        }

        .btn {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
        }

        .btn:hover {
            background-color: #660000;
        }

        h2 {
            color: #333;
        }
    </style>
</head>

<body>

    <h2>Admin Dashboard</h2>

    <div class="dashboard-container">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="stat-number"><?php echo $totalUsers ?? 0; ?></div>
        </div>
        <div class="stat-card">
            <h3>Students</h3>
            <div class="stat-number"><?php echo $students ?? 0; ?></div>
        </div>
        <div class="stat-card">
            <h3>Instructors</h3>
            <div class="stat-number"><?php echo $instructors ?? 0; ?></div>
            <small>Pending: <?php echo $pendingInstructors ?? 0; ?></small>
        </div>
        <div class="stat-card">
            <h3>Teaching Assistants</h3>
            <div class="stat-number"><?php echo $tas ?? 0; ?></div>
        </div>
        <div class="stat-card">
            <h3>Admins</h3>
            <div class="stat-number"><?php echo $admins ?? 0; ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Courses</h3>
            <div class="stat-number"><?php echo $totalCourses ?? 0; ?></div>
        </div>
        <div class="stat-card">
            <h3>Active Courses</h3>
            <div class="stat-number"><?php echo $activeCourses ?? 0; ?></div>
        </div>
        <div class="stat-card">
            <h3>Quiz Attempts Today</h3>
            <div class="stat-number"><?php echo $todayAttempts ?? 0; ?></div>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <a href="index.php?url=admin/manage-users" class="btn">Manage Users</a>
        <a href="index.php?url=admin/courses" class="btn">Manage Courses</a>
        <a href="index.php?url=admin/subjects" class="btn">Manage Subjects</a>
        <a href="index.php?url=admin/quizzes" class="btn">Manage Quizzes</a>
        <a href="index.php?url=admin/reports" class="btn">Reports</a>
        <a href="index.php?url=admin/settings" class="btn">Settings</a>
    </div>

</body>

</html>
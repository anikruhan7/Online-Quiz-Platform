<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz Platform</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="app-container">
        <header class="main-header">
            <div class="logo-area">
                <h1>📚 Online Quiz Platform</h1>
            </div>
            <nav class="main-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'student'): ?>
                        <a href="index.php?url=student/dashboard">Dashboard</a>
                        <a href="index.php?url=student/courses">Browse Courses</a>
                        <a href="index.php?url=student/enrolled">My Courses</a>
                        <a href="index.php?url=student/leaderboard">Leaderboard</a>
                        <a href="index.php?url=student/performance">Performance</a>
                        <a href="index.php?url=student/doubt-sessions">Doubt Sessions</a>
                        <a href="index.php?url=student/profile">Profile</a>
                    <?php elseif ($_SESSION['role'] === 'instructor'): ?>
                        <a href="index.php?url=instructor/dashboard">Dashboard</a>
                        <a href="index.php?url=instructor/create-course">Create Course</a>
                        <a href="index.php?url=instructor/my-courses">My Courses</a>
                        <a href="index.php?url=instructor/quiz-analytics">Analytics</a>
                        <a href="index.php?url=instructor/profile">Profile</a>
                    <?php elseif ($_SESSION['role'] === 'ta'): ?>
                        <a href="index.php?url=ta/dashboard">Dashboard</a>
                        <a href="index.php?url=ta/assigned-courses">Courses</a>
                        <a href="index.php?url=ta/doubt-sessions">Doubt Sessions</a>
                        <a href="index.php?url=ta/profile">Profile</a>
                    <?php elseif ($_SESSION['role'] === 'admin'): ?>
                        <a href="index.php?url=admin/dashboard">Dashboard</a>
                        <a href="index.php?url=admin/manage-users">Users</a>
                        <a href="index.php?url=admin/courses">Courses</a>
                        <a href="index.php?url=admin/subjects">Subjects</a>
                        <a href="index.php?url=admin/reports">Reports</a>
                        <a href="index.php?url=admin/settings">Settings</a>
                        <a href="index.php?url=admin/profile">Profile</a>
                    <?php endif; ?>
                    <a href="index.php?url=logout" class="logout-btn">Logout</a>
                <?php else: ?>
                    <a href="index.php?url=login">Login</a>
                    <a href="index.php?url=register">Register</a>
                <?php endif; ?>
            </nav>
        </header>
        <main class="main-content">
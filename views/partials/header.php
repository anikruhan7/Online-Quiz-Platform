<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz Platform</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="app-container">
        <header class="main-header">
            <div class="logo-area">
                <h1>📚 Online Quiz Platform</h1>
            </div>
            <nav class="main-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php?url=student/dashboard">Dashboard</a>
                    <a href="index.php?url=student/courses">Browse Courses</a>
                    <a href="index.php?url=student/enrolled">My Courses</a>
                    <a href="index.php?url=student/leaderboard">Leaderboard</a>
                    <a href="index.php?url=student/performance">Performance</a>
                    <a href="index.php?url=student/doubt-sessions">Doubt Sessions</a>
                    <a href="index.php?url=student/profile">Profile</a>
                    <a href="index.php?url=logout" class="logout-btn">Logout</a>
                <?php else: ?>
                    <a href="index.php?url=login">Login</a>
                    <a href="index.php?url=register">Register</a>
                <?php endif; ?>
            </nav>
        </header>
        <main class="main-content">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert success"><?= htmlspecialchars($_SESSION['success']);
                                            unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert error"><?= htmlspecialchars($_SESSION['error']);
                                            unset($_SESSION['error']); ?></div>
            <?php endif; ?>
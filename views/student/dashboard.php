<div class="dashboard-grid">
    <div class="welcome-section">
        <h2>Welcome back, <?= htmlspecialchars($_SESSION['name'] ?? 'Student') ?>! 👋</h2>
        <p>Track your learning progress and upcoming quizzes.</p>
    </div>

    <div class="enrolled-cards">
        <h3>📖 Your Enrolled Courses</h3>
        <?php if (empty($courses)): ?>
            <div class="course-card empty">
                <p>You are not enrolled in any course yet.</p>
                <a href="index.php?url=student/courses" class="btn">Browse Courses</a>
            </div>
        <?php else: ?>
            <div class="courses-grid">
                <?php foreach ($courses as $c): ?>
                    <div class="course-card">
                        <h4><?= htmlspecialchars($c['title']) ?></h4>
                        <p>👩‍🏫 <?= htmlspecialchars($c['instructor_name'] ?? 'Unknown') ?></p>
                        <a href="index.php?url=student/course/<?= $c['id'] ?>" class="btn-small">View Course</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($upcomingQuiz)): ?>
        <div class="upcoming-card">
            <h3>⏰ Upcoming Quiz</h3>
            <div class="quiz-card">
                <strong><?= htmlspecialchars($upcomingQuiz['title']) ?></strong>
                <span class="course-badge"><?= htmlspecialchars($upcomingQuiz['course_title'] ?? '') ?></span>
                <p>⏱️ <?= $upcomingQuiz['time_limit_minutes'] ?> minutes</p>
                <a href="index.php?url=student/quiz/take/<?= $upcomingQuiz['id'] ?>" class="btn">Take Quiz Now</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .dashboard-grid {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .welcome-section {
        background: linear-gradient(105deg, #eef2ff 0%, #ffffff 100%);
        padding: 1.5rem;
        border-radius: 24px;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .course-card {
        background: white;
        border-radius: 20px;
        padding: 1.2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .course-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .btn-small {
        display: inline-block;
        margin-top: 0.8rem;
        padding: 0.4rem 0.8rem;
        background: #4f46e5;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.8rem;
    }

    .upcoming-card {
        background: #fef9c3;
        padding: 1.5rem;
        border-radius: 24px;
        border-left: 8px solid #eab308;
    }

    .quiz-card {
        margin-top: 0.5rem;
    }

    .course-badge {
        display: inline-block;
        background: #e2e8f0;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
</style>
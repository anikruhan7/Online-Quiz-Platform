<div class="performance-container">
    <h2>📊 My Performance Dashboard</h2>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-value"><?= $totalAttempts ?? 0 ?></div>
            <div class="stat-label">Total Quiz Attempts</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value"><?= $passRate ?? 0 ?>%</div>
            <div class="stat-label">Pass Rate</div>
        </div>
    </div>

    <div class="performance-actions">
        <a href="index.php?url=student/attempts" class="btn">View Detailed Attempt History</a>
        <a href="index.php?url=student/leaderboard" class="btn-outline">Compare with Leaderboard</a>
    </div>
</div>

<style>
.performance-container {
    max-width: 800px;
    margin: 0 auto;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}
.stat-card {
    background: white;
    border-radius: 24px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-icon {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}
.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: #4f46e5;
}
.stat-label {
    color: #475569;
    margin-top: 0.5rem;
}
.performance-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}
.btn-outline {
    background: transparent;
    border: 2px solid #4f46e5;
    color: #4f46e5;
    padding: 0.6rem 1.2rem;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-outline:hover {
    background: #eef2ff;
}
</style>

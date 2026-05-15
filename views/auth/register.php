<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Join as a student</p>
        </div>
        <form method="POST" action="index.php?url=register">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required>
            </div>
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a strong password" required>
            </div>
            <div class="input-group">
                <label>Student ID (optional)</label>
                <input type="text" name="student_id" placeholder="e.g., S12345">
            </div>
            <div class="input-group">
                <label>Program (optional)</label>
                <input type="text" name="program" placeholder="e.g., Computer Science">
            </div>
            <button type="submit" class="btn-full">Register</button>
        </form>
        <div class="auth-footer">
            <p>Already have an account? <a href="index.php?url=login">Login here</a></p>
        </div>
    </div>
</div>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Welcome Back</h2>
            <p>Login to your account</p>
        </div>
        <form method="POST" action="index.php?url=login">
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-full">Login</button>
        </form>
        <div class="auth-footer">
            <p>Don't have an account? <a href="index.php?url=register">Register now</a></p>
        </div>
    </div>
</div>

<style>
    .auth-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
        padding: 2rem;
    }

    .auth-card {
        background: white;
        border-radius: 32px;
        padding: 2rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .auth-header h2 {
        border-left: none;
        margin-bottom: 0.5rem;
    }

    .auth-header p {
        color: #64748b;
    }

    .input-group {
        margin-bottom: 1.2rem;
    }

    .input-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.3rem;
        color: #334155;
    }

    .input-group input {
        width: 100%;
        max-width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        transition: border 0.2s;
    }

    .input-group input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .btn-full {
        width: 100%;
        background: #4f46e5;
        padding: 0.75rem;
        font-size: 1rem;
    }

    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .auth-footer a {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 600;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>
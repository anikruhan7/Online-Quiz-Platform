<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Login | Quiz Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #800000 0%, #1a237e 100%);
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: #faf9f6;
            border-radius: 1rem;
            box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            padding: 2rem;
            transition: transform 0.2s;
            margin: auto;
        }

        .login-card:hover {
            transform: scale(1.01);
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #800000;
            margin-bottom: 0.4rem;
            text-align: center;
        }

        .sub {
            text-align: center;
            color: #4a4a4a;
            margin-bottom: 1.8rem;
            font-size: 0.9rem;
        }

        .input-group {
            margin-bottom: 1.2rem;
        }

        .input-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.4rem;
            color: #1a1a1a;
        }

        .input-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid #b0e0e6;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            background: white;
            transition: 0.2s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #800000;
            box-shadow: 0 0 0 3px rgba(128, 0, 0, 0.1);
        }

        .btn-login {
            background: #800000;
            color: white;
            width: 100%;
            padding: 0.85rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
            margin: 1rem 0 1.2rem;
        }

        .btn-login:hover {
            background: #660000;
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(128, 0, 0, 0.3);
        }

        .register-link {
            text-align: center;
            font-size: 0.85rem;
            color: #1a1a1a;
        }

        .register-link a {
            color: #2e7d32;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer-note {
            text-align: center;
            font-size: 0.7rem;
            color: #8b4513;
            margin-top: 1.5rem;
            border-top: 1px solid #e0d6c6;
            padding-top: 1rem;
        }

        @media (max-width: 550px) {
            .login-card {
                padding: 1.5rem;
            }

            h1 {
                font-size: 1.7rem;
            }
        }

        @media (min-width: 1200px) and (orientation: landscape) {
            .login-card {
                max-width: 550px;
                padding: 2.5rem;
            }

            .input-group input {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h1>Welcome!</h1>
        <div class="sub">Please login to continue</div>
        <form method="POST" action="index.php?url=login">
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com" required autofocus>
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
            <button type="submit" class="btn-login">Submit</button>
        </form>
        <div class="register-link">
            Don't have an account? <a href="index.php?url=register">Sign up</a>
        </div>
        <div class="footer-note">
            Secure access to quizzes and courses
        </div>
    </div>
</body>

</html>
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

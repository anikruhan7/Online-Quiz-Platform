<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Quiz Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a237e, #800000);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #faf9f6;
            border-radius: 1rem;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.3);
        }

        .login-card h1 {
            text-align: center;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #800000, #1a237e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
        }

        .input-group {
            margin-bottom: 1rem;
        }

        .input-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.3rem;
            color: #1a1a1a;
        }

        .input-group input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #b0e0e6;
            border-radius: 0.6rem;
            background: white;
            transition: border 0.2s;
        }

        .input-group input:focus {
            border-color: #800000;
            outline: none;
        }

        button {
            background: #800000;
            color: white;
            width: 100%;
            padding: 0.7rem;
            border: none;
            border-radius: 0.6rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }

        button:hover {
            background: #660000;
        }

        .footer-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #1a1a1a;
        }

        .footer-link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        #error-message {
            display: none;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }

            .login-card h1 {
                font-size: 1.5rem;
            }

            .input-group input {
                padding: 0.6rem 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h1> WELCOME !</h1>
        <form method="POST" action="index.php?url=login">
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required autofocus>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="footer-link">
            Don't have an account? <a href="index.php?url=register">Register now</a>
        </div>
    </div>

    <div id="error-message">
        <?php if (isset($_SESSION['error'])): ?>
            <?php echo htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <script>
        var errorDiv = document.getElementById('error-message');
        var errorMsg = errorDiv.innerText.trim();
        if (errorMsg !== '') {
            alert(errorMsg);
        }
    </script>
</body>

</html>
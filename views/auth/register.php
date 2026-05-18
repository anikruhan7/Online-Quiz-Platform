<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Register | Quiz Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a237e 0%, #800000 100%);
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .register-card {
            background: #faf9f6;
            border-radius: 1rem;
            box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.3);
            max-width: 550px;
            width: 100%;
            padding: 1.8rem;
            transition: transform 0.2s;
            max-height: 95vh;
            overflow-y: auto;
            margin: auto;
        }

        .register-card::-webkit-scrollbar {
            width: 5px;
        }

        .register-card::-webkit-scrollbar-track {
            background: #e0d6c6;
            border-radius: 0.5rem;
        }

        .register-card::-webkit-scrollbar-thumb {
            background: #800000;
            border-radius: 0.5rem;
        }

        .register-card:hover {
            transform: scale(1.01);
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #800000;
            margin-bottom: 0.3rem;
            text-align: center;
        }

        .sub {
            text-align: center;
            color: #4a4a4a;
            margin-bottom: 1.2rem;
            font-size: 0.85rem;
        }

        .input-group {
            margin-bottom: 1rem;
        }

        .input-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.3rem;
            color: #1a1a1a;
            font-size: 0.85rem;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #b0e0e6;
            border-radius: 0.75rem;
            font-size: 0.85rem;
            background: white;
            transition: 0.2s;
            font-family: inherit;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: #800000;
            box-shadow: 0 0 0 2px rgba(128, 0, 0, 0.1);
        }

        .dynamic-fields {
            background: #f5f0e6;
            padding: 0.6rem;
            border-radius: 0.75rem;
            margin: 0.5rem 0;
        }

        .btn-register {
            background: #800000;
            color: white;
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: 0.2s;
            margin: 0.5rem 0 1rem;
        }

        .btn-register:hover {
            background: #660000;
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            font-size: 0.85rem;
            color: #1a1a1a;
        }

        .login-link a {
            color: #2e7d32;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer-note {
            text-align: center;
            font-size: 0.7rem;
            color: #8b4513;
            margin-top: 1rem;
            border-top: 1px solid #e0d6c6;
            padding-top: 0.8rem;
        }

        @media (max-width: 600px) {
            .register-card {
                padding: 1.2rem;
            }

            h1 {
                font-size: 1.7rem;
            }
        }

        @media (min-width: 1200px) and (orientation: landscape) {
            .register-card {
                max-width: 650px;
                padding: 2rem;
            }

            .input-group input,
            .input-group select,
            .input-group textarea {
                padding: 0.8rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h1>Welcome!</h1>
        <div class="sub">Create your account</div>
        <form method="POST" action="index.php?url=register" id="registerForm">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="e.g., John Doe" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password" required>
            </div>

            <div class="input-group">
                <label>I want to join as</label>
                <select name="role" id="roleSelect">
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="ta">Teaching Assistant</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div id="studentFields" class="dynamic-fields">
                <div class="input-group"><label>Student ID (optional)</label><input type="text" name="student_id" placeholder="e.g., S12345"></div>
                <div class="input-group"><label>Program (optional)</label><input type="text" name="program" placeholder="e.g., Computer Science"></div>
            </div>
            <div id="instructorFields" class="dynamic-fields" style="display:none;">
                <div class="input-group"><label>Department</label><input type="text" name="department" placeholder="e.g., Computer Science"></div>
                <div class="input-group"><label>Bio</label><textarea name="bio" rows="1" placeholder="Short bio"></textarea></div>
            </div>
            <div id="taFields" class="dynamic-fields" style="display:none;">
                <div class="input-group"><label>Department</label><input type="text" name="department" placeholder="e.g., Mathematics"></div>
            </div>
            <div id="adminFields" class="dynamic-fields" style="display:none;">
                <div class="input-group"><label>Admin Code</label><input type="password" name="admin_code" placeholder="Required for admin"></div>
            </div>

            <button type="submit" class="btn-register">Submit</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="index.php?url=login">Sign in</a>
        </div>
        <div class="footer-note">
            Start your learning journey with us
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const studentDiv = document.getElementById('studentFields');
        const instructorDiv = document.getElementById('instructorFields');
        const taDiv = document.getElementById('taFields');
        const adminDiv = document.getElementById('adminFields');

        function toggleFields() {
            studentDiv.style.display = 'none';
            instructorDiv.style.display = 'none';
            taDiv.style.display = 'none';
            adminDiv.style.display = 'none';
            if (roleSelect.value === 'student') studentDiv.style.display = 'block';
            else if (roleSelect.value === 'instructor') instructorDiv.style.display = 'block';
            else if (roleSelect.value === 'ta') taDiv.style.display = 'block';
            else if (roleSelect.value === 'admin') adminDiv.style.display = 'block';
        }
        roleSelect.addEventListener('change', toggleFields);
        toggleFields();
    </script>
</body>

</html>
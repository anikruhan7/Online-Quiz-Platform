<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Register | Quiz Platform</title>
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
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            /* prevent body scroll */
        }

        .register-card {
            background: #faf9f6;
            border-radius: 1rem;
            padding: 1rem 1.2rem;
            width: 100%;
            max-width: 480px;
            max-height: 95vh;
            overflow-y: auto;
            /* allow card scroll only if absolutely necessary, but content fits */
            box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.3);
        }

        /* Hide scrollbar for cleaner look (optional) */
        .register-card::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        .register-card h1 {
            text-align: center;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #800000, #1a237e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.8rem;
        }

        .input-group {
            margin-bottom: 0.6rem;
        }

        .input-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.15rem;
            color: #1a1a1a;
            font-size: 0.75rem;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 0.4rem 0.6rem;
            border: 1px solid #b0e0e6;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            background: white;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: #800000;
            outline: none;
        }

        .dynamic-fields {
            background: #f5f0e6;
            padding: 0.4rem;
            border-radius: 0.5rem;
            margin: 0.3rem 0;
        }

        button {
            background: #800000;
            color: white;
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }

        button:hover {
            background: #660000;
        }

        .footer-link {
            text-align: center;
            margin-top: 0.8rem;
            font-size: 0.7rem;
            color: #1a1a1a;
        }

        .footer-link a {
            color: #2e7d32;
            text-decoration: none;
        }

        @media (max-height: 700px) {
            .register-card {
                padding: 0.8rem 1rem;
            }

            .input-group {
                margin-bottom: 0.4rem;
            }

            .input-group input,
            .input-group select {
                padding: 0.3rem 0.5rem;
            }

            .register-card h1 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h1>Fill up carefully !</h1>
        <form method="POST" action="index.php?url=register" id="regForm">
            <div class="input-group"><label>Full Name</label><input type="text" name="name" required></div>
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="input-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="input-group"><label>Role</label><select name="role" id="roleSelect">
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="ta">Teaching Assistant</option>
                    <option value="admin">Admin</option>
                </select></div>

            <div id="studentFields" class="dynamic-fields">
                <div class="input-group"><label>Student ID (optional)</label><input type="text" name="student_id"></div>
                <div class="input-group"><label>Program (optional)</label><input type="text" name="program"></div>
            </div>
            <div id="instructorFields" class="dynamic-fields" style="display:none;">
                <div class="input-group"><label>Department</label><input type="text" name="department"></div>
                <div class="input-group"><label>Bio</label><textarea name="bio" rows="1"></textarea></div>
            </div>
            <div id="taFields" class="dynamic-fields" style="display:none;">
                <div class="input-group"><label>Department</label><input type="text" name="department"></div>
            </div>
            <div id="adminFields" class="dynamic-fields" style="display:none;">
                <div class="input-group"><label>Admin Code</label><input type="password" name="admin_code"></div>
            </div>

            <button type="submit">Register</button>
        </form>
        <div class="footer-link">
            Already have an account? <a href="index.php?url=login">Login here</a>
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
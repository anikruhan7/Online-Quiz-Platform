<?php
require_once 'models/User.php';

class AuthController extends Controller
{
    public function loginForm()
    {
        $this->view('auth/login');
    }
<<<<<<< HEAD
=======

>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    public function registerForm()
    {
        $this->view('auth/register');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
<<<<<<< HEAD
        $user = (new User())->findByEmail($email);
=======

        $userModel = new User();
        $user = $userModel->findByEmail($email);

>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
<<<<<<< HEAD
            $this->redirect('index.php?url=' . $user['role'] . '/dashboard');
        } else {
            $_SESSION['error'] = "Invalid credentials";
=======
            $this->redirect('index.php?url=student/dashboard');
        } else {
            $_SESSION['error'] = "Invalid email or password";
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
            $this->redirect('index.php?url=login');
        }
    }

    public function register()
    {
<<<<<<< HEAD
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'student';
        $student_id = $_POST['student_id'] ?? '';
        $program = $_POST['program'] ?? '';
        $department = $_POST['department'] ?? '';
        $bio = $_POST['bio'] ?? '';
=======
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $student_id = $_POST['student_id'] ?? '';
        $program = $_POST['program'] ?? '';
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Name, email and password are required.";
            $this->redirect('index.php?url=register');
            return;
        }
<<<<<<< HEAD
        if ($role === 'admin') {
            $adminCode = $_POST['admin_code'] ?? '';
            if ($adminCode !== 'ADMIN123') {
                $_SESSION['error'] = "Invalid admin code.";
                $this->redirect('index.php?url=register');
                return;
            }
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
=======

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        $userModel = new User();
        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
<<<<<<< HEAD
            'role' => $role,
            'student_id' => $student_id,
            'program' => $program,
            'department' => $department,
            'bio' => $bio
        ]);
=======
            'student_id' => $student_id,
            'program' => $program
        ]);

>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        if ($userId) {
            $_SESSION['success'] = "Registration successful. Please login.";
            $this->redirect('index.php?url=login');
        } else {
<<<<<<< HEAD
            $_SESSION['error'] = "Email already exists.";
=======
            $_SESSION['error'] = "Registration failed. Email may already exist.";
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
            $this->redirect('index.php?url=register');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('index.php?url=login');
    }
}

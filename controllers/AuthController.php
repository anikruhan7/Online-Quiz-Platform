<?php
require_once 'models/User.php';

class AuthController extends Controller
{
    public function loginForm()
    {
        $this->view('auth/login');
    }

    public function registerForm()
    {
        $this->view('auth/register');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = (new User())->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $this->redirect('index.php?url=' . $user['role'] . '/dashboard');
        } else {
            $_SESSION['error'] = "Invalid email or password";
            $this->redirect('index.php?url=login');
        }
    }

    public function register()
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'student';
        $student_id = $_POST['student_id'] ?? '';
        $program = $_POST['program'] ?? '';
        $department = $_POST['department'] ?? '';
        $bio = $_POST['bio'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Name, email and password are required.";
            $this->redirect('index.php?url=register');
            return;
        }
        if ($role === 'admin') {
            $adminCode = $_POST['admin_code'] ?? '';
            if ($adminCode !== 'ADMIN123') {
                $_SESSION['error'] = "Invalid admin code.";
                $this->redirect('index.php?url=register');
                return;
            }
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $userModel = new User();
        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
            'role' => $role,
            'student_id' => $student_id,
            'program' => $program,
            'department' => $department,
            'bio' => $bio
        ]);
        if ($userId) {
            $_SESSION['success'] = "Registration successful. Please login.";
            $this->redirect('index.php?url=login');
        } else {
            $_SESSION['error'] = "Email already exists.";
            $this->redirect('index.php?url=register');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('index.php?url=login');
    }
}

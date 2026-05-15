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

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $this->redirect('index.php?url=student/dashboard');
        } else {
            $_SESSION['error'] = "Invalid email or password";
            $this->redirect('index.php?url=login');
        }
    }

    public function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $student_id = $_POST['student_id'] ?? '';
        $program = $_POST['program'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Name, email and password are required.";
            $this->redirect('index.php?url=register');
            return;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $userModel = new User();
        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
            'student_id' => $student_id,
            'program' => $program
        ]);

        if ($userId) {
            $_SESSION['success'] = "Registration successful. Please login.";
            $this->redirect('index.php?url=login');
        } else {
            $_SESSION['error'] = "Registration failed. Email may already exist.";
            $this->redirect('index.php?url=register');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('index.php?url=login');
    }
}

<?php
require_once 'models/User.php';
require_once 'models/Course.php';
require_once 'models/Attempt.php';

class AdminController extends Controller
{
    public function __construct()
    {
        $this->requireRole('admin');
    }

    public function dashboard()
    {
        $totalUsers = (new User())->countAll();
        $totalCourses = (new Course())->countAll();
        $totalAttempts = (new Attempt())->countAll();
        $this->view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalAttempts' => $totalAttempts
        ]);
    }

    public function manageUsers()
    {
        $users = (new User())->getAll();
        $this->view('admin/manage_users', ['users' => $users]);
    }

    public function updateUser()
    {
        $user_id = (int)($_POST['user_id'] ?? 0);
        $role = $_POST['role'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        if ($user_id && $role) {
            (new User())->updateRoleAndStatus($user_id, $role, $is_active);
            $_SESSION['success'] = "User updated.";
        }
        $this->redirect('index.php?url=admin/manage-users');
    }

    public function courses()
    {
        $courses = (new Course())->getAll();
        $this->view('admin/courses', ['courses' => $courses]);
    }

    public function reports()
    {
        $this->view('admin/reports');
    }

    public function settings()
    {
        $this->view('admin/settings');
    }

    public function profile()
    {
        $user = (new User())->find($_SESSION['user_id']);
        $this->view('admin/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $user_id = $_SESSION['user_id'];
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $target = "uploads/" . time() . "_" . basename($_FILES['profile_pic']['name']);
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
            $pic = $target;
        }
        (new User())->updateProfileAdmin($user_id, $name, $phone, $pic);
        $_SESSION['success'] = "Profile updated";
        $this->redirect('index.php?url=admin/profile');
    }
}

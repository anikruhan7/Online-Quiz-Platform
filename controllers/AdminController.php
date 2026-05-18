<?php
require_once 'models/User.php';
require_once 'models/Course.php';
require_once 'models/Attempt.php';
require_once 'models/Subject.php';
require_once 'models/Quiz.php';
require_once 'models/Setting.php';

class AdminController extends Controller
{
    public function __construct()
    {
        $this->requireRole('admin');
    }

    public function dashboard()
    {
        $userModel = new User();
        $courseModel = new Course();
        $attemptModel = new Attempt();

        $data = [
            'totalUsers' => $userModel->countAll(),
            'students' => $userModel->countByRole('student'),
            'instructors' => $userModel->countByRole('instructor'),
            'tas' => $userModel->countByRole('ta'),
            'admins' => $userModel->countByRole('admin'),
            'pendingInstructors' => $userModel->countPendingInstructors(),
            'totalCourses' => $courseModel->countAll(),
            'activeCourses' => $courseModel->countActive(),
            'todayAttempts' => $attemptModel->countToday()
        ];
        $this->view('admin/dashboard', $data);
    }

    public function manageUsers()
    {
        $search = $_GET['search'] ?? '';
        $userModel = new User();
        $users = $userModel->getAll($search);
        $this->view('admin/manage_users', ['users' => $users, 'search' => $search]);
    }

    public function updateUser()
    {
        $userId = (int)($_POST['user_id'] ?? 0);
        $role = $_POST['role'] ?? '';
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        if ($userId && $role) {
            (new User())->updateRoleAndStatus($userId, $role, $isActive);
            $_SESSION['success'] = "User updated.";
        } else {
            $_SESSION['error'] = "Invalid request.";
        }
        $this->redirect('index.php?url=admin/manage-users');
    }

    public function courses()
    {
        $subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : null;
        $instructorId = isset($_GET['instructor_id']) ? (int)$_GET['instructor_id'] : null;
        $courses = (new Course())->getAllFiltered($subjectId, $instructorId);
        $subjects = (new Subject())->getAll();
        $instructors = (new User())->getInstructors();
        $this->view('admin/courses', [
            'courses' => $courses,
            'subjects' => $subjects,
            'instructors' => $instructors,
            'selected_subject' => $subjectId,
            'selected_instructor' => $instructorId
        ]);
    }

    public function subjects()
    {
        $subjects = (new Subject())->getAll();
        $this->view('admin/subjects', ['subjects' => $subjects]);
    }

    public function addSubject()
    {
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        if ($name) {
            (new Subject())->add($name, $desc);
            $_SESSION['success'] = "Subject added.";
        } else {
            $_SESSION['error'] = "Subject name required.";
        }
        $this->redirect('index.php?url=admin/subjects');
    }

    public function editSubject()
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        if ($id && $name) {
            (new Subject())->update($id, $name, $desc);
            $_SESSION['success'] = "Subject updated.";
        } else {
            $_SESSION['error'] = "Invalid data.";
        }
        $this->redirect('index.php?url=admin/subjects');
    }

    public function deleteSubject()
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            (new Subject())->delete($id);
            $_SESSION['success'] = "Subject deleted.";
        } else {
            $_SESSION['error'] = "Invalid subject.";
        }
        $this->redirect('index.php?url=admin/subjects');
    }

    public function quizzes()
    {
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : null;
        $status = $_GET['status'] ?? '';
        $type = $_GET['type'] ?? '';
        $quizzes = (new Quiz())->getAllFiltered($courseId, $status, $type);
        $courses = (new Course())->getAll();
        $this->view('admin/quizzes', [
            'quizzes' => $quizzes,
            'courses' => $courses,
            'selected_course' => $courseId,
            'selected_status' => $status,
            'selected_type' => $type
        ]);
    }

    public function reports()
    {
        $this->view('admin/reports');
    }

    public function settings()
    {
        $settings = (new Setting())->getAll();
        $this->view('admin/settings', ['settings' => $settings]);
    }

    public function updateSettings()
    {
        $maxDuration = (int)($_POST['max_quiz_duration'] ?? 60);
        $maxStudents = (int)($_POST['default_max_students'] ?? 100);
        $setting = new Setting();
        $setting->set('max_quiz_duration', $maxDuration);
        $setting->set('default_max_students', $maxStudents);
        $_SESSION['success'] = "Settings updated.";
        $this->redirect('index.php?url=admin/settings');
    }

    public function profile()
    {
        $user = (new User())->find($_SESSION['user_id']);
        $this->view('admin/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $userId = $_SESSION['user_id'];
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $target = "uploads/" . time() . "_" . basename($_FILES['profile_pic']['name']);
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
            $pic = $target;
        }
        (new User())->updateProfileAdmin($userId, $name, $phone, $pic);
        $_SESSION['success'] = "Profile updated.";
        $this->redirect('index.php?url=admin/profile');
    }
}

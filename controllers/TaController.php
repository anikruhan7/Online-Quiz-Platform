<?php
require_once 'models/Course.php';
require_once 'models/User.php';
require_once 'models/DoubtSession.php';

class TaController extends Controller
{
    public function __construct()
    {
        $this->requireRole('ta');
    }

    public function dashboard()
    {
        $courses = (new Course())->getCoursesForTA($_SESSION['user_id']);
        $this->view('ta/dashboard', ['courses' => $courses]);
    }

    public function assignedCourses()
    {
        $courses = (new Course())->getCoursesForTA($_SESSION['user_id']);
        $this->view('ta/assigned_courses', ['courses' => $courses]);
    }

    public function doubtSessions()
    {
        $sessions = (new DoubtSession())->getSessionsByTA($_SESSION['user_id']);
        $this->view('ta/doubt_sessions', ['sessions' => $sessions]);
    }

    public function createDoubtSession()
    {
        $course_id = (int)($_POST['course_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $scheduled_at = $_POST['scheduled_at'] ?? '';
        $duration = (int)($_POST['duration'] ?? 60);
        $location = trim($_POST['location'] ?? '');
        $max_attendees = (int)($_POST['max_attendees'] ?? 10);
        if (empty($title) || empty($scheduled_at)) {
            $_SESSION['error'] = "Title and date/time required.";
            $this->redirect('index.php?url=ta/doubt-sessions');
        }
        (new DoubtSession())->createSession($course_id, $_SESSION['user_id'], $title, $scheduled_at, $duration, $location, $max_attendees);
        $_SESSION['success'] = "Doubt session created.";
        $this->redirect('index.php?url=ta/doubt-sessions');
    }

    public function profile()
    {
        $user = (new User())->find($_SESSION['user_id']);
        $this->view('ta/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $user_id = $_SESSION['user_id'];
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $target = "uploads/" . time() . "_" . basename($_FILES['profile_pic']['name']);
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
            $pic = $target;
        }
        (new User())->updateProfileTA($user_id, $name, $phone, $department, $pic);
        $_SESSION['success'] = "Profile updated";
        $this->redirect('index.php?url=ta/profile');
    }
}

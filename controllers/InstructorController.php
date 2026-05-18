<?php
require_once 'models/Course.php';
require_once 'models/User.php';
require_once 'models/Subject.php';
require_once 'models/Quiz.php';

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->requireRole('instructor');
    }

    public function dashboard()
    {
        $courses = (new Course())->getCoursesByInstructor($_SESSION['user_id']);
        $this->view('instructor/dashboard', ['courses' => $courses]);
    }

    public function createCourse()
    {
        $subjects = (new Subject())->getAll();
        $this->view('instructor/create_course', ['subjects' => $subjects]);
    }

    public function storeCourse()
    {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $subject_id = (int)($_POST['subject_id'] ?? 0);
        $enrollment_type = $_POST['enrollment_type'] ?? 'open';
        $max_students = (int)($_POST['max_students'] ?? 100);
        if (empty($title) || empty($description) || $subject_id <= 0) {
            $_SESSION['error'] = "Please fill all required fields.";
            $this->redirect('index.php?url=instructor/create-course');
        }
        (new Course())->createCourse([
            'instructor_id' => $_SESSION['user_id'],
            'subject_id' => $subject_id,
            'title' => $title,
            'description' => $description,
            'enrollment_type' => $enrollment_type,
            'max_students' => $max_students,
            'status' => 'active'
        ]);
        $_SESSION['success'] = "Course created.";
        $this->redirect('index.php?url=instructor/my-courses');
    }

    public function myCourses()
    {
        $courses = (new Course())->getCoursesByInstructor($_SESSION['user_id']);
        $this->view('instructor/my_courses', ['courses' => $courses]);
    }

    public function createQuiz()
    {
        $courses = (new Course())->getCoursesByInstructor($_SESSION['user_id']);
        $this->view('instructor/create_quiz', ['courses' => $courses]);
    }

    public function storeQuiz()
    {
        $course_id = (int)($_POST['course_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $time_limit = (int)($_POST['time_limit'] ?? 30);
        $total_marks = (int)($_POST['total_marks'] ?? 20);
        $pass_mark = (int)($_POST['pass_mark'] ?? 10);
        $quiz_type = $_POST['quiz_type'] ?? 'graded';
        $available_from = $_POST['available_from'] ?? date('Y-m-d H:i:s');
        $available_until = $_POST['available_until'] ?? date('Y-m-d H:i:s', strtotime('+90 days'));

        $quizId = (new Quiz())->createQuiz([
            'course_id' => $course_id,
            'created_by' => $_SESSION['user_id'],
            'title' => $title,
            'description' => $description,
            'time_limit_minutes' => $time_limit,
            'total_marks' => $total_marks,
            'pass_mark' => $pass_mark,
            'quiz_type' => $quiz_type,
            'status' => 'published',
            'available_from' => $available_from,
            'available_until' => $available_until
        ]);
        $_SESSION['success'] = "Quiz created. Add questions later.";
        $this->redirect('index.php?url=instructor/quiz-analytics');
    }

    public function quizAnalytics()
    {
        $courses = (new Course())->getCoursesByInstructor($_SESSION['user_id']);
        $this->view('instructor/quiz_analytics', ['courses' => $courses]);
    }

    public function profile()
    {
        $user = (new User())->find($_SESSION['user_id']);
        $this->view('instructor/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $user_id = $_SESSION['user_id'];
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $target = "uploads/" . time() . "_" . basename($_FILES['profile_pic']['name']);
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
            $pic = $target;
        }
        (new User())->updateProfileInstructor($user_id, $name, $phone, $department, $bio, $pic);
        $_SESSION['success'] = "Profile updated";
        $this->redirect('index.php?url=instructor/profile');
    }
}

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'models/User.php';
require_once 'models/Course.php';
require_once 'models/Enrollment.php';
require_once 'models/Quiz.php';
require_once 'models/Attempt.php';
require_once 'models/Question.php';
require_once 'models/Material.php';
require_once 'models/Announcement.php';
require_once 'models/QaQuestion.php';
require_once 'models/QaAnswer.php';
require_once 'models/DoubtSession.php';
require_once 'models/Subject.php';

class StudentController extends Controller
{
    public function __construct()
    {
        $this->requireRole('student');
    }

    public function dashboard()
    {
        $student_id = $_SESSION['user_id'];
        $courses = (new Enrollment())->getEnrolledCourses($student_id);
        $courses = is_array($courses) ? $courses : [];
        $upcoming = null;
        $quizModel = new Quiz();
        foreach ($courses as $c) {
            $quizzes = $quizModel->getPublishedQuizzesForCourse($c['id']);
            if (!empty($quizzes)) {
                $upcoming = $quizzes[0];
                $upcoming['course_title'] = $c['title'];
                break;
            }
        }
        $this->view('student/dashboard', ['courses' => $courses, 'upcomingQuiz' => $upcoming]);
    }

    public function browseCourses()
    {
        $search = $_GET['search'] ?? '';
        $subject_id = isset($_GET['subject_id']) && $_GET['subject_id'] !== '' ? (int)$_GET['subject_id'] : null;
        $courses = (new Course())->getActiveCourses($search, $subject_id);
        $courses = is_array($courses) ? $courses : [];
        $subjects = (new Subject())->getAll();
        $subjects = is_array($subjects) ? $subjects : [];
        $this->view('student/courses', ['courses' => $courses, 'subjects' => $subjects]);
    }

    public function enroll()
    {
        $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
        $student_id = $_SESSION['user_id'];
        $enr = new Enrollment();
        if ($enr->isEnrolled($student_id, $course_id)) {
            $_SESSION['error'] = "Already enrolled";
            $this->redirect('index.php?url=student/courses');
            return;
        }
        $course = (new Course())->find($course_id);
        if (!$course) {
            $_SESSION['error'] = "Course not found";
            $this->redirect('index.php?url=student/courses');
            return;
        }
        if ($course['enrollment_type'] == 'open') {
            $enr->enrollDirect($student_id, $course_id);
            $_SESSION['success'] = "Enrolled successfully!";
        } else {
            $enr->requestApproval($student_id, $course_id);
            $_SESSION['success'] = "Enrollment request sent.";
        }
        $this->redirect('index.php?url=student/courses');
    }

    public function enrolledCourses()
    {
        $courses = (new Enrollment())->getEnrolledCourses($_SESSION['user_id']);
        $courses = is_array($courses) ? $courses : [];
        $this->view('student/enrolled_courses', ['courses' => $courses]);
    }

    public function courseDetail($course_id)
    {
        $student_id = $_SESSION['user_id'];
        if (!(new Enrollment())->isEnrolled($student_id, $course_id)) {
            $this->redirect('index.php?url=student/courses');
            return;
        }
        $course = (new Course())->getCourseDetail($course_id);
        $course = $course ?: [];
        $tas = (new Course())->getTAsForCourse($course_id);
        $tas = is_array($tas) ? $tas : [];
        $materials = (new Material())->getForCourse($course_id);
        $materials = is_array($materials) ? $materials : [];
        $announcements = (new Announcement())->getForCourse($course_id);
        $announcements = is_array($announcements) ? $announcements : [];
        $quizzes = (new Quiz())->getPublishedQuizzesForCourse($course_id);
        $quizzes = is_array($quizzes) ? $quizzes : [];
        $this->view('student/course_detail', compact('course', 'tas', 'materials', 'announcements', 'quizzes'));
    }

    public function takeQuiz($quiz_id)
    {
        $quiz = (new Quiz())->getQuizWithQuestions($quiz_id);
        if (!$quiz) {
            $this->redirect('index.php?url=student/dashboard');
            return;
        }
        $course_id = $quiz['course_id'];
        if (!(new Enrollment())->isEnrolled($_SESSION['user_id'], $course_id)) {
            $this->redirect('index.php?url=student/courses');
            return;
        }
        $this->view('student/take_quiz', ['quiz' => $quiz]);
    }

    /**
     * AJAX quiz submission – returns JSON
     */
    public function submitQuiz()
    {
        $quiz_id = isset($_POST['quiz_id']) ? (int)$_POST['quiz_id'] : 0;
        $answers = $_POST['answers'] ?? [];
        $student_id = $_SESSION['user_id'];

        $attemptModel = new Attempt();
        $attempt_id = $attemptModel->startAttempt($quiz_id, $student_id);
        $quiz = (new Quiz())->find($quiz_id);

        if (!$quiz) {
            $this->json(['success' => false, 'error' => 'Quiz not found']);
            return;
        }

        $obtained = 0;
        foreach ($answers as $qid => $oid) {
            $isCorrect = (new Question())->isOptionCorrect($oid);
            $marks = (new Question())->getMarks($qid);
            if ($isCorrect) {
                $obtained += $marks;
            }
            $attemptModel->saveAnswer($attempt_id, $qid, $oid);
        }
        $attemptModel->completeAttempt($attempt_id, $obtained, $quiz['quiz_type'] == 'graded');

        $this->json([
            'success' => true,
            'score' => $obtained,
            'total' => (int)$quiz['total_marks']
        ]);
    }

    public function quizResult($attempt_id)
    {
        $attempt = (new Attempt())->find($attempt_id);
        if (!$attempt) {
            $this->redirect('index.php?url=student/dashboard');
            return;
        }
        $quiz = (new Quiz())->find($attempt['quiz_id']);
        $this->view('student/quiz_result', ['attempt' => $attempt, 'quiz' => $quiz]);
    }

    public function attemptHistory()
    {
        $attempts = (new Attempt())->getStudentAttempts($_SESSION['user_id']);
        $attempts = is_array($attempts) ? $attempts : [];
        $this->view('student/attempt_history', ['attempts' => $attempts]);
    }

    public function leaderboard()
    {
        $student_id = $_SESSION['user_id'];
        $enrolled = (new Enrollment())->getEnrolledCourses($student_id);
        $enrolled = is_array($enrolled) ? $enrolled : [];
        $courses_with_quizzes = [];
        foreach ($enrolled as $c) {
            $quizzes = (new Quiz())->getPublishedQuizzesForCourse($c['id']);
            if (!empty($quizzes)) {
                $c['quizzes'] = $quizzes;
                $courses_with_quizzes[] = $c;
            }
        }
        $this->view('student/leaderboard', ['courses' => $courses_with_quizzes]);
    }

    public function performance()
    {
        $attempts = (new Attempt())->getStudentAttempts($_SESSION['user_id']);
        $attempts = is_array($attempts) ? $attempts : [];
        $total = count($attempts);
        $passed = 0;
        foreach ($attempts as $a) {
            if ($a['score'] >= $a['pass_mark']) {
                $passed++;
            }
        }
        $passRate = $total > 0 ? round(($passed / $total) * 100) : 0;
        $this->view('student/performance', ['passRate' => $passRate, 'totalAttempts' => $total]);
    }

    public function qaBoard($course_id)
    {
        $questions = (new QaQuestion())->getForCourse($course_id);
        $questions = is_array($questions) ? $questions : [];
        $this->view('student/qa_board', ['course_id' => $course_id, 'questions' => $questions]);
    }

    public function postQuestion()
    {
        $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
        $title = trim($_POST['title'] ?? '');
        $body = trim($_POST['body'] ?? '');
        if (empty($title) || empty($body)) {
            $_SESSION['error'] = "Title and body are required";
            $this->redirect("index.php?url=student/qa/$course_id");
            return;
        }
        (new QaQuestion())->create($course_id, $_SESSION['user_id'], $title, $body);
        $_SESSION['success'] = "Question posted successfully";
        $this->redirect("index.php?url=student/qa/$course_id");
    }

    public function resolveQuestion()
    {
        $qid = isset($_POST['qid']) ? (int)$_POST['qid'] : 0;
        (new QaQuestion())->resolve($qid, $_SESSION['user_id']);
        $_SESSION['success'] = "Question marked as resolved";
        $this->redirect($_SERVER['HTTP_REFERER'] ?? 'index.php?url=student/dashboard');
    }

    public function doubtSessions()
    {
        $sessions = (new DoubtSession())->getUpcomingForStudent($_SESSION['user_id']);
        $sessions = is_array($sessions) ? $sessions : [];
        $bookings = (new DoubtSessionBooking())->getBookings($_SESSION['user_id']);
        $bookings = is_array($bookings) ? $bookings : [];
        $this->view('student/doubt_sessions', ['sessions' => $sessions, 'bookings' => $bookings]);
    }

    public function bookDoubtSession()
    {
        $session_id = isset($_POST['session_id']) ? (int)$_POST['session_id'] : 0;
        (new DoubtSessionBooking())->book($session_id, $_SESSION['user_id']);
        $_SESSION['success'] = "Doubt session booked";
        $this->redirect('index.php?url=student/doubt-sessions');
    }

    public function dropCourse()
    {
        $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
        $enr = new Enrollment();
        if ($enr->dropCourse($_SESSION['user_id'], $course_id)) {
            $_SESSION['success'] = "Course dropped successfully";
        } else {
            $_SESSION['error'] = "Cannot drop – you have completed a graded quiz in this course";
        }
        $this->redirect('index.php?url=student/enrolled');
    }

    public function profile()
    {
        $user = (new User())->find($_SESSION['user_id']);
        $this->view('student/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $user_id = $_SESSION['user_id'];
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $program = trim($_POST['program'] ?? '');
        $pic = null;

        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $target = "uploads/" . time() . "_" . basename($_FILES['profile_pic']['name']);
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
                    $pic = $target;
                }
            } else {
                $_SESSION['error'] = "Invalid file type. Only JPG, PNG, GIF allowed.";
                $this->redirect('index.php?url=student/profile');
                return;
            }
        }

        (new User())->updateProfile($user_id, $name, $phone, $program, $pic);
        $_SESSION['success'] = "Profile updated successfully";
        $this->redirect('index.php?url=student/profile');
    }

    public function changePassword()
    {
        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $user = (new User())->find($_SESSION['user_id']);

        if (password_verify($old, $user['password_hash'])) {
            $newHash = password_hash($new, PASSWORD_DEFAULT);
            (new User())->changePassword($_SESSION['user_id'], $newHash);
            $_SESSION['success'] = "Password changed successfully";
        } else {
            $_SESSION['error'] = "Old password is incorrect";
        }
        $this->redirect('index.php?url=student/profile');
    }
}

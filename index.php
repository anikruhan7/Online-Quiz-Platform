<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$timeout = 120;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: index.php?url=login&timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();

require_once 'core/Router.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';

$router = new Router();
$url = $_GET['url'] ?? '';

$router->add('GET', 'login', 'AuthController@loginForm');
$router->add('POST', 'login', 'AuthController@login');
$router->add('GET', 'register', 'AuthController@registerForm');
$router->add('POST', 'register', 'AuthController@register');
$router->add('GET', 'logout', 'AuthController@logout');

$router->add('GET', 'student/dashboard', 'StudentController@dashboard');
$router->add('GET', 'student/courses', 'StudentController@browseCourses');
$router->add('POST', 'student/enroll', 'StudentController@enroll');
$router->add('GET', 'student/enrolled', 'StudentController@enrolledCourses');
$router->add('GET', 'student/course/{id}', 'StudentController@courseDetail');
$router->add('GET', 'student/quiz/take/{id}', 'StudentController@takeQuiz');
$router->add('POST', 'student/quiz/submit', 'StudentController@submitQuiz');
$router->add('GET', 'student/quiz/result/{attempt_id}', 'StudentController@quizResult');
$router->add('GET', 'student/attempts', 'StudentController@attemptHistory');
$router->add('GET', 'student/leaderboard', 'StudentController@leaderboard');
$router->add('GET', 'student/performance', 'StudentController@performance');
$router->add('GET', 'student/qa/{course_id}', 'StudentController@qaBoard');
$router->add('POST', 'student/qa/post', 'StudentController@postQuestion');
$router->add('POST', 'student/qa/resolve', 'StudentController@resolveQuestion');
$router->add('GET', 'student/doubt-sessions', 'StudentController@doubtSessions');
$router->add('POST', 'student/doubt-book', 'StudentController@bookDoubtSession');
$router->add('POST', 'student/drop-course', 'StudentController@dropCourse');
$router->add('GET', 'student/profile', 'StudentController@profile');
$router->add('POST', 'student/profile/update', 'StudentController@updateProfile');
$router->add('POST', 'student/change-password', 'StudentController@changePassword');

$router->add('GET', 'instructor/dashboard', 'InstructorController@dashboard');
$router->add('GET', 'instructor/create-course', 'InstructorController@createCourse');
$router->add('POST', 'instructor/store-course', 'InstructorController@storeCourse');
$router->add('GET', 'instructor/my-courses', 'InstructorController@myCourses');
$router->add('GET', 'instructor/create-quiz', 'InstructorController@createQuiz');
$router->add('POST', 'instructor/store-quiz', 'InstructorController@storeQuiz');
$router->add('GET', 'instructor/quiz-analytics', 'InstructorController@quizAnalytics');
$router->add('GET', 'instructor/doubt-sessions', 'InstructorController@doubtSessions');
$router->add('GET', 'instructor/profile', 'InstructorController@profile');
$router->add('POST', 'instructor/update-profile', 'InstructorController@updateProfile');

$router->add('GET', 'ta/dashboard', 'TaController@dashboard');
$router->add('GET', 'ta/assigned-courses', 'TaController@assignedCourses');
$router->add('GET', 'ta/practice-quizzes', 'TaController@practiceQuizzes');
$router->add('POST', 'ta/create-practice-quiz', 'TaController@createPracticeQuiz');
$router->add('GET', 'ta/at-risk-students', 'TaController@atRiskStudents');
$router->add('GET', 'ta/doubt-sessions', 'TaController@doubtSessions');
$router->add('POST', 'ta/create-doubt-session', 'TaController@createDoubtSession');
$router->add('GET', 'ta/qa-board', 'TaController@qaBoard');
$router->add('POST', 'ta/qa-answer', 'TaController@qaAnswer');
$router->add('POST', 'ta/endorse-answer', 'TaController@endorseAnswer');
$router->add('GET', 'ta/profile', 'TaController@profile');
$router->add('POST', 'ta/update-profile', 'TaController@updateProfile');

$router->add('GET', 'admin/dashboard', 'AdminController@dashboard');
$router->add('GET', 'admin/manage-users', 'AdminController@manageUsers');
$router->add('POST', 'admin/update-user', 'AdminController@updateUser');
$router->add('GET', 'admin/courses', 'AdminController@courses');
$router->add('GET', 'admin/subjects', 'AdminController@subjects');
$router->add('POST', 'admin/add-subject', 'AdminController@addSubject');
$router->add('POST', 'admin/edit-subject', 'AdminController@editSubject');
$router->add('POST', 'admin/delete-subject', 'AdminController@deleteSubject');
$router->add('GET', 'admin/quizzes', 'AdminController@quizzes');
$router->add('GET', 'admin/reports', 'AdminController@reports');
$router->add('GET', 'admin/settings', 'AdminController@settings');
$router->add('POST', 'admin/update-settings', 'AdminController@updateSettings');
$router->add('GET', 'admin/profile', 'AdminController@profile');
$router->add('POST', 'admin/update-profile', 'AdminController@updateProfile');

$router->add('GET', 'api/leaderboard', 'ApiController@leaderboard');
$router->add('POST', 'api/check-email', 'ApiController@checkEmail');
$router->add('GET', 'api/check-login', 'ApiController@checkLogin');

$router->add('GET', 'unauthorized', function () {
    require_once 'views/unauthorized.php';
});

$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($method, $url);

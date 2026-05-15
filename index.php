<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
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

$router->add('GET', 'api/leaderboard', 'ApiController@leaderboard');
$router->add('POST', 'api/check-email', 'ApiController@checkEmail');

$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($method, $url);

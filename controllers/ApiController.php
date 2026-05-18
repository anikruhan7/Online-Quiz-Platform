<?php
require_once 'models/Attempt.php';
require_once 'models/User.php';

class ApiController extends Controller
{
    public function leaderboard()
    {
        $quiz_id = $_GET['quiz_id'] ?? 0;
        $data = (new Attempt())->getLeaderboard($quiz_id);
        $this->json($data);
    }

    public function checkEmail()
    {
        $email = $_POST['email'] ?? '';
        $exists = (new User())->findByEmail($email) ? true : false;
        $this->json(['exists' => $exists]);
    }

    public function checkLogin()
    {
<<<<<<< HEAD
        $this->json(['loggedIn' => isset($_SESSION['user_id'])]);
=======
        $loggedIn = isset($_SESSION['user_id']);
        $this->json(['loggedIn' => $loggedIn]);
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    }
}

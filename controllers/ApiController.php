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
        $loggedIn = isset($_SESSION['user_id']);
        $this->json(['loggedIn' => $loggedIn]);
    }
}

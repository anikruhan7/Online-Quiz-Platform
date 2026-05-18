<?php
class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        require_once "views/partials/header.php";
        require_once "views/$view.php";
        require_once "views/partials/footer.php";
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) $this->redirect('index.php?url=login');
    }

    protected function requireRole($role)
    {
        $this->requireLogin();
        if ($_SESSION['role'] !== $role) $this->redirect('index.php?url=unauthorized');
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

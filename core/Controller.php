<?php
class Controller
{
    /**
     * Load a view file with optional data
     */
    protected function view($view, $data = [])
    {
        extract($data);
        require_once "views/partials/header.php";
        require_once "views/$view.php";
        require_once "views/partials/footer.php";
    }

    /**
     * Redirect to a URL
     */
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Require login, redirect to login page if not
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?url=login');
        }
    }

    /**
     * Require a specific role (e.g., 'student', 'instructor', 'admin')
     */
    protected function requireRole($role)
    {
        $this->requireLogin();
        if ($_SESSION['role'] !== $role) {
            $this->redirect('index.php?url=login');
        }
    }

    /**
     * Send JSON response and terminate script
     */
    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

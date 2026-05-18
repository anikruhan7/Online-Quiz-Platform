<?php
class Controller
{
<<<<<<< HEAD
=======
    /**
     * Load a view file with optional data
     */
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    protected function view($view, $data = [])
    {
        extract($data);
        require_once "views/partials/header.php";
        require_once "views/$view.php";
        require_once "views/partials/footer.php";
    }

<<<<<<< HEAD
=======
    /**
     * Redirect to a URL
     */
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

<<<<<<< HEAD
=======
    /**
     * Check if user is logged in
     */
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

<<<<<<< HEAD
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) $this->redirect('index.php?url=login');
    }

    protected function requireRole($role)
    {
        $this->requireLogin();
        if ($_SESSION['role'] !== $role) $this->redirect('index.php?url=unauthorized');
    }

=======
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
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

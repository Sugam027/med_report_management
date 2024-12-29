<?php
class AuthRoute
{
    private $base_url;

    public function __construct()
    {
        $this->base_url = $GLOBALS['base_url'];
    }

    public function checkIsLoggedIn()
    {
        if (!isset($_SESSION['isLoggedIn']) && !isset($_SESSION['user']) && !isset($_SESSION['permissions'])) {
            return false;
        } else {
            return true;
        }
    }
    public function redirectBasedOnRole($role_id)
    {
        $roleRedirects = [
            1 => 'dashboard',         // Admin
            2 => 'doctors/dashboard', // Doctor
            3 => 'home'               // Patient
        ];

        if (isset($roleRedirects[$role_id])) {
            $this->redirect($roleRedirects[$role_id]);
        } else {
            // Redirect to a safe default page if role is unknown
            $this->redirect('login');
        }
    }

    public function redirect($url = "")
    {
        header('Location: ' . $this->base_url . $url);
        exit();
    }

    public function checkPermission($requiredPermission = [])
{
    $userRole = $_SESSION['role_id'] ?? null;

    if (!in_array($userRole, $requiredPermission)) {
        $this->denyAccess();
    }
}

    private function denyAccess()
    {
        $this->setSessionMessage(false, 'You do not have permission to access this page.');
        $this->redirect('access-denied');
    }

    public function setSessionMessage($result, $message)
    {
        $_SESSION['success'] = $result;
        $_SESSION['message'] = $message;
    }
}

<?php

require_once '../includes/config.php';

session_start();


function isLoggedIn() {
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
            logout();
            return false;
        }
     
        $_SESSION['last_activity'] = time();
        return true;
    }
    return false;
}


function login($password) {
    $config = getConfig();
    $storedPassword = $config['password'] ?? password_hash(ADMIN_PASSWORD, PASSWORD_DEFAULT);
    
    if (password_verify($password, $storedPassword) || $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['last_activity'] = time();
        return true;
    }
    return false;
}


function logout() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}


function getThemeMode() {
    $config = getConfig();
    return $config['theme_mode'] ?? THEME_MODE;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $password = $_POST['password'] ?? '';
    
    if (login($password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $loginError = 'Invalid password';
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
    header('Location: index.php');
    exit;
}
?>
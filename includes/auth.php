<?php
session_start();

// Session timeout (30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
}
$_SESSION['last_activity'] = time();

// Redirect to login if not authenticated
function require_auth() {
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header('Location: ' . BASE_URL . 'login.php');
        exit();
    }
}

// Redirect to dashboard if already authenticated
function redirect_if_authenticated() {
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
        if ($_SESSION['role'] === 'admin') {
            header('Location: ' . ADMIN_URL . 'dashboard.php');
        } else {
            header('Location: ' . USER_URL . 'index.php');
        }
        exit();
    }
}

// Check for specific role access
function require_role($required_role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
        header('Location: ' . BASE_URL . '403.php');
        exit();
    }
}

// Password hashing
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// CSRF protection
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Flash messages
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : '';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}

function isAuthenticated() {
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
}

function requireAuth() {    
    if (!isAuthenticated()) {        
        header('Location: ' . BASE_URL . 'index.php');        
        exit;            
        }
        }?>
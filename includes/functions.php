<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';

// Database helper functions
function query($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function fetch_all($sql, $params = []) {
    return query($sql, $params)->fetchAll();
}

function fetch_one($sql, $params = []) {
    return query($sql, $params)->fetch();
}

// Form validation
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// File upload handling
function upload_image($file, $target_dir = '../assets/images/') {
    $target_file = $target_dir . basename($file['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    $check = getimagesize($file['tmp_name']);
    if($check === false) {
        return ['success' => false, 'message' => 'File is not an image.'];
    }

    // Check file size (5MB max)
    if ($file['size'] > 5000000) {
        return ['success' => false, 'message' => 'File is too large.'];
    }

    // Allow certain file formats
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if(!in_array($imageFileType, $allowed_types)) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
    }

    // Generate unique filename
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_path = $target_dir . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['success' => true, 'path' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Error uploading file.'];
    }
}

// Date formatting
function format_date($date, $format = 'Y-m-d H:i:s') {
    $date = new DateTime($date);
    return $date->format($format);
}

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit();
}

// Error handling
function handle_error($message, $code = 400) {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit();
}
?>
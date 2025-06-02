<?php
session_start();

// Base URL Configuration
define('BASE_URL', 'http://localhost:8000/');

// Include database connection
require_once 'database.php';

// Helper Functions
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function toNullIfEmpty($value) {
    return trim($value) === '' ? null : $value;
}
?>
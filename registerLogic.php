<?php
require_once 'classes/Database.php';
require_once 'classes/User.php';

session_start(); // Required for setting alert in session if not already started

$conn = Database::getConnection();
$user = new User($conn);

$success = $user->register(
    $_POST['first_name'],
    $_POST['email'],
    $_POST['password'],
    $_POST['password_confirm']
);

if ($success) {
    User::alert('success', 'Account created successfully');
} 

header('Location: index.php');
exit;

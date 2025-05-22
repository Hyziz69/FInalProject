<?php
require_once 'classes/Database.php';
require_once 'classes/User.php';

session_start(); // Still needed here unless it's guaranteed to be called elsewhere

$email = trim($_POST['email']);
$password = $_POST['password'];

$conn = Database::getConnection();
$user = new User($conn);

if ($user->login($email, $password)) {
    User::alert('success', 'Logged in successfully');
} else {
    User::alert('danger', 'Invalid email or password');
}

header('Location: index.php');
exit;

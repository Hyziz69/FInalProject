<?php
require_once 'classes/Database.php';
require_once 'tools/functions.php';
require_once 'classes/User.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Create a Database object and pass it to User
$database = new Database();
$user = new User($database);

if ($user->login($email, $password)) {
    alert('success', 'Logged in successfully');
} else {
    alert('danger', 'Invalid email or password');
}

header('Location: index.php');

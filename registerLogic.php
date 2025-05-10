<?php
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'tools/functions.php';

$database = new Database();
$user = new User($database);

$success = $user->register($_POST['first_name'], $_POST['email'], $_POST['password'], $_POST['password_confirm']);

if ($success) {
    alert('success', 'Account created successfully');
    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}

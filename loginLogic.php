<?php

require_once 'tools/functions.php';

$email = trim($_POST['email']);
$password = $_POST['password'];


if(login_user($email, $password)){
    header('Location: index.php');
    die();
} else {
    alert('danger', 'Invalid email or password');
    header('Location: index.php');
    die();
}
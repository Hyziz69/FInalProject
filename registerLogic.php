<?php 

require_once 'tools/functions.php';

$first_name = trim($_POST['first_name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);




if($first_name == '' || $email == '' || $password == '' || $password_confirm == ''){
    alert('danger', 'All fields are required');
    die();
}

if($password != $password_confirm){
    alert('danger', 'Passwords do not match');
    die();
}

if(strlen($password) < 6){
    alert('danger', 'Password must be at least 6 characters');
    die();
}


$sql = "SELECT * FROM users WHERE email = '$email'";
$res = $conn->query($sql);

if($res->num_rows > 0){
    alert('danger', 'Account with this email already exists');
    die();
}

$password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (first_name, email, password) VALUES ('$first_name', '$email', '$password')";
if($conn->query($sql)){
    login_user($email, $password);
    alert('success', 'Account created successfully');
    header('Location: index.php');
    die();
} else {
    alert('danger', 'Failed to create account');
    header('Location: index.php');
    die();
}

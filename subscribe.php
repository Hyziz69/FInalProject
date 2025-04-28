<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
}

if(!$email){
    echo "Invalid email address";
    exit;
}

$to = $email;
$subject = "Thank you for subscribing!";
$message = "Thank you for subscribing to our newsletter! We will keep you updated with the latest news and offers.";
$headers = "From: kairashop@gmail.com";

if(mail($to, $subject, $message, $headers)){
    echo "Subscription successful! A confirmation email has been sent to $email.";
    header('Location: index.php');
} else {
    echo "Failed to send confirmation email. Please try again later.";
}
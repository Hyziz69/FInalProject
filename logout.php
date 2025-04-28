<?php
session_start();

// Destroy the session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login or homepage
header("Location: index.php");
exit;
?>
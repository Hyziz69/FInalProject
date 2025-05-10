<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', 'http://localhost/FinalProject2');

function url(string $path = "/"): string {
    return BASE_URL . $path;
}

function alert(string $type, string $message): void {
    $_SESSION['alert'] = [
        'type' => $type,
        'message' => $message
    ];
}

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

<?php
class User {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function register($firstName, $email, $password, $passwordConfirm) {
        if ($this->hasEmptyFields([$firstName, $email, $password, $passwordConfirm])) {
            alert('danger', 'All fields are required');
            return false;
        }

        if (!$this->isPasswordValid($password, $passwordConfirm)) {
            return false;
        }

        if ($this->emailExists($email)) {
            alert('danger', 'Account with this email already exists');
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $firstName, $email, $passwordHash);

        if ($stmt->execute()) {
            return true;
        } else {
            alert('danger', 'Failed to create account');
            return false;
        }
    }

    public function login($email, $password) {
        $user = $this->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user'] = $user;
        return true;
    }

    // ---------------- Private methods ----------------

    private function hasEmptyFields(array $fields) {
        foreach ($fields as $field) {
            if (empty(trim($field))) {
                return true;
            }
        }
        return false;
    }

    private function isPasswordValid($password, $confirm) {
        if ($password !== $confirm) {
            alert('danger', 'Passwords do not match');
            return false;
        }

        if (strlen($password) < 6) {
            alert('danger', 'Password must be at least 6 characters');
            return false;
        }

        return true;
    }

    private function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    private function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

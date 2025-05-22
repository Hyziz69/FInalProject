<?php
class Database {
    private static $conn;

    public static function getConnection(): mysqli {
        if (!self::$conn) {
            self::$conn = new mysqli("localhost", "root", "", "finalprojectdb");

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }

        return self::$conn;
    }
}

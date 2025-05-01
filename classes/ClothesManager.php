<?php

require_once 'Clothes.php';
require_once 'tools/functions.php';

class ClothesManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllClothes() {
        $clothes = [];
        $result = $this->conn->query("SELECT * FROM clothes");

        while ($row = $result->fetch_assoc()) {
            $clothes[] = new Clothes(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['image_url']
            );
        }

        return $clothes;
    }

    public function getClothesById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM clothes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        return new Clothes($row['id'], $row['name'], $row['description'], $row['price'], $row['image_url']);
    }

    public function getClothesByType($type) {
        $stmt = $this->conn->prepare("SELECT * FROM clothes WHERE type = ?");
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $res = $stmt->get_result();

        $clothes = [];
        while ($row = $res->fetch_assoc()) {
            $clothes[] = new Clothes($row['id'], $row['name'], $row['description'], $row['price'], $row['image_url']);
        }

        return $clothes;
    }

    public function getClothesByGender($gender) {
    $stmt = $this->conn->prepare("SELECT * FROM clothes WHERE gender = ?");
    $stmt->execute([$gender]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

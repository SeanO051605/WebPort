<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}
?>

<?php

class Inventory {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createItem($data) {
        $stmt = $this->pdo->prepare("INSERT INTO inventory (name, quantity, price) VALUES (:name, :quantity, :price)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':price', $data['price']);
        return $stmt->execute();
    }

    public function readItems() {
        $stmt = $this->pdo->query("SELECT * FROM inventory");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateItem($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE inventory SET name = :name, quantity = :quantity, price = :price WHERE id = :id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteItem($id) {
        $stmt = $this->pdo->prepare("DELETE FROM inventory WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM inventory");
        return $stmt->fetchAll();
    }
}
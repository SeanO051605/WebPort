<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Inventory.php';

class InventoryController {
    private $inventory;

    public function __construct($pdo) {
        $this->inventory = new Inventory($pdo);
    }

    public function list() {
        $items = $this->inventory->readItems();
        $view = __DIR__ . '/../views/inventory/list.php';
        include __DIR__ . '/../views/layout.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->inventory->update(
                $_POST['id'],
                $_POST['name'],
                $_POST['quantity'],
                $_POST['description']
            );
            header('Location: /?action=list');
            exit;
        }
        $item = $this->inventory->getById($id);
        $view = __DIR__ . '/../views/inventory/edit.php';
        include __DIR__ . '/../views/layout.php';
    }
}
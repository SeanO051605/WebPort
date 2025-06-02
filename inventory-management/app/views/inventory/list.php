<?php
// This file displays a list of inventory items.

require_once 'app/controllers/InventoryController.php';
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

$inventoryController = new InventoryController();
$items = $inventoryController->listItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory List</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <h2>Inventory List</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id']) ?></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
                <td>
                    <a href="/?action=edit&id=<?= $item['id'] ?>">Edit</a>
                    <a href="/?action=delete&id=<?= $item['id'] ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="edit.php">Add New Item</a>
    </div>
</body>
</html>
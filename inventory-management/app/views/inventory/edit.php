<?php
// This file provides a form for editing an inventory item.

require_once '../../models/Inventory.php';

$inventoryModel = new Inventory();
$itemId = $_GET['id'] ?? null;
$item = $itemId ? $inventoryModel->readItem($itemId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedItem = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price']
    ];
    $inventoryModel->updateItem($updatedItem);
    header('Location: /inventory-management/public/index.php?action=list');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventory-management/public/assets/css/style.css">
    <title>Edit Inventory Item</title>
</head>
<body>
    <div class="container">
        <h2>Edit Inventory Item</h2>
        <?php if ($item): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
            <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>"></label><br>
            <label>Quantity: <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>"></label><br>
            <label>Description: <textarea name="description"><?= htmlspecialchars($item['description']) ?></textarea></label><br>
            <button type="submit">Save</button>
        </form>
        <?php else: ?>
        <p>Item not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
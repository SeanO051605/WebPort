<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "inventory_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle Add
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO inventory (name, description, quantity, remarks) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $_POST['name'], $_POST['description'], $_POST['quantity'], $_POST['remarks']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $ids = explode(',', $_GET['delete']);
    $ids = array_map('intval', $ids);
    $ids_str = implode(',', $ids);
    $conn->query("DELETE FROM inventory WHERE id IN ($ids_str)");

    // Check if table is empty and reset AUTO_INCREMENT
    $check = $conn->query("SELECT COUNT(*) as cnt FROM inventory");
    $row = $check->fetch_assoc();
    if ($row['cnt'] == 0) {
        $conn->query("ALTER TABLE inventory AUTO_INCREMENT = 1");
    }

    header("Location: index.php");
    exit;
}

// Handle Edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM inventory WHERE id=$id");
    $edit = $res->fetch_assoc();
}

// Handle Update
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE inventory SET name=?, description=?, quantity=?, remarks=? WHERE id=?");
    $stmt->bind_param("ssisi", $_POST['name'], $_POST['description'], $_POST['quantity'], $_POST['remarks'], $_POST['id']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Fetch all items or search
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = $conn->real_escape_string($_GET['search']);
    $result = $conn->query("SELECT * FROM inventory WHERE name LIKE '%$search%' ORDER BY id DESC");
} else {
    $result = $conn->query("SELECT * FROM inventory ORDER BY id ASC");
}

// Bulk Edit Handling
$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];
$ids = array_map('intval', $ids);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_all'])) {
    foreach ($_POST['id'] as $i => $id) {
        $name = $_POST['name'][$i];
        $description = $_POST['description'][$i];
        $quantity = $_POST['quantity'][$i];
        $remarks = $_POST['remarks'][$i];
        $stmt = $conn->prepare("UPDATE inventory SET name=?, description=?, quantity=?, remarks=? WHERE id=?");
        $stmt->bind_param("ssisi", $name, $description, $quantity, $remarks, $id);
        $stmt->execute();
    }
    header("Location: index.php");
    exit;
}

$items = [];
if ($ids) {
    $ids_str = implode(',', $ids);
    $result_bulk = $conn->query("SELECT * FROM inventory WHERE id IN ($ids_str)");
    while ($row = $result_bulk->fetch_assoc()) {
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Inventory</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn cancel-btn" style="float:right;">Logout</a>
        <h2>Chapel Inventory</h2>

        <!-- Search Form -->
        <form method="get" autocomplete="off" style="margin-bottom:20px; display:flex; gap:10px; justify-content:center;">
            <input type="text" name="search" placeholder="Search item name..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Search</button>
            <?php if (isset($_GET['search']) && $_GET['search'] !== ''): ?>
                <a href="index.php" class="cancel-link">Clear</a>
            <?php endif; ?>
        </form>

        <!-- Add/Edit Form -->
        <form method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
            <input type="text" name="name" placeholder="Item Name" required value="<?= $edit['name'] ?? '' ?>">
            <input type="text" name="description" placeholder="Description" required value="<?= $edit['description'] ?? '' ?>">
            <input type="number" name="quantity" placeholder="Quantity" required value="<?= $edit['quantity'] ?? '' ?>">
            <input type="text" name="remarks" placeholder="Remarks" required value="<?= $edit['remarks'] ?? '' ?>">
            <?php if ($edit): ?>
                <button type="submit" name="update">Update</button>
                <a href="index.php" class="btn cancel-btn">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add">Add</button>
            <?php endif; ?>
        </form>

        <!-- Inventory Table -->
        <?php if (!$items): ?>
            <!-- Actions above the table -->
            <div style="margin-bottom:16px;">
                <button type="button" class="btn edit-btn" id="edit-selected">Edit Selected</button>
                <button type="button" class="btn delete-btn" id="delete-selected">Delete Selected</button>
            </div>

            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th><th>Name</th><th>Description</th><th>Quantity</th><th>Remarks</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="checkbox" class="row-checkbox" value="<?= $row['id'] ?>"></td>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= htmlspecialchars($row['remarks']) ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>

        <!-- Bulk Edit Section -->
        <?php if ($items): ?>
        <div class="bulk-edit-section" style="margin-top:32px; padding:16px; border:1px solid #ccc;">
            <h3>Bulk Edit Selected Items</h3>
            <form method="post">
                <?php foreach ($items as $item): ?>
                    <div style="margin-bottom:18px; border-bottom:1px solid #b2dfb2; padding-bottom:12px;">
                        <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                        <strong>ID #<?= $item['id'] ?></strong><br>
                        <input type="text" name="name[]" value="<?= htmlspecialchars($item['name']) ?>" required>
                        <input type="text" name="description[]" value="<?= htmlspecialchars($item['description']) ?>" required>
                        <input type="number" name="quantity[]" value="<?= $item['quantity'] ?>" required>
                        <input type="text" name="remarks[]" value="<?= htmlspecialchars($item['remarks']) ?>" required>
                    </div>
                <?php endforeach; ?>
                <button type="submit" name="update_all" class="btn edit-btn">Update All</button>
                <a href="index.php" class="btn cancel-btn">Cancel</a>
            </form>
        </div>
        <?php endif; ?>

        
    </div>
    <footer>
        &copy; <?= date("Y") ?> Chapel Inventory Management 
    </footer>
    <script src="assets/js/main.js"></script>
</body>
</html>
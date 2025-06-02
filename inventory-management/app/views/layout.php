
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Inventory Management System</h1>
        <nav>
            <ul>
                <li><a href="/?action=list">Inventory List</a></li>
                <li><a href="/?action=edit">Edit Inventory</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php include($view); ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Inventory Management System</p>
    </footer>
    <script src="/assets/js/main.js"></script>
</body>
</html>

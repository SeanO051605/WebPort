# Inventory Management System

This is a simple inventory management system built using PHP and SQL, following the MVC (Model-View-Controller) architecture. The application allows users to manage inventory items, including creating, reading, updating, and deleting items.

## Project Structure

```
inventory-management
├── app
│   ├── controllers
│   │   └── InventoryController.php
│   ├── models
│   │   └── Inventory.php
│   └── views
│       ├── inventory
│       │   ├── list.php
│       │   └── edit.php
│       └── layout.php
├── config
│   └── database.php
├── public
│   ├── index.php
│   └── assets
│       ├── css
│       │   └── style.css
│       └── js
│           └── main.js
├── sql
│   └── schema.sql
└── README.md
```

## Setup Instructions

1. **Clone the repository**:
   ```
   git clone <repository-url>
   ```

2. **Navigate to the project directory**:
   ```
   cd inventory-management
   ```

3. **Set up the database**:
   - Create a MySQL database and import the `sql/schema.sql` file to set up the necessary tables.

4. **Configure the database connection**:
   - Open `config/database.php` and update the database connection parameters (host, username, password, database name) as per your setup.

5. **Run the application**:
   - Start a local server (e.g., using XAMPP, MAMP, or PHP's built-in server).
   - Access the application in your web browser at `http://localhost/inventory-management/public/index.php`.

## Usage Guidelines

- **List Inventory Items**: Navigate to the inventory list page to view all items.
- **Edit Inventory Items**: Click on an item to edit its details.
- **Add New Items**: Use the provided form to add new inventory items.
- **Delete Items**: Remove items from the inventory as needed.

## Contributing

Feel free to fork the repository and submit pull requests for any improvements or features you would like to add.

## License

This project is open-source and available under the MIT License.
<?php
session_start();
include('config.php'); // Include database connection

if (!isset($_SESSION['seller_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch seller's products
$seller_id = $_SESSION['seller_id'];
$sql = "SELECT * FROM products WHERE seller_id = :seller_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['seller_id' => $seller_id]);
$products = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = htmlspecialchars($_POST['name']);
    $price = floatval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);

    $sql = "INSERT INTO products (name, price, description, seller_id) VALUES (:name, :price, :description, :seller_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'seller_id' => $seller_id
    ]);
    header('Location: seller_dashboard.php'); // Redirect after adding
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
</head>
<body>
    <h1>Welcome, Seller</h1>

    <!-- Add Product Form -->
    <form method="POST">
        <h3>Add Product</h3>
        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" required><br>
        <label for="price">Price</label>
        <input type="number" id="price" name="price" required><br>
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea><br>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <!-- Display Products -->
    <h3>Your Products</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

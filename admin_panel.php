<?php
session_start();
include('config.php'); // Include database connection

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect non-admin users to login
    exit;
}

// Fetch all users
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();

// Fetch all orders
$sql_orders = "SELECT * FROM orders";
$stmt_orders = $pdo->query($sql_orders);
$orders = $stmt_orders->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>

    <h3>Manage Users</h3>
    <table>
        <tr>
            <th>Username</th>
            <th>Role</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Manage Orders</h3>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Status</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

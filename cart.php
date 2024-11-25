<?php
session_start();
include('config.php');

// Add to Cart
if (isset($_POST['add_to_cart'])) {
    $_SESSION['cart'][] = $_POST['product_id'];
}

// Checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $address = htmlspecialchars($_POST['address']);
    if (empty($address)) {
        echo "Address is required.";
    } else {
        // Process payment and create order logic here
        echo "Order placed successfully!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>
    
    <h3>Cart Items</h3>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Action</th>
        </tr>
        <?php if (isset($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $product_id): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product_id); ?></td>
                    <td><a href="remove_from_cart.php?product_id=<?php echo $product_id; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="2">Your cart is empty.</td></tr>
        <?php endif; ?>
    </table>

    <form method="POST">
        <label for="address">Shipping Address:</label>
        <input type="text" id="address" name="address" required><br>
        <button type="submit" name="checkout">Checkout</button>
    </form>
</body>
</html>

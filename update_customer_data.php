<?php
session_start();
include('config.php');

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    
    // Validation (Basic)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        // Update customer data
        $sql = "UPDATE customers SET email = :email, phone = :phone, address = :address WHERE customer_id = :customer_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'customer_id' => $_SESSION['customer_id']
        ]);
        echo "Your details have been updated.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Customer Data</title>
</head>
<body>
    <h1>Update Your Information</h1>
    
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>
        
        <button type="submit">Update</button>
    </form>
</body>
</html>

<?php
include("dbconnection.php");
session_start();

if (!isset($_SESSION['seller_logged_in'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $price = (float)trim($_POST['price']);
    $category = htmlspecialchars(trim($_POST['category']));
    $image = $_FILES['image']['name'];

    // Validate inputs
    if (empty($name) || empty($price) || empty($category) || empty($image)) {
        echo "All fields are required!";
    } else {
        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert product data into the database
            $stmt = $conn->prepare("INSERT INTO products (name, price, category, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $name, $price, $category, $target_file);

            if ($stmt->execute()) {
                echo "Product added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Failed to upload image.";
        }
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name">
    <input type="number" step="0.01" name="price" placeholder="Price">
    <input type="text" name="category" placeholder="Category">
    <input type="file" name="image">
    <button type="submit">Add Product</button>
</form>

<?php
// Destroy session and log out the admin
session_start();
session_destroy();
header("Location: admin_login.php");  // Redirect to login page
exit();
?>

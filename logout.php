<?php
session_start();  // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page with a message
header("Location: login.php?message=logged_out");
exit();  // Ensure the script stops after the redirect
?>

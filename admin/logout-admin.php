<?php
require_once '../includes/functions.php';

// Set headers to prevent caching
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Only log out if it's the admin
if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@pawunion.com') {
    session_unset();      // Clear session variables
    session_destroy();    // Destroy session
}

// Redirect to login page
header("Location: ../auth/login.php");
exit();
?>
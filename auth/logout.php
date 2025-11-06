<?php
require_once '../includes/functions.php';

// Destroys the session
session_unset();    // optional: clear all session variables
session_destroy();  // destroy the session itself

// Redirects to login page
header("Location: login.php");
exit();
?>
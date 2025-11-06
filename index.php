<?php
require_once 'includes/functions.php';

// Redirects to login if not logged in or to home if logged in
if (isLoggedIn()) {
    header("Location: pages/home.php");
} else {
    header("Location: auth/login.php");
}
exit();
?>
<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

$error = "";

// Checks if user is already logged in
if (isLoggedIn()) {
    header("Location: ../pages/home.php");
    exit();
}

// Prevent caching to block back button access to previous sessions
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    // Hardcoded admin check
    if (strtolower($email) === 'admin@pawunion.com' && $password === '!Pawunion1993') {
        $_SESSION['user_id'] = 0; // Arbitrary ID for admin
        $_SESSION['user_email'] = $email;

        header("Location: ../admin/admin.php");
        exit();
    }

    // DB lookup for regular users
    $sql = "SELECT user_id, email, password_hash FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifies password
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, start a new session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: ../pages/home.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/pawunion-app/assets/images/logo/logo.ico" type="image/x-icon" />
    <title>Login - Paw Union</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="logo">
                <img src="../assets/images/logo/logo.png" alt="Paw Union Logo">
            </div>
            <h1>Welcome Back</h1>
            
            <?php if($error !== ""): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">Login</button>
            </form>
            
            <p class="auth-link">Don't have an account? <a href="signup.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
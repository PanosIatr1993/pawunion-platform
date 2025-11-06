<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

$error = "";
$success = "";

// Redirects if already logged in
if (isLoggedIn()) {
    header("Location: ../pages/home.php");
    exit();
}

// Initialize form values
$first_name = $last_name = $username = $email = $region = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $region = sanitize($_POST['region']); // region_name
    $phone = sanitize($_POST['phone']);

    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($region) || empty($phone)) {
        $error = "All fields are required.";
    } else if (!preg_match("/^[a-zA-Z\s]+$/", $first_name) || !preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $error = "Names can only contain letters and spaces.";
    } else if (!preg_match("/^\d{10}$/", $phone)) {
        $error = "Phone number must be exactly 10 digits.";
    } else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        $error = "Password must be at least 8 characters and include an uppercase letter, lowercase letter, number, and special character.";
    } else if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $check_sql = "SELECT user_id FROM users WHERE email = ? OR username = ? OR phone_number = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("sss", $email, $username, $phone);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error = "An account with this email, username, or phone already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_sql = "INSERT INTO users (first_name, last_name, username, email, password_hash, location_region, phone_number)
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sssssss", $first_name, $last_name, $username, $email, $hashed_password, $region, $phone);

            if ($insert_stmt->execute()) {
                $success = "Registration successful! You can now log in.";
                // Optionally clear form values
                $first_name = $last_name = $username = $email = $region = $phone = "";
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/pawunion-app/assets/images/logo/logo.ico" type="image/x-icon" />
    <title>Sign Up - Paw Union</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <div class="auth-box">
        <div class="logo">
            <img src="../assets/images/logo/logo.png" alt="Paw Union Logo">
        </div>
        <h1>Create an Account</h1>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required value="<?= htmlspecialchars($first_name) ?>">
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required value="<?= htmlspecialchars($last_name) ?>">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?= htmlspecialchars($username) ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">
            </div>

            <div class="form-group">
                <label for="region">Your Region</label>
                <select id="region" name="region" required>
                    <option value="">Select your region</option>
                    <?php
                        $region_sql = "SELECT region_id, region_name FROM regions ORDER BY region_name ASC";
                        $region_result = $conn->query($region_sql);
                        if ($region_result && $region_result->num_rows > 0) {
                            while ($row = $region_result->fetch_assoc()) {
                                $id = $row['region_id'];
                                $name = htmlspecialchars($row['region_name']);
                                $selected = ($region == $id) ? 'selected' : '';
                                echo "<option value=\"$id\" $selected>$name</option>";
                            }
                        } else {
                            echo '<option value="">Error loading regions</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required value="<?= htmlspecialchars($phone) ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn-primary">Register</button>
        </form>

        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>
</body>
</html>
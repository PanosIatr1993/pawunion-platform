<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    header("Location: ../auth/login.php");
    exit();
}

$message = '';
$error = '';

// Handle admin actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_pet']) && isset($_POST['pet_id'])) {
        $pet_id = intval($_POST['pet_id']);

        // Delete pet and related reports
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("DELETE FROM pet_reports WHERE pet_id = ?");
            $stmt->bind_param("i", $pet_id);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM pets WHERE pet_id = ?");
            $stmt->bind_param("i", $pet_id);
            $stmt->execute();

            $conn->commit();
            $message = "Pet post deleted successfully.";
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Failed to delete pet post: " . $e->getMessage();
        }
    } elseif (isset($_POST['delete_user']) && isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);

        if ($user_id == $_SESSION['user_id']) {
            $error = "You cannot delete your own admin account.";
        } else {
            $conn->begin_transaction();
            try {
                $stmt = $conn->prepare("SELECT pet_id FROM pets WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $stmt2 = $conn->prepare("DELETE FROM pet_reports WHERE pet_id = ?");
                    $stmt2->bind_param("i", $row['pet_id']);
                    $stmt2->execute();
                }

                $stmt = $conn->prepare("DELETE FROM pets WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();

                $conn->commit();
                $message = "User and all related data deleted.";
            } catch (Exception $e) {
                $conn->rollback();
                $error = "Failed to delete user: " . $e->getMessage();
            }
        }
    }
}

// Get all pets
$all_pets_sql = "SELECT p.pet_id, p.name, u.first_name AS owner_name, u.email AS owner_email 
                 FROM pets p 
                 JOIN users u ON p.user_id = u.user_id";
$all_pets = $conn->query($all_pets_sql);

// Get all non-admin users
$all_users_sql = "SELECT user_id, first_name, email, location_region,
                 (SELECT COUNT(*) FROM pets WHERE user_id = u.user_id) as post_count
                  FROM users u WHERE email != 'admin@pawunion.com'";
$all_users = $conn->query($all_users_sql);

include_once '../components/header.php';
?>

<header class="admin-header">
    <div class="logo">
        <a href="admin.php"><img src="../assets/images/logo/logo.png" alt="Paw Union Logo" onerror="this.src='/assets/images/logo/placeholder-logo.png'"></a>
    </div>
    <h1>Admin Panel</h1>
    <div class="admin-actions">
        <a href="logout-admin.php" class="btn-danger">Logout</a>
    </div>
</header>

<main class="admin-page">
    <?php if (!empty($message)): ?>
        <div class="success-message"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endif; ?>

    <div class="admin-tabs">
        <button class="tab-btn active" onclick="openTab(event, 'posts-tab')">Pet Posts</button>
        <button class="tab-btn" onclick="openTab(event, 'users-tab')">Users</button>
    </div>

    <div id="posts-tab" class="tab-content active">
        <h2 class="centrify">All Pet Posts</h2>
        <?php if ($all_pets->num_rows > 0): ?>
            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pet Name</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pet = $all_pets->fetch_assoc()): ?>
                            <tr>
                                <td><?= $pet['pet_id'] ?></td>
                                <td><?= htmlspecialchars_decode($pet['name']) ?></td>
                                <td><?= htmlspecialchars_decode($pet['owner_name']) ?></td>
                                <td><?= htmlspecialchars($pet['owner_email']) ?></td>
                                <td class="actions">
                                    <a href="pet-details-admin.php?id=<?= $pet['pet_id'] ?>" class="btn-view">View</a>
                                    <form action="" method="post" class="inline-form">
                                        <input type="hidden" name="pet_id" value="<?= $pet['pet_id'] ?>">
                                        <button type="submit" name="delete_pet" class="btn-danger" onclick="return confirm('Delete this pet post?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No pet posts found.</p>
        <?php endif; ?>
    </div>

    <div id="users-tab" class="tab-content">
        <h2 class="centrify">All Users</h2>
        <?php if ($all_users->num_rows > 0): ?>
            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Region</th>
                            <th>Posts</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $all_users->fetch_assoc()): ?>
                            <tr>
                                <td><?= $user['user_id'] ?></td>
                                <td><?= htmlspecialchars_decode($user['first_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['location_region']) ?></td>
                                <td><?= $user['post_count'] ?></td>
                                <td class="actions">
                                    <form action="" method="post" class="inline-form">
                                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                        <button type="submit" name="delete_user" class="btn-danger" onclick="return confirm('Delete this user and all their posts?')">Delete User</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    </div>
</main>

<script>
    function openTab(evt, tabName) {
        const tabs = document.querySelectorAll(".tab-content");
        tabs.forEach(t => t.classList.remove("active"));

        const buttons = document.querySelectorAll(".tab-btn");
        buttons.forEach(b => b.classList.remove("active"));

        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>

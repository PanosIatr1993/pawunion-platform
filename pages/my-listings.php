<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mark_found']) && isset($_POST['pet_id'])) {
        $pet_id = intval($_POST['pet_id']);

        // Update the latest lost report to resolved
        $update_sql = "
            UPDATE pet_reports 
            SET report_status = 'resolved', report_type = 'found' 
            WHERE pet_id = ? AND report_type = 'lost' AND report_status = 'active'
        ";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $pet_id);

        if ($stmt->execute()) {
            $message = "Pet marked as found! We're so happy your pet has been reunited with you.";
        } else {
            $error = "Failed to update report status: " . $conn->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete_post']) && isset($_POST['pet_id'])) {
        $pet_id = intval($_POST['pet_id']);

        // First delete reports associated with the pet
        $conn->query("DELETE FROM pet_reports WHERE pet_id = $pet_id");

        // Then delete the pet
        $delete_sql = "DELETE FROM pets WHERE pet_id = ? AND user_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("ii", $pet_id, $user_id);

        if ($stmt->execute()) {
            $message = "Pet post has been deleted.";
        } else {
            $error = "Failed to delete pet post: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch user's pet listings with their status
$sql = "
    SELECT p.pet_id, p.name, pt.type_name, pr.report_status
    FROM pets p
    JOIN pet_types pt ON p.type_id = pt.type_id
    JOIN pet_reports pr ON p.pet_id = pr.pet_id
    WHERE p.user_id = ? AND pr.report_type = 'lost'
    ORDER BY pr.report_id DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$posts = $stmt->get_result();

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="dashboard-page">
    <h1>My Listings</h1>

    <?php if (!empty($message)): ?>
        <div class="success-message"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endif; ?>

    <div class="dashboard-actions">
        <a href="report.php" class="btn-primary">Report a New Lost Pet</a>
    </div>

    <section class="my-listings">
        <h2>My Pet Listings</h2>

        <?php if ($posts->num_rows > 0): ?>
            <div class="listing-table">
                <table>
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = $posts->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars_decode($post['name']) ?></td>
                                <td><?= htmlspecialchars($post['type_name']) ?></td>
                                <td>
                                    <span class="status-indicator <?= htmlspecialchars($post['report_status']) ?>">
                                        <?= ucfirst($post['report_status']) ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="pet-details.php?id=<?= $post['pet_id'] ?>" class="btn-view">View</a>

                                    <?php if ($post['report_status'] === 'active'): ?>
                                        <form action="" method="post" class="inline-form">
                                            <input type="hidden" name="pet_id" value="<?= $post['pet_id'] ?>">
                                            <button type="submit" name="mark_found" class="btn-success" onclick="return confirm('Are you sure? This will mark your pet as found.')">Mark as Found</button>
                                        </form>
                                    <?php endif; ?>

                                    <form action="" method="post" class="inline-form">
                                        <input type="hidden" name="pet_id" value="<?= $post['pet_id'] ?>">
                                        <button type="submit" name="delete_post" class="btn-danger" onclick="return confirm('Are you sure you want to delete this listing? This cannot be undone.')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>You haven't created any lost pet reports yet.</p>
        <?php endif; ?>
    </section>
</main>

<?php include_once '../components/footer.php'; ?>
<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

// Ensure admin only
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@pawunion.com') {
    header("Location: ../auth/login.php");
    exit();
}

$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($pet_id <= 0) {
    header("Location: ../admin/admin.php");
    exit();
}

// Fetch pet + latest report
$query = "
    SELECT 
        p.pet_id, p.name, p.color, p.age,
        pt.type_name AS type,
        b.breed_name AS breed,
        u.first_name AS owner_name, u.email AS owner_email,
        r.report_type, r.report_status, r.region_last_seen,
        r.image_url, r.priority_level, r.priority_reason,
        r.emotional_note, r.emoticon,
        rg.region_name
    FROM pets p
    JOIN pet_reports r ON p.pet_id = r.pet_id
    JOIN users u ON p.user_id = u.user_id
    JOIN pet_types pt ON p.type_id = pt.type_id
    JOIN breeds b ON p.breed_id = b.breed_id
    JOIN regions rg ON r.region_last_seen = rg.region_id
    WHERE p.pet_id = ?
    ORDER BY r.report_id DESC
    LIMIT 1
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../admin/admin.php");
    exit();
}

$pet = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Details - Admin View</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <main class="pet-details-page">
        <div class="pet-details">
            <div class="pet-header">
                <a href="admin.php" class="btn-secondary">← Back to Admin Panel</a>
                <h1 id="tab-pet-name"><?= htmlspecialchars_decode($pet['name']) ?></h1>
                <span class="status-badge <?= htmlspecialchars($pet['report_status']) ?>">
                    <?= ucfirst($pet['report_status']) ?>
                </span>
                <?php if ($pet['priority_level']): ?>
                    <small>(<?= htmlspecialchars($pet['priority_reason']) ?>)</small>
                <?php endif; ?>
            </div>

            <div class="pet-content">
                <div class="pet-image-large">
                    <img src="<?= '../' . htmlspecialchars($pet['image_url']) ?>"
                        alt="<?= htmlspecialchars_decode($pet['name']) ?>"
                        onerror="this.src='../assets/images/pets/placeholder.png';">
                </div>

                <div class="pet-info-detailed">
                    <div class="info-section">
                        <h2>Pet Information</h2>
                        <ul>
                            <li><strong>Type:</strong> <?= htmlspecialchars($pet['type']) ?></li>
                            <li><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></li>
                            <li><strong>Color:</strong> <?= htmlspecialchars_decode($pet['color']) ?></li>
                            <li><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?> years</li>
                            <li><strong>Region:</strong> <?= htmlspecialchars($pet['region_name']) ?></li>
                            <li><strong><?= $pet['report_type'] === 'lost' ? 'Last Seen:' : 'Found At:' ?></strong>
                                <?= htmlspecialchars($pet['region_name']) ?></li>
                            <li><strong>Owner:</strong> <?= htmlspecialchars_decode($pet['owner_name']) ?> (<?= htmlspecialchars($pet['owner_email']) ?>)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
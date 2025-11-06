<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

// Get logged-in user ID
$user_id = $_SESSION['user_id'];

// Get user's region from users table
$region_query = "SELECT location_region FROM users WHERE user_id = ?";
$stmt = $conn->prepare($region_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$region_result = $stmt->get_result();
$region_data = $region_result->fetch_assoc();
$user_region = $region_data['location_region'] ?? null;
$stmt->close();

if (!$user_region) {
    die("Error: User region not found.");
}

// Get region name for display
$region_name = null;
$region_name_query = "SELECT region_name FROM regions WHERE region_id = ?";
$stmt = $conn->prepare($region_name_query);
$stmt->bind_param("i", $user_region);
$stmt->execute();
$region_name_result = $stmt->get_result();
if ($region_row = $region_name_result->fetch_assoc()) {
    $region_name = $region_row['region_name'];
}
$stmt->close();

// Get recent lost pet reports from user's region
$recent_lost_query = "
    SELECT pets.pet_id, pets.name, pets.color, pets.age,
           pet_reports.image_url AS report_image,
           pet_reports.region_last_seen, pet_reports.report_status,
           pet_reports.emotional_note
    FROM pets
    JOIN pet_reports ON pets.pet_id = pet_reports.pet_id
    WHERE pet_reports.report_type = 'lost'
      AND pet_reports.report_status = 'active'
      AND pet_reports.region_last_seen = ?
    ORDER BY pet_reports.report_id DESC
    LIMIT 5
";
$stmt = $conn->prepare($recent_lost_query);
$stmt->bind_param("s", $user_region);
$stmt->execute();
$recent_lost_pets = $stmt->get_result();
$stmt->close();

// Get rotating support message
$support_message = getSupportMessage();

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="home-page">
    <section class="hero">
        <h1>Welcome to Paw Union</h1>
        <p>Helping reunite lost pets with their families</p>
        <div class="hero-buttons">
            <a href="report.php" class="btn-primary">Report a Lost Pet</a>
            <a href="lost-pets.php" class="btn-secondary">Find Lost Pets</a>
        </div>
    </section>

    <section class="support-message">
        <div class="message-box">
            <h2>Support Message</h2>
            <p id="supportMessage"><?= htmlspecialchars($support_message) ?></p>
        </div>
    </section>

    <section class="recent-pets">
        <h2>Recently Lost Pets in Your Region: <?= htmlspecialchars($region_name) ?></h2>

        <?php if ($recent_lost_pets->num_rows > 0): ?>
            <div class="pet-grid">
                <?php while ($pet = $recent_lost_pets->fetch_assoc()): ?>
                    <div class="pet-card">
                        <div class="pet-image">
                            <img src="<?= '../' . htmlspecialchars($pet['report_image']) ?>"
                                alt="<?= htmlspecialchars_decode($pet['name']) ?>"
                                onerror="this.src='../assets/images/pets/placeholder.png';">
                        </div>
                        <div class="pet-info">
                            <h3>
                                <?= htmlspecialchars_decode($pet['name']) ?>
                                <?php if (!empty($pet['emoticon'])): ?>
                                    <span class="emoticon"><?= htmlspecialchars($pet['emoticon']) ?></span>
                                <?php endif; ?>
                            </h3>
                            <p><strong>Color:</strong> <?= htmlspecialchars_decode($pet['color']) ?></p>
                            <p><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?> years</p>
                            <p><strong>Region Last Seen:</strong> <?= htmlspecialchars($region_name) ?></p>
                            <?php if (!empty($pet['emotional_note'])): ?>
                                <p><em><?= htmlspecialchars_decode($pet['emotional_note']) ?></em></p>
                            <?php endif; ?>
                            <a href="pet-details.php?id=<?= $pet['pet_id'] ?>" class="btn-view">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No lost pets reported in your region at this time.</p>
        <?php endif; ?>

        <div class="view-all">
            <a href="lost-pets.php" class="btn-secondary">View All Lost Pets</a>
        </div>
    </section>
</main>

<?php include_once '../components/footer.php'; ?>

<script src="/assets/js/main.js"></script>
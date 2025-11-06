<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = '';
$error = '';

if ($pet_id <= 0) {
    header("Location: /pages/lost-pets.php");
    exit();
}

// Get pet and latest report details
$query = "
    SELECT 
        p.pet_id, p.name, p.color, p.age,
        pt.type_name AS type,
        b.breed_name AS breed,
        u.first_name AS owner_name, u.user_id,
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
    WHERE p.pet_id = ? AND r.report_status IN ('active', 'resolved')
    ORDER BY r.report_id DESC
    LIMIT 1
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: /pages/lost-pets.php");
    exit();
}

$pet = $result->fetch_assoc();

// Handle contact form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_owner'])) {
    $from_id = $_SESSION['user_id'];
    $to_id = $pet['user_id'];
    $subject = sanitize($_POST['subject']);
    $message_text = sanitize($_POST['message']);

    if (sendRelayEmail($from_id, $to_id, $subject, $message_text)) {
        $message = "Your message has been sent to the pet owner.";
    } else {
        $error = "This feature is currently under development.";
    }
}

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="pet-details-page">
    <div class="pet-details">
        <div class="pet-header">
            <h1 class="pet-name">
                <?= htmlspecialchars_decode($pet['name']) ?>

                <?php if (!empty($pet['emoticon']) && $pet['report_type'] === 'lost'): ?>
                    <span class="emoji"><?= htmlspecialchars($pet['emoticon']) ?></span>
                <?php endif; ?>
            </h1>

            <?php if ($pet['priority_level']): ?>
                <span class="priority-badge-2">High Priority</span>
            <?php endif; ?>

            <span class="status-badge <?= htmlspecialchars($pet['report_status']) ?>">
                <?= ucfirst($pet['report_status']) ?>
            </span>

            <?php if ($pet['priority_level']): ?>
                <small>(<?= htmlspecialchars($pet['priority_reason']) ?>)</small>
            <?php endif; ?>
        </div>


        <?php if (!empty($message)): ?>
            <div class="success-message"><?= $message ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

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
                    </ul>
                </div>

                <?php if (!empty($pet['emotional_note']) && $pet['report_type'] === 'lost'): ?>
                    <div class="info-section">
                        <h2>Emotional Note</h2>
                        <p><?= htmlspecialchars_decode($pet['emotional_note']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($pet['report_type'] === 'lost'): ?>
            <div class="contact-section">
                <h2>Contact Pet Owner</h2>
                <p>If you have any information about this pet, please use the form below to contact the owner.</p>

                <form action="" method="post" class="contact-form">
                    <div class="form-group">
                        <label for="subject">Subject*</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message*</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" name="contact_owner" class="btn-primary">Send Message</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include_once '../components/footer.php'; ?>
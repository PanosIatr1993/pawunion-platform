<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Get user's region
$region_query = "SELECT location_region FROM users WHERE user_id = ?";
$stmt = $conn->prepare($region_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_region = $result->fetch_assoc()['location_region'] ?? null;
$stmt->close();

// Fetch dropdown data
$types = $conn->query("SELECT type_id, type_name FROM pet_types ORDER BY type_name ASC");
$breeds_result = $conn->query("SELECT breed_id, breed_name, type_id FROM breeds ORDER BY breed_name ASC");
$breeds = [];
while ($row = $breeds_result->fetch_assoc()) {
    $breeds[] = $row;
}
$regions = $conn->query("SELECT region_id, region_name FROM regions ORDER BY region_name ASC");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = sanitize($_POST['pet_name']);
    $type_id = (int) $_POST['pet_type'];
    $breed_id = (int) $_POST['breed'];
    $color = sanitize($_POST['color']);
    $age = (int) $_POST['age'];
    $region_last_seen = (int) $_POST['last_seen'];
    $emotional_note = sanitize($_POST['description']);
    $emoticon = sanitize($_POST['emoticon'] ?? '');
    $priority_level = ($_POST['priority'] === 'yes') ? 1 : 0;
    $priority_reason = $priority_level ? sanitize($_POST['priority_reason']) : 'None';

    // Validate breed against selected type
    $breed_valid = false;
    foreach ($breeds as $b) {
        if ($b['breed_id'] == $breed_id && $b['type_id'] == $type_id) {
            $breed_valid = true;
            break;
        }
    }

    if (!$breed_valid) {
        $error = "Selected breed does not match the selected pet type.";
    }

    // Check for duplicate report
    if (empty($error)) {
        $check_sql = "
            SELECT pr.report_id 
            FROM pets p
            JOIN pet_reports pr ON p.pet_id = pr.pet_id
            WHERE p.user_id = ? AND p.name = ? AND p.type_id = ? 
              AND pr.report_type = 'lost' AND pr.report_status = 'active'
        ";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("isi", $user_id, $name, $type_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if ($check_result->num_rows > 0) {
            $error = "You've already submitted an active report for this pet.";
        }
        $check_stmt->close();
    }

    // Handle image upload
    if (empty($error)) {
        $image_url = '';
        if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/pets/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $file_name = time() . '_' . basename($_FILES['pet_image']['name']);
            $target_file = $upload_dir . $file_name;

            $check = getimagesize($_FILES['pet_image']['tmp_name']);
            if ($check && $_FILES['pet_image']['size'] <= 5000000) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['pet_image']['type'], $allowed)) {
                    if (move_uploaded_file($_FILES['pet_image']['tmp_name'], $target_file)) {
                        $image_url = '/assets/images/pets/' . $file_name;
                    } else $error = "Image upload failed.";
                } else $error = "Invalid image type.";
            } else $error = "Invalid or too large image.";
        } else {
            $error = "Image is required.";
        }
    }

    // Insert data
    if (empty($error)) {
        $pet_sql = "INSERT INTO pets (user_id, name, type_id, breed_id, color, age) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($pet_sql);
        $stmt->bind_param("isiisi", $user_id, $name, $type_id, $breed_id, $color, $age);
        $stmt->execute();
        $pet_id = $stmt->insert_id;
        $stmt->close();

        $report_sql = "
            INSERT INTO pet_reports 
            (pet_id, report_type, report_status, region_last_seen, 
             priority_level, priority_reason, image_url, emotional_note, emoticon)
            VALUES (?, 'lost', 'active', ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($report_sql);
        $stmt->bind_param("iiissss", $pet_id, $region_last_seen, $priority_level, $priority_reason, $image_url, $emotional_note, $emoticon);
        if ($stmt->execute()) {
            $message = "Report submitted successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="report-page">
    <h1 id="report-title">Report a Lost Pet</h1>

    <?php if ($message): ?><div class="success-message"><?= $message ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="report-form">
        <div class="form-group">
            <label for="pet_name">Pet Name*</label>
            <input type="text" id="pet_name" name="pet_name" required>
        </div>

        <div class="form-group">
            <label for="pet_type">Pet Type*</label>
            <select id="pet_type" name="pet_type" required>
                <option value="">Select Type</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['type_id'] ?>"><?= htmlspecialchars($type['type_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="breed">Breed*</label>
            <select id="breed" name="breed" required>
                <option value="">Select Breed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="age">Pet Age*</label>
            <input type="number" id="age" name="age" min="0" required>
        </div>

        <div class="form-group">
            <label for="color">Color*</label>
            <input type="text" id="color" name="color" required>
        </div>

        <div class="form-group">
            <label for="last_seen">Last Seen Region*</label>
            <select name="last_seen" id="last_seen" required>
                <option value="">Select Region</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['region_id'] ?>"><?= htmlspecialchars($region['region_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Emotional Note</label>
            <textarea id="description" name="description" rows="4" maxlength="150" placeholder="Add an emotional message (max 150 characters)"></textarea>
        </div>

        <div class="form-group">
            <label>High Priority?</label>
            <select id="priority" name="priority" required>
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
        </div>

        <div class="form-group" id="priority-reason-group" style="display:none;">
            <label for="priority_reason">Reason for Priority*</label>
            <select id="priority_reason" name="priority_reason">
                <option value="">Select Reason</option>
                <option value="Medical">Medical</option>
                <option value="Stolen">Stolen</option>
                <option value="Young">Young</option>
                <option value="Elderly">Elderly</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pet_image">Upload a Photo*</label>
            <input type="file" id="pet_image" name="pet_image" required>
            <p class="help-text">Max size: 5MB. JPG, PNG, GIF only.</p>
        </div>

        <div class="form-group">
            <label>Express Your Feelings (Optional)</label>
            <div class="emoticon-selector">
                <?php 
                $emoticons = ['😢', '😭', '🥺', '😟', '😰', '💔', '🙏', '🆘', '⚠️', '❤️'];
                foreach ($emoticons as $emo) {
                    echo "<button type='button' class='emoticon-btn' data-emoticon='$emo'>$emo</button>";
                }
                ?>
                <input type="hidden" name="emoticon" id="selected_emoticon">
            </div>
        </div>

        <button type="submit" class="btn-primary">Submit Report</button>
    </form>
</main>

<?php include_once '../components/footer.php'; ?>

<script>
    const breedSelect = document.getElementById('breed');
    const petTypeSelect = document.getElementById('pet_type');
    const prioritySelect = document.getElementById('priority');
    const priorityReasonGroup = document.getElementById('priority-reason-group');

    const breeds = <?= json_encode($breeds) ?>;

    function updateBreeds() {
        const selectedType = petTypeSelect.value;
        breedSelect.innerHTML = '<option value="">Select Breed</option>';
        breeds.filter(b => b.type_id == selectedType).forEach(b => {
            const option = document.createElement('option');
            option.value = b.breed_id;
            option.textContent = b.breed_name;
            breedSelect.appendChild(option);
        });
    }

    petTypeSelect.addEventListener('change', updateBreeds);
    prioritySelect.addEventListener('change', () => {
        priorityReasonGroup.style.display = prioritySelect.value === 'yes' ? 'block' : 'none';
    });

    document.querySelectorAll('.emoticon-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.emoticon-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('selected_emoticon').value = btn.dataset.emoticon;
        });
    });

    document.addEventListener('DOMContentLoaded', updateBreeds);
</script>
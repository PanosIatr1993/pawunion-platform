<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

$type_id = $_GET['pet_type'] ?? null;
$breed_id = $_GET['breed'] ?? null;
$region_id = $_GET['region'] ?? null;

// Pet types
$pet_types = $conn->query("SELECT type_id, type_name FROM pet_types ORDER BY type_name ASC");

// Breeds
$breeds = [];
$breeds_query = $conn->query("SELECT breed_id, breed_name, type_id FROM breeds ORDER BY breed_name ASC");
while ($row = $breeds_query->fetch_assoc()) {
    $breeds[] = $row;
}

// Regions
$regions = $conn->query("SELECT region_id, region_name FROM regions ORDER BY region_name ASC");

// Build query
$query = "
    SELECT pets.pet_id, pets.name, pets.color, pets.age,
           pet_reports.image_url AS report_image, pet_reports.report_id,
           pet_types.type_name AS type,
           breeds.breed_name AS breed,
           regions.region_name AS region_name
    FROM pets
    JOIN pet_reports ON pets.pet_id = pet_reports.pet_id
    JOIN pet_types ON pets.type_id = pet_types.type_id
    JOIN breeds ON pets.breed_id = breeds.breed_id
    JOIN regions ON pet_reports.region_last_seen = regions.region_id
    WHERE pet_reports.report_type = 'found'
      AND pet_reports.report_status = 'resolved'
";

$params = [];
$types = "";

if ($type_id) {
    $query .= " AND pets.type_id = ?";
    $params[] = $type_id;
    $types .= "i";
}
if ($breed_id) {
    $query .= " AND pets.breed_id = ?";
    $params[] = $breed_id;
    $types .= "i";
}
if ($region_id) {
    $query .= " AND pet_reports.region_last_seen = ?";
    $params[] = $region_id;
    $types .= "i";
}

$query .= " ORDER BY pet_reports.report_id DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$pets = $stmt->get_result();

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="found-pets-page">
    <h1>Found Pets</h1>
    <section class=".success-stories-message">
        <div class="message-box-2">
            <h2>Success Stories</h2>
            <p>These are success stories of pets that have been found and reunited with their families.</p>
        </div>
    </section>
    <section class="filters">
        <h2>Filter Results</h2>
        <form method="GET" action="found-pets.php" id="petFilterForm" class="filter-form">
            <div class="form-group">
                <label for="pet_type">Pet Type</label>
                <select name="pet_type" id="pet_type">
                    <option value="">Select Type</option>
                    <?php while ($type = $pet_types->fetch_assoc()): ?>
                        <option value="<?= $type['type_id'] ?>" <?= $type_id == $type['type_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type['type_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="breed">Breed</label>
                <select name="breed" id="breed">
                    <option value="">Select Breed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="region">Region</label>
                <select name="region" id="region">
                    <option value="">Select Region</option>
                    <?php while ($region = $regions->fetch_assoc()): ?>
                        <option value="<?= $region['region_id'] ?>" <?= $region_id == $region['region_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($region['region_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-primary">Apply</button>
                <button type="button" class="btn-secondary" onclick="window.location.href='found-pets.php'">Reset</button>
            </div>
        </form>
    </section>

    <section class="pet-listings">
        <?php if ($pets->num_rows > 0): ?>
            <div class="pet-grid">
                <?php while ($pet = $pets->fetch_assoc()): ?>
                    <div class="pet-card success">
                        <div class="success-badge">Success Story</div>
                        <div class="pet-image">
                            <img src="<?= '../' . htmlspecialchars($pet['report_image']) ?>"
                                 alt="<?= htmlspecialchars_decode($pet['name']) ?>"
                                 onerror="this.src='../assets/images/pets/placeholder.png';">
                        </div>
                        <div class="pet-info">
                            <h3><?= htmlspecialchars_decode($pet['name']) ?></h3>
                            <p><strong>Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
                            <p><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></p>
                            <p><strong>Found At:</strong> <?= htmlspecialchars($pet['region_name']) ?></p>
                            <a href="pet-details.php?id=<?= $pet['pet_id'] ?>" class="btn-view">View Story</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No found pets match your filters.</p>
        <?php endif; ?>
    </section>
</main>

<?php include_once '../components/footer.php'; ?>

<script>
    const breedSelect = document.getElementById('breed');
    const petTypeSelect = document.getElementById('pet_type');

    const allBreeds = <?= json_encode($breeds) ?>;
    const selectedBreed = <?= json_encode($breed_id) ?>;

    function updateBreeds() {
        const selectedType = petTypeSelect.value;
        breedSelect.innerHTML = '<option value="">Select Breed</option>';

        const filtered = allBreeds.filter(b => b.type_id == selectedType);

        filtered.forEach(breed => {
            const option = document.createElement('option');
            option.value = breed.breed_id;
            option.textContent = breed.breed_name;
            if (breed.breed_id == selectedBreed) option.selected = true;
            breedSelect.appendChild(option);
        });
    }

    petTypeSelect.addEventListener('change', updateBreeds);
    document.addEventListener('DOMContentLoaded', updateBreeds);
</script>
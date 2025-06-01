<?php
require_once '../../config/config.php';
require_once '../../config/database.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$database = new Database();
$db = $database->getConnection();

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('/cases/index.php'); // Ganti sesuai halaman index
}

$case_id = intval($_GET['id']);

// Ambil data berdasarkan ID
$query = "SELECT * FROM cases WHERE case_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$case_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    redirect('/cases/index.php'); // Jika data tidak ditemukan
}

// Variabel awal untuk form
$case_name = $data['case_name'];
$age_range = $data['age_range'];
$gender = $data['gender'];
$height_range = $data['height_range'];
$weight_range = $data['weight_range'];
$fitness_level = $data['fitness_level'];
$fitness_goal = $data['fitness_goal'];
$available_time_range = $data['available_time_range'];
$equipment_needed = $data['equipment_needed'];
$exercise_program = $data['exercise_program'];
$duration_weeks = $data['duration_weeks'];
$success_rate = $data['success_rate'];
$frequency = $data['frequency'];

// Saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case_name = sanitize($_POST['case_name']);
    $age_range = sanitize($_POST['age_range']);
    $gender = sanitize($_POST['gender']);
    $height_range = sanitize($_POST['height_range']);
    $weight_range = sanitize($_POST['weight_range']);
    $fitness_level = sanitize($_POST['fitness_level']);
    $fitness_goal = sanitize($_POST['fitness_goal']);
    $available_time_range = sanitize($_POST['available_time_range']);
    $equipment_needed = sanitize($_POST['equipment_needed']);
    $exercise_program = sanitize($_POST['exercise_program']);
    $duration_weeks = trim($_POST['duration_weeks']) === '' ? null : sanitize($_POST['duration_weeks']);
    $success_rate = sanitize($_POST['success_rate']);
    $frequency = sanitize($_POST['frequency']);

    try {
        $updateQuery = "UPDATE cases SET 
            case_name = ?, age_range = ?, gender = ?, height_range = ?, weight_range = ?,
            fitness_level = ?, fitness_goal = ?, available_time_range = ?, equipment_needed = ?,
            exercise_program = ?, duration_weeks = ?, success_rate = ?, frequency = ?
            WHERE case_id = ?";

        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->execute([
            $case_name,
            $age_range,
            $gender,
            $height_range,
            $weight_range,
            $fitness_level,
            $fitness_goal,
            $available_time_range,
            $equipment_needed,
            $exercise_program,
            $duration_weeks,
            $success_rate,
            $frequency,
            $case_id
        ]);

        $success_message = "Case berhasil diperbarui.";
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$page_title = 'Edit Case';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Edit Case</h2>

        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?= $error_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="case_name">Case Name</label>
                <input type="text" class="form-control" id="case_name" name="case_name" required value="<?= htmlspecialchars($data['case_name']) ?>" />
            </div>

            <div class="form-group">
                <label for="age_range">Age Range</label>
                <input type="text" class="form-control" id="age_range" name="age_range" value="<?= htmlspecialchars($data['age_range']) ?>" />
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="male" <?= $data['gender'] === 'male' ? 'selected' : '' ?>>Laki - Laki</option>
                    <option value="female" <?= $data['gender'] === 'female' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="height_range">Height Range</label>
                <select name="height_range" id="height_range" class="form-control" required>
                    <?php
                    $height_options = ["165-175", "175-185", "185-190"];
                    foreach ($height_options as $opt) {
                        echo '<option value="' . $opt . '" ' . ($data['height_range'] === $opt ? 'selected' : '') . '>' . $opt . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="weight_range">Weight Range</label>
                <select name="weight_range" id="weight_range" class="form-control" required>
                    <?php
                    $weight_options = ["50-70", "70-80", "80-100"];
                    foreach ($weight_options as $opt) {
                        echo '<option value="' . $opt . '" ' . ($data['weight_range'] === $opt ? 'selected' : '') . '>' . $opt . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fitness_level">Fitness Level</label>
                <input type="text" class="form-control" id="fitness_level" name="fitness_level" value="<?= htmlspecialchars($data['fitness_level']) ?>" />
            </div>

            <div class="form-group">
                <label for="fitness_goal">Fitness Goal</label>
                <input type="text" class="form-control" id="fitness_goal" name="fitness_goal" value="<?= htmlspecialchars($data['fitness_goal']) ?>" />
            </div>

            <div class="form-group">
                <label for="available_time_range">Available Time Range</label>
                <input type="text" class="form-control" id="available_time_range" name="available_time_range" value="<?= htmlspecialchars($data['available_time_range']) ?>" />
            </div>

            <div class="form-group">
                <label for="equipment_needed">Equipment Needed</label>
                <input type="text" class="form-control" id="equipment_needed" name="equipment_needed" value="<?= htmlspecialchars($data['equipment_needed']) ?>" />
            </div>

            <div class="form-group">
                <label for="exercise_program">Exercise Program</label>
                <input type="text" class="form-control" id="exercise_program" name="exercise_program" value="<?= htmlspecialchars($data['exercise_program']) ?>" required />
            </div>

            <div class="form-group">
                <label for="duration_weeks">Duration Weeks</label>
                <input type="text" class="form-control" id="duration_weeks" name="duration_weeks" value="<?= htmlspecialchars($data['duration_weeks']) ?>" />
            </div>

            <div class="form-group">
                <label for="success_rate">Success Rate</label>
                <input type="text" class="form-control" id="success_rate" name="success_rate" required value="<?= htmlspecialchars($data['success_rate']) ?>" />
            </div>

            <div class="form-group">
                <label for="frequency">Frequency</label>
                <select name="frequency" id="frequency" class="form-control" required>
                    <option value="never" <?= $data['frequency'] === 'never' ? 'selected' : '' ?>>Tidak Pernah</option>
                    <option value="3_times" <?= $data['frequency'] === '3_times' ? 'selected' : '' ?>>3 Kali Seminggu</option>
                    <option value="4_times" <?= $data['frequency'] === '4_times' ? 'selected' : '' ?>>4 Kali Seminggu</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

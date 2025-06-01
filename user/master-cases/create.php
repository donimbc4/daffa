<?php
require_once '../../config/config.php';  // Menghubungkan dengan konfigurasi umum
require_once '../../config/database.php';  // Menghubungkan dengan koneksi database

// Pastikan pengguna sudah login
if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    
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
    $duration_weeks = toNullIfEmpty(sanitize($_POST['duration_weeks']));
    $success_rate = sanitize($_POST['success_rate']);
    $frequency = sanitize($_POST['frequency']);
    
    try {
        $query = "INSERT INTO cases (
            case_name, age_range, gender, height_range, weight_range,
            fitness_level, fitness_goal, available_time_range, equipment_needed,
            exercise_program, duration_weeks, success_rate, frequency
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

        $stmt = $db->prepare($query);
        $stmt->execute([
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
            $frequency
        ]);

        $success_message = "Data berhasil ditambahkan.";
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$page_title = 'Tambah Case';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Tambah Case</h2>
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="/user/master-cases/create.php">
            <div class="form-group">
                <label for="case_name">Case Name</label>
                <input type="text" class="form-control" id="case_name" name="case_name" required />
            </div>
            <div class="form-group">
                <label for="age_range">Age Range</label>
                <input type="text" class="form-control" id="age_range" name="age_range" />
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="" disabled selected>- Pilih Gender -</option>
                    <option value="male">Laki - Laki</option>
                    <option value="female">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="height_range">Height Range</label>
                <select name="height_range" id="height_range" class="form-control" required>
                    <option value="" disabled selected>- Pilih Height Range -</option>
                    <option value="165-175">165 cm - 175 cm</option>
                    <option value="175-185">175 cm - 185 cm</option>
                    <option value="185-190">185 cm - 190 cm</option>
                </select>
            </div>
            <div class="form-group">
                <label for="weight_range">Weight Range</label>
                <select name="weight_range" id="weight_range" class="form-control" required>
                    <option value="" disabled selected>- Pilih Weight Range -</option>
                    <option value="50-70">50 - 70 kg</option>
                    <option value="70-80">70 - 80 kg</option>
                    <option value="80-100">80 - 100 kg</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fitness_level">Fitness Level</label>
                <input type="text" class="form-control" id="fitness_level" name="fitness_level" />
            </div>
            <div class="form-group">
                <label for="fitness_goal">Fitness Goal</label>
                <input type="text" class="form-control" id="fitness_goal" name="fitness_goal" />
            </div>
            <div class="form-group">
                <label for="available_time_range">Available Time Range</label>
                <input type="text" class="form-control" id="available_time_range" name="available_time_range" />
            </div>
            <div class="form-group">
                <label for="equipment_needed">Equipment Needed</label>
                <input type="text" class="form-control" id="equipment_needed" name="equipment_needed" />
            </div>
            <div class="form-group">
                <label for="exercise_program">Exercise Program</label>
                <input type="text" class="form-control" id="exercise_program" name="exercise_program" required />
            </div>
            <div class="form-group">
                <label for="duration_weeks">Duration Weeks</label>
                <input type="text" class="form-control" id="duration_weeks" name="duration_weeks" />
            </div>
            <div class="form-group">
                <label for="success_rate">Success Rate</label>
                <input type="text" class="form-control" id="success_rate" name="success_rate" required />
            </div>
            <div class="form-group">
                <label for="frequency">Frequency</label>
                <select name="frequency" id="frequency" class="form-control" required>
                    <option value="" disabled selected>- Pilih Frequency -</option>
                    <option value="never">Tidak Pernah</option>
                    <option value="3_times">3 Kali Seminggu</option>
                    <option value="4_times">4 Kali Seminggu</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>     
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<?php
require_once '../config/config.php';  // Menghubungkan dengan konfigurasi umum
require_once '../config/database.php';  // Menghubungkan dengan koneksi database

// Pastikan pengguna sudah login
if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gender = sanitize($_POST['gender']);
    $weight = sanitize($_POST['weight']);
    $height = sanitize($_POST['height']);
    $frequency = sanitize($_POST['frequency']);
   
    // Koneksi ke database
    $database = new Database();
    $db = $database->getConnection();

    // Query untuk mencari kasus yang paling relevan berdasarkan input pengguna
    $query = "SELECT * FROM cases WHERE gender = ? AND weight_range = ? AND height_range = ? AND frequency = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$gender, $weight, $height, $frequency]);
    $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Menyimpan rekomendasi program latihan
    $recommendations = [];
    foreach ($cases as $case) {
        $recommendations[] = [
            'case_name' => $case['case_name'],
            'exercise_program' => $case['exercise_program'],
            'success_rate' => $case['success_rate']
        ];
    }
}

$page_title = 'Konsultasi Program Latihan';
include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Mulai Konsultasi</h2>
        <form method="POST" action="recomendation.php">
            <div class="form-group">
                <label for="gender">Jenis Kelamin:</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value=""></option>
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="weight">Berat Badan Saat Ini:</label>
                <select name="weight" id="weight" class="form-control" required>
                    <option value=""></option>
                    <option value="50-70">50 - 70 kg</option>
                    <option value="70-80">70 - 80 kg</option>
                    <option value="80-100">80 - 100 kg</option>
                </select>
            </div>

            <div class="form-group">
                <label for="height">Tinggi Badan Saat Ini:</label>
                <select name="height" id="height" class="form-control" required>
                    <option value=""></option>
                    <option value="165-175">165 cm - 175 cm</option>
                    <option value="175-185">175 cm - 185 cm</option>
                    <option value="185-190">185 cm - 190 cm</option>
                </select>
            </div>

            <div class="form-group">
                <label for="frequency">Frekuensi Berolahraga (per minggu):</label>
                <select name="frequency" id="frequency" class="form-control" required>
                    <option value=""></option>
                    <option value="never">Tidak Pernah</option>
                    <option value="3_times">3 Kali Seminggu</option>
                    <option value="4_times">4 Kali Seminggu</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Dapatkan Rekomendasi</button>     
        </form>
        

        <?php if (!empty($recommendations)): ?>
            <h3>Rekomendasi Program Latihan:</h3>
            <ul>
                <?php foreach ($recommendations as $recommendation): 
                    header("Location: recommendation.php");
                    exit();?>
                    <li>
                        <h4><?php echo htmlspecialchars($recommendation['case_name']); ?></h4>
                        <p><?php echo nl2br(htmlspecialchars($recommendation['exercise_program'])); ?></p>
                        <p><strong>Tingkat Keberhasilan:</strong> <?php echo $recommendation['success_rate']; ?>%</p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<?php
require_once '../config/config.php';  // Menghubungkan dengan konfigurasi umum
require_once '../config/database.php';  // Menghubungkan dengan koneksi database

// Pastikan pengguna sudah login
if (!isLoggedIn()) {
    redirect('login.php');
}

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id'];

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Ambil data dari form konsultasi yang ada di session
$gender = sanitize($_POST['gender']);
$weight = sanitize($_POST['weight']);
$height = sanitize($_POST['height']);
$frequency = sanitize($_POST['frequency']);

// Query untuk mencari kasus yang relevan berdasarkan input pengguna
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

$page_title = 'Rekomendasi Program Latihan - Sistem Pakar Fitness';
include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Rekomendasi Program Latihan</h2>

        <?php if (!empty($recommendations)): ?>
            <h3>Berikut adalah program latihan yang disarankan untuk Anda:</h3>
            <ul>
                <?php foreach ($recommendations as $recommendation): ?>
                    <li>
                        <h4><?php echo htmlspecialchars($recommendation['case_name']); ?></h4>
                        <p><strong>Program Latihan:</strong> <?php echo nl2br(htmlspecialchars($recommendation['exercise_program'])); ?></p>
                        <p><strong>Tingkat Keberhasilan:</strong> <?php echo $recommendation['success_rate']; ?>%</p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Maaf, tidak ada program latihan yang sesuai dengan preferensi Anda.</p>
        <?php endif; ?>
        <a href="consultation.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-play"></i> Mulai Konsultasi
                </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

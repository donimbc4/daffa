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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM users";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$page_title = 'Master User';
include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
            <h2>Master User</h2>
            <div>
                asd
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Role</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users ?? [] as $key => $user): ?>
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

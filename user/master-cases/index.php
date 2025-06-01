<?php

require_once '../../config/config.php';  // Menghubungkan dengan konfigurasi umum
require_once '../../config/database.php';  // Menghubungkan dengan koneksi database

// Pastikan pengguna sudah login
if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM cases";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$page_title = 'Master Cases';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
            <h2>Master Cases</h2>
            <div>
                <a href="/user/master-cases/create.php" class="btn btn-primary btn-block">
                    <i class="fas fa-plus"></i> Tambah Case
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Case Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>Fitness Level</th>
                        <th>Fitness Goal</th>
                        <th>Available Time Range</th>
                        <th>Equipment Needed</th>
                        <th>Exercise Program</th>
                        <th>Duration Weeks</th>
                        <th>Frequency</th>
                        <th>Success Rate</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cases ?? [] as $key => $case): ?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?= htmlspecialchars($case['case_name']) ?></td>
                            <td><?= htmlspecialchars($case['age_range']) ?></td>
                            <td><?= htmlspecialchars($case['gender']) ?></td>
                            <td><?= htmlspecialchars($case['height_range']) ?></td>
                            <td><?= htmlspecialchars($case['weight_range']) ?></td>
                            <td><?= htmlspecialchars($case['fitness_level']) ?></td>
                            <td><?= htmlspecialchars($case['fitness_goal']) ?></td>
                            <td><?= htmlspecialchars($case['available_time_range']) ?></td>
                            <td><?= htmlspecialchars($case['equipment_needed']) ?></td>
                            <td><?= htmlspecialchars($case['exercise_program']) ?></td>
                            <td><?= htmlspecialchars($case['duration_weeks']) ?></td>
                            <td><?= htmlspecialchars($case['frequency']) ?></td>                            
                            <td><?= htmlspecialchars($case['success_rate']) ?></td>
                            <td><?= htmlspecialchars($case['created_at']) ?></td>
                            <td>
                                <a href="<?="/user/master-cases/edit.php?id={$case['case_id']}"?>" class="btn btn-primary btn-block">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

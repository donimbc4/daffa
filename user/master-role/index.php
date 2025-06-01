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

    $query = "SELECT * FROM roles";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$page_title = 'Master Role';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
            <h2>Master Role</h2>
            <div>
                <a href="/user/master-role/create.php" class="btn btn-primary btn-block">
                    <i class="fas fa-plus"></i> Tambah Role
                </a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles ?? [] as $key => $role): ?>
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?= htmlspecialchars($role['role']) ?></td>
                        <td><?= htmlspecialchars($role['created_at']) ?></td>
                        <td>
                            <a href="<?="/user/master-role/edit.php?id={$role['id']}"?>" class="btn btn-primary btn-block">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

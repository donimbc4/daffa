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
    
    $role = sanitize($_POST['role']);
    
    try {
        $query = "INSERT INTO roles (role) VALUES (?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$role]);
        $success_message = "Role berhasil ditambah.";
    } catch(PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$page_title = 'Tambah Role';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Tambah Role</h2>
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="/user/master-role/create.php">
            <div class="form-group">
                <label for="gender">Role</label>
                <input type="text" class="form-control" id="role" name="role" required placeholder="Role.." />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>     
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

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
    
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $full_name = sanitize($_POST['full_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $query = "INSERT INTO users (username, email, full_name, password) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$username, $email, $full_name, $password]);
        $success_message = "User berhasil ditambah.";
    } catch(PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$page_title = 'Tambah User';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Tambah User</h2>
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="/user/master-user/create.php">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-user-plus"></i> Daftar
            </button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

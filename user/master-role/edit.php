<?php
require_once '../../config/config.php';
require_once '../../config/database.php';

// Pastikan pengguna sudah login
if (!isLoggedIn()) {
    redirect('login.php');
}

$database = new Database();
$db = $database->getConnection();

// Ambil ID dari query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('/user/master-role/index.php'); // Kembali jika ID tidak valid
}

$id = intval($_GET['id']);
$role = "";

// Ambil data role yang akan diedit
$query = "SELECT * FROM roles WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    redirect('/user/master-role/index.php'); // Jika tidak ditemukan
}

$role = $data['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newRole = sanitize($_POST['role']);

    try {
        $updateQuery = "UPDATE roles SET role = ? WHERE id = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->execute([$newRole, $id]);

        $success_message = "Role berhasil diperbarui.";
        $role = $newRole; // perbarui nilai untuk ditampilkan
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$page_title = 'Edit Role';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Edit Role</h2>
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="role">Role</label>
                <input type="text" class="form-control" id="role" name="role" required value="<?php echo htmlspecialchars($role); ?>" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/user/master-role/index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

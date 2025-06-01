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
    redirect('/user/master-user/index.php');
}

$id = intval($_GET['id']);

// Ambil data user lama
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect('/user/master-user/index.php');
}

$username = $user['username'];
$email = $user['email'];
$full_name = $user['full_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_full_name = sanitize($_POST['full_name']);
    $new_username = sanitize($_POST['username']);
    $new_email = sanitize($_POST['email']);
    $new_password = $_POST['password']; // bisa kosong

    try {
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET full_name = ?, username = ?, email = ?, password = ? WHERE user_id = ?";
            $stmt = $db->prepare($updateQuery);
            $stmt->execute([$new_full_name, $new_username, $new_email, $hashed_password, $id]);
        } else {
            $updateQuery = "UPDATE users SET full_name = ?, username = ?, email = ? WHERE user_id = ?";
            $stmt = $db->prepare($updateQuery);
            $stmt->execute([$new_full_name, $new_username, $new_email, $id]);
        }

        $success_message = "User berhasil diperbarui.";
        $username = $new_username;
        $email = $new_email;
        $full_name = $new_full_name;
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$page_title = 'Edit User';
include '../../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>Edit User</h2>
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($full_name); ?>">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required value="<?php echo htmlspecialchars($username); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="/user/master-user/index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

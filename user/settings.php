<?php
include('includes/db.php');
include('includes/functions.php');

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle password update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current password from the database
    try {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify current password
        if ($current_password == $user['password']) {
            if ($new_password == $confirm_password) {
                // Update the password in plain text
                $update_stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
                $update_stmt->execute(['password' => $new_password, 'id' => $user_id]);

                $message = "Password updated successfully!";
            } else {
                $message = "New passwords do not match!";
            }
        } else {
            $message = "Current password is incorrect!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php include('templates/header1.php'); ?>

<div class="container mt-4">
    <h2>Settings</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="settings.php" method="POST">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

<?php include('templates/footer.php'); ?>

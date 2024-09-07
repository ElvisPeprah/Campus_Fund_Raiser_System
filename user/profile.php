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

// Fetch user data
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Update user data
        $update_stmt = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $update_stmt->execute(['name' => $name, 'email' => $email, 'id' => $user_id]);

        $message = "Profile updated successfully!";
        $_SESSION['user_name'] = $name;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php include('templates/header1.php'); ?>

<div class="container mt-4">
    <h2>Your Profile</h2>
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="profile.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php include('templates/footer.php'); ?>

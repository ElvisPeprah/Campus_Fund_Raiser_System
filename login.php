<?php
session_start();
include('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = authenticate_user($username, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['contact'] = $contact;
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] == 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: user/dashboard.php');
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<?php include('header.php'); ?>

<div class="container mt-4">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</div>

<footer class="bg-light text-center text-lg-start mt-18" style="padding-top:140px; color: white;">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
    </footer>

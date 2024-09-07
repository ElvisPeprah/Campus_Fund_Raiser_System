<?php
session_start();
include('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = authenticate_user($username, $password);
    
    if ($user) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
       
       

        // Redirect based on user role
        if ($user['role'] == 'user') {
            header('Location: dashboard.php');
            exit;
        }
        // Add redirection for other roles if needed
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

<footer class="bg-light text-center text-lg-start mt-18" style="padding-top:120px;">
    <div class="text-center p-3" style="background-color: blue; color:white;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer>

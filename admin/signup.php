<?php
include('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the selected role from the form
    
    // Validate role
    $valid_roles = ['user', 'admin'];
    if (!in_array($role, $valid_roles)) {
        $error = 'Invalid role selected.';
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->execute([':username' => $username, ':password' => $password, ':role' => $role]);

        header('Location: login.php');
        exit;
    }
}
?>

<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <h2>Sign Up</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="signup.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

</div>
    </div>
    </div>
<footer class="bg-light text-center text-lg-start mt-5" style="padding-top:50px; color:white;">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer>


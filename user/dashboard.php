<?php
include('includes/db.php'); // Make sure this points to your database connection file
include('includes/functions.php'); // Include the file that contains your functions

session_start();
$user_id = $_SESSION['user_id'] ?? null; // Fetch user ID from session

// Check if user is logged in
if (!$user_id) {
    header('Location: login.php'); // Redirect to login if user is not logged in
    exit;
}

try {
    // Fetch payments for this user
    $stmt = $conn->prepare("SELECT transaction_Id,name, purpose, amount, contact, status, payment_status FROM payment WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If no payments are found, set the array to an empty one
    if (!$payments) {
        $payments = [];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php include('../user/header1.php'); ?>

<div class="container mt-4">
    <h2>User Dashboard</h2>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="color:blue">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                
            </ul>
        </div>
    </nav>
    <p>Welcome to the campus fundraiser platform!</p>
    <a href="payment.php" class="btn btn-primary">Donate Now</a>

    <h4 class="mt-4">Your Payments</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="color:blue;">Transaction ID</th>
                <th style="color:blue;">Name</th>
                <th style="color:blue;">Purpose</th>
                <th style="color:blue;">Amount</th>
                <th style="color:blue;">Contact</th>
                <th style="color:blue;">Status</th>
                <th style="color:blue;">Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($payments)): ?>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['transaction_Id']); ?></td>
                        <td><?php echo htmlspecialchars($payment['name']); ?></td>
                        <td><?php echo htmlspecialchars($payment['purpose']); ?></td>
                        <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                        <td><?php echo htmlspecialchars($payment['contact']); ?></td>
                        <td><?php echo htmlspecialchars($payment['status']); ?></td>
                        <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No payments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Logos Section -->
<style>
    .logo-container {
        margin-left: 100px;
        
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        width: 150px; /* Adjust as needed */
        height: 150px; /* Adjust as needed */
    }
</style>

<div class="container mt-5">
    <div>
        <h4 style="font-family:'Times New Roman', Times, serif; color:blue; text-align:center;">
            Made Payment Through Paystack
        </h4>
    </div>
    <div class="row text-center">
        <div class="col-md-4">
            <div class="logo-container" style="background-image: url('../assets/images/MTN.png');"></div>
            <p>MTN</p>
        </div>
        <div class="col-md-4">
            <div class="logo-container" style="background-image: url('../assets/images/Vodafone-Cas.png');"></div>
            <p>Vodafone</p>
        </div>
        <div class="col-md-4">
            <div class="logo-container" style="background-image: url('../assets/images/4.webp');"></div>
            <p>Airtel</p>
        </div>
        <div class="col-md-4">
            <div class="logo-container" style="background-image: url('../assets/images/pay1.png');"></div>
        </div>
        <div class="col-md-4">
            <div class="logo-container" style="background-image: url('../assets/images/pay2.png');"></div>
        </div>
        <div class="col-md-4">
            <div class="logo-container" style="background-image: url('../assets/images/momo1.png');"></div>
        </div>
    </div>
</div>




<footer class="bg-light text-center text-lg-start mt-5" style="padding-top:10px; color:white">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer>
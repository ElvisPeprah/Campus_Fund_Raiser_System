<?php
include('includes/functions.php');
session_start();

// Check if user is admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Initialize $payments as an empty array to avoid the warning
$payments = [];

try {
    // Fetch all payments from the database
    $stmt = $conn->prepare("SELECT * FROM payment");
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <h4 class="mt-4">Payment Transactions</h4>
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
                    <td>GHS <?php echo number_format($payment['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($payment['contact']); ?></td>
                    <td><?php echo htmlspecialchars($payment['status']); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No transactions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-light text-center text-lg-start mt-5" style="padding-top:160px; color:white;">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer>

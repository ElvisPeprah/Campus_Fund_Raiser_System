<?php
include('includes/functions.php');
session_start();

// Check if user is admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Initialize $donors and $payments as empty arrays to avoid warnings
$donors = [];
$payments = [];

// Fetch data for admin dashboard
try {
    // Fetch total count of donors, total amount from donors
    $donor_stmt = $conn->prepare("SELECT COUNT(*) AS donor_count, SUM(amount) AS total_donor_amount FROM donors");
    $donor_stmt->execute();
    $donor_data = $donor_stmt->fetch(PDO::FETCH_ASSOC);

    $donor_count = $donor_data['donor_count'] ?? 0;
    $total_donor_amount = $donor_data['total_donor_amount'] ?? 0.00;

    // Fetch total count of transactions, total amount received from payments
    $payment_stmt = $conn->prepare("SELECT COUNT(*) AS total_transactions, SUM(amount) AS total_received FROM payment");
    $payment_stmt->execute();
    $payment_data = $payment_stmt->fetch(PDO::FETCH_ASSOC);

    $total_transactions = $payment_data['total_transactions'] ?? 0;
    $total_received = $payment_data['total_received'] ?? 0.00;

    // Combine the totals
    $overall_total_count = $donor_count + $total_transactions;
    $overall_total_amount = $total_donor_amount + $total_received;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch all donors and payments for the lists
$donors = get_donor_list(); // Assuming this function fetches the donor list
$stmt = $conn->prepare("SELECT * FROM payment");
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include('../user/header1.php'); ?>

<!-- Admin Dashboard -->
<div class="container mt-4">
    <h2>Admin Dashboard</h2>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="color:blue">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="add_donor.php" style="color:blue; font-family:'Times New Roman', Times, serif; font-weight:bolder;">Add Donor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transactions.php" style="color:blue; font-family:'Times New Roman', Times, serif; font-weight:bolder;">Transactions</a>
                </li>
                
            </ul>
        </div>
    </nav>

    <!-- Dashboard Metrics -->
    <div class="row" style="padding-top:30px;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Overall Total Count</h5>
                    <p><?php echo $overall_total_count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Overall Total Amount Received</h5>
                    <p>GHS <?php echo number_format($overall_total_amount, 2); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Donor List -->
    <h4 class="mt-4">Donor List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="color:blue">Name</th>
                <th style="color:blue">Purpose</th>
                <th style="color:blue">Amount</th>
                <th style="color:blue">Contact</th>
                <th style="color:blue">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($donors)): ?>
                <?php foreach ($donors as $donor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($donor['name']); ?></td>
                    <td><?php echo htmlspecialchars($donor['purpose']); ?></td>
                    <td>GHS <?php echo number_format($donor['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($donor['contact']); ?></td>
                    <td>
                        <a href="donors.php?edit=<?php echo $donor['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="donors.php?delete=<?php echo $donor['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No donors found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-light text-center text-lg-start mt-18" style="padding-top:50px; color:white;">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer>

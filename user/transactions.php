<?php
include('../includes/functions.php');
session_start();

$user_id = $_SESSION['user_id'];

// Fetch user's transactions
$stmt = $conn->prepare("SELECT * FROM transactions WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('../user/header.php'); ?>

<div class="container mt-4">
    <h2>Your Transactions</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo $transaction['id']; ?></td>
                <td><?php echo $transaction['amount']; ?></td>
                <td><?php echo $transaction['date']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('../templates/footer.php'); ?>

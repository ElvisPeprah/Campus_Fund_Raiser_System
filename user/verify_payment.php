<?php
session_start();
include('../includes/db.php');  // Ensure db.php is properly included

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if (!$reference) {
    die('No reference supplied');
}

$user_id = $_SESSION['user_id'];

// Paystack secret key (ensure this is correct and kept secure)
$secret_key = 'sk_test_dc4bfde29357c47f4c68afb031ce39d3e18356b6';

// Initialize cURL for Paystack verification
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . rawurlencode($reference));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Authorization: Bearer $secret_key"
]);

// Execute cURL
$response = curl_exec($ch);
if (curl_errno($ch)) {
    die('Curl error: ' . curl_error($ch));
}
curl_close($ch);

// Decode JSON response
$result = json_decode($response, true);

// Check if Paystack response is successful
if ($result && $result['status'] && $result['data']['status'] === 'success') {
    // Get transaction data from Paystack response
    $name = $result['data']['customer']['first_name'] . ' ' . $result['data']['customer']['last_name'];
    $email = $result['data']['customer']['email'];
    $purpose = isset($_POST['purpose']) ? $_POST['purpose'] : 'Donation';  // Assuming purpose comes from form
    $amount = $result['data']['amount'] / 100;  // Convert to currency format
    $contact = isset($result['data']['customer']['phone']) ? $result['data']['customer']['phone'] : null;

    if (!$contact) {
        $contact = 'Not Provided';  // Default value if phone is not provided
    }
    

   // $contact = $result['data']['customer']['phone'];  // Assuming contact can be retrieved
    $transaction_id = $result['data']['id'];
    $status = $result['data']['status'];
    $payment_status = 'verified';

    // Check for duplicate transaction
    $check_stmt = $conn->prepare("SELECT * FROM payment WHERE transaction_id = :transaction_id");
    $check_stmt->execute([':transaction_id' => $transaction_id]);

    if ($check_stmt->rowCount() == 0) {
        // No duplicate found, proceed to insert transaction data
        $stmt = $conn->prepare("INSERT INTO payment (name, email, purpose, amount, contact, transaction_id, status, payment_status, user_id) 
                                VALUES (:name, :email, :purpose, :amount, :contact, :transaction_id, :status, :payment_status, :user_id)");
        $success = $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':purpose' => $purpose,
            ':amount' => $amount,
            ':contact' => $contact,
            ':transaction_id' => $transaction_id,
            ':status' => $status,
            ':payment_status' => $payment_status,
            ':user_id' => $user_id
        ]);

        // Check if the transaction was successfully inserted
        if ($success) {
            $_SESSION['status'] = "Congrats!";
            $_SESSION['status_text'] = "Payment made successfully.";
        } else {
            $_SESSION['status'] = "Sorry!";
            $_SESSION['status_text'] = "Failed to store the transaction in the database.";
        }
    } else {
        // Duplicate transaction found
        $_SESSION['status'] = "Notice!";
        $_SESSION['status_text'] = "Transaction has already been processed.";
    }

    header('Location: dashboard.php');
    exit();
} else {
    // Paystack verification failed or transaction not successful
    $_SESSION['status'] = "Sorry!";
    $_SESSION['status_text'] = "Transaction verification failed or was unsuccessful.";
    header('Location: payment.php');
    exit();
}
?>

<?php
// includes/functions.php
include('db.php');
// Get total number of donors
function get_donor_count() {
    global $conn;
    $stmt = $conn->query("SELECT COUNT(*) FROM donors");
    return $stmt->fetchColumn();
}

// Get total amount received from donors
function get_total_amount() {
    global $conn;
    $stmt = $conn->query("SELECT SUM(amount) FROM donors");
    $total = $stmt->fetchColumn();

    if ($total === false || $total == null) {
        return 0;  // Fallback to 0 if no data found
    }

    return $total;
}

// Get the donor list
function get_donor_list() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM donors ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get donor by ID
function get_donor_by_id($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM donors WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add a new donor
function add_donor($name, $purpose, $amount, $contact) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO donors (name, purpose, amount, contact) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $purpose, $amount, $contact]);
}

// Update an existing donor
function update_donor($id, $name, $purpose, $amount, $contact) {
    global $conn;
    $stmt = $conn->prepare("UPDATE donors SET name = ?, purpose = ?, amount = ?, contact = ? WHERE id = ?");
    return $stmt->execute([$name, $purpose, $amount, $contact, $id]);
}

// Delete a donor
function delete_donor($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM donors WHERE id = ?");
    return $stmt->execute([$id]);
}

// Authenticate user
function authenticate_user($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Compare plain text password
    if ($user && $user['password'] === $password) {
        return $user;
    }

    return false;
}
// Get user-specific donations
function get_user_donations($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM donors || donations WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Add a new transaction
function add_transaction($donor_id, $amount, $transaction_type) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO transactions (donor_id, amount, transaction_type, date) VALUES (?, ?, ?, NOW())");
    return $stmt->execute([$donor_id, $amount, $transaction_type]);
}

// Get all transactions (admin view)
function get_transactions() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM transactions ORDER BY date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get transactions for a specific donor
function get_donor_transactions($donor_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE donor_id = ? ORDER BY date DESC");
    $stmt->execute([$donor_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php
include('db.php');

// Get total number of donors
function get_donor_count() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT COUNT(*) FROM donors");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return false;
    }
}

// Get total amount received from transactions
function get_total_amount() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT SUM(amount) FROM transactions");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return false;
    }
}

// Get the donor list
function get_donor_list() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT * FROM donors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return [];
    }
}

// Get donor by ID
function get_donor_by_id($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM donors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return null;
    }
}

// Add a new donor
function add_donor($name, $purpose, $amount, $contact) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO donors (name, purpose, amount, contact) VALUES (:name, :purpose, :amount, :contact)");
        return $stmt->execute([':name' => $name, ':purpose' => $purpose, ':amount' => $amount, ':contact' => $contact]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return false;
    }
}

// Update an existing donor
function update_donor($id, $name, $purpose, $amount, $contact) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE donors SET name = :name, purpose = :purpose, amount = :amount, contact = :contact WHERE id = :id");
        return $stmt->execute([':name' => $name, ':purpose' => $purpose, ':amount' => $amount, ':contact' => $contact, ':id' => $id]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return false;
    }
}

// Delete a donor
function delete_donor($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM donors WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return false;
    }
}

// Authenticate user
function authenticate_user($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the password matches
    if ($user && $user['password'] === $password) {
        return $user;
    }

    return false;
}

// Get user-specific donations
function get_user_donations($user_id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM donors WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return [];
    }
}


function get_payment_data() {
    global $conn;
    
    if ($conn) {
        // Query to fetch payment data
        $sql = "SELECT * FROM payment"; // Ensure the 'payments' table exists and has data
        $stmt = $conn->query($sql);
        
        // Fetch all payments
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $payments;
    } else {
        return []; // Return an empty array if the connection fails
    }
}

// Add a new transaction
function add_transaction($donor_id, $amount, $transaction_type) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO transactions (donor_id, amount, transaction_type, date) VALUES (:donor_id, :amount, :transaction_type, NOW())");
        return $stmt->execute([':donor_id' => $donor_id, ':amount' => $amount, ':transaction_type' => $transaction_type]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return false;
    }
}

// Get all transactions (admin view)
function get_transactions() {
    global $conn;
    try {
        $stmt = $conn->query("
            SELECT t.*, d.name AS donor_name
            FROM transactions t
            LEFT JOIN donors d ON t.donor_id = d.id
            ORDER BY t.date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}


// Get transactions for a specific donor
function get_donor_transactions($donor_id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM transactions WHERE donor_id = :donor_id ORDER BY date DESC");
        $stmt->execute([':donor_id' => $donor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Log error message
        return [];
    }
}
?>

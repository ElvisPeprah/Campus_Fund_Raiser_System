<?php
include('includes/functions.php');
session_start();



// Initialize variables for Create and Update forms
$name = $purpose = $amount = $contact = '';
$edit_mode = false;

// Handle Create (Add Donor)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_donor'])) {
    $name = $_POST['name'];
    $purpose = $_POST['purpose'];
    $amount = $_POST['amount'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO donors (name, purpose, amount, contact) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $purpose, $amount, $contact]);

    header('Location: donors.php');
    exit;
}

// Handle Update (Edit Donor)
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = $_GET['edit'];

    // Fetch donor data for the edit form
    $stmt = $conn->prepare("SELECT * FROM donors WHERE id = ?");
    $stmt->execute([$id]);
    $donor = $stmt->fetch();

    $name = $donor['name'];
    $purpose = $donor['purpose'];
    $amount = $donor['amount'];
    $contact = $donor['contact'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_donor'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $purpose = $_POST['purpose'];
    $amount = $_POST['amount'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE donors SET name = ?, purpose = ?, amount = ?, contact = ? WHERE id = ?");
    $stmt->execute([$name, $purpose, $amount, $contact, $id]);

    header('Location: donors.php');
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM donors WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: donors.php');
    exit;
}

// Fetch donor list
$donors = get_donor_list();
$total_amount = get_total_amount();
?>

<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <?php if ($edit_mode): ?>
        <h2>Edit Donor</h2>
        <form action="donors.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose</label>
                <textarea name="purpose" id="purpose" class="form-control" required><?php echo htmlspecialchars($purpose); ?></textarea>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" value="<?php echo htmlspecialchars($amount); ?>" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" value="<?php echo htmlspecialchars($contact); ?>" required>
            </div>
            <button type="submit" name="update_donor" class="btn btn-primary">Update Donor</button>
            <a href="donors.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php else: ?>
        <h2>Manage Donors</h2>
        <a href="add_donor.php" class="btn btn-success mb-2">Add Donor</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="color:blue;">Name</th>
                    <th style="color:blue;">Purpose</th>
                    <th style="color:blue;">Amount</th>
                    <th style="color:blue;">Contact</th>
                    <th style="color:blue;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donors as $donor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($donor['name']); ?></td>
                    <td><?php echo htmlspecialchars($donor['purpose']); ?></td>
                    <td><?php echo htmlspecialchars($donor['amount']); ?></td>
                    <td><?php echo htmlspecialchars($donor['contact']); ?></td>
                    <td>
                        <a href="donors.php?edit=<?php echo $donor['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="donors.php?delete=<?php echo $donor['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donor?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<footer class="bg-light text-center text-lg-start mt-5" style="padding-top:150px; color:white">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer
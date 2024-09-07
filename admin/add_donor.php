<?php
// Include necessary files
include('includes/functions.php');
include('includes/header.php');

// Ensure the user is an admin
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Logic for adding a donor can be added here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $purpose = $_POST['purpose'];
    $amount = $_POST['amount'];
    $contact = $_POST['contact'];

    // Call a function to add the donor
    if (add_donor($name, $purpose, $amount, $contact)) {
        echo '<div class="alert alert-success">Donor added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error adding donor. Please try again.</div>';
    }
}
?>

<div class="container">
    <div class="form-container">
        <form action="add_donor.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose</label>
                <textarea name="purpose" id="purpose" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Donor</button>
        </form>
    </div>
</div>

<footer class="bg-light text-center text-lg-start mt-5" style="padding-top:20px; color:white">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer

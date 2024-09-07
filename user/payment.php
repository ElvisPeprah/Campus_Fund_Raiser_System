<?php 
include('../user/header.php'); 
?>

<div class="container mt-4">
    <h2>Make a Donation</h2>
    <form action="payment.php" id="paymentForm" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
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
        <button type="submit" class="btn btn-primary" onclick="payWithPaystack(event)">Donate via Paystack</button>
    </form>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
  // Paystack Payment Function
  function payWithPaystack(e) {
    e.preventDefault(); // Prevent the form from submitting

    // Retrieve form values at the time of submission
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const purpose = document.getElementById("purpose").value.trim();
    const amount = document.getElementById("amount").value.trim();
    const contact = document.getElementById("contact").value.trim();

    let handler = PaystackPop.setup({
      key: "pk_live_f606c63502b84aca2287d73f69029aad835adb43", // Ensure no spaces in the key
      email: email,
      amount: amount * 100, // Convert amount to the lowest denomination (e.g., 5000 for GHS 50.00)
      currency: "GHS",
      ref: "" + Math.floor(Math.random() * 1000000000 + 1), // Generate a random reference
      callback: function(response) {
        // Payment was successful, verify the transaction on your server
        let reference = response.reference;
        window.location.href = `verify_payment.php?reference=${reference}`;
      },
      onClose: function() {
        alert("Transaction was not completed, window closed.");
      },
    });

    handler.openIframe(); // Open the Paystack iframe for payment
  }

</script>

<footer class="bg-light text-center text-lg-start mt-18" style="padding-top:40px; color:white">
    <div class="text-center p-3" style="background-color: blue;">
        © 2024 Campus Fundraiser. All Rights Reserved.
    </div>
</footer>

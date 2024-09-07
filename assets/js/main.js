// assets/js/main.js

$(document).ready(function() {
    // Example: Toggle a success message after a form submission
    $(".success-msg").fadeOut(3000);  // Fades out after 3 seconds

    // Example: Confirmation before deleting a donor
    $('.btn-danger').click(function(e) {
        if (!confirm("Are you sure you want to delete this donor?")) {
            e.preventDefault();
        }
    });
});

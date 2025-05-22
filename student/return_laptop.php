<?php
include '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrower = $_POST['borrower'] ?? '';
    $laptop_serial = $_POST['laptop_serial'] ?? '';

    if ($borrower && $laptop_serial) {
        // Update lending status to 'returned_pending'
        $stmt = $conn->prepare("UPDATE laptop_lending SET status = 'returned_pending' WHERE borrower = ? AND laptop_serial = ? AND status = 'approved'");
        $stmt->bind_param("ss", $borrower, $laptop_serial);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            echo "<script>alert('Return request submitted successfully!'); window.location.href = 'student_dashboard.php?reg=" . urlencode($borrower) . "';</script>";
        } else {
            echo "<script>alert('No approved lending record found or already returned.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "Missing required fields.";
    }
} else {
    echo "Invalid request.";
}
?>

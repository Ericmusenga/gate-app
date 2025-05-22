<?php
include '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_owner = $_POST['original_owner'] ?? '';
    $borrower = $_POST['borrower'] ?? '';
    $laptop_serial = $_POST['laptop_serial'] ?? '';

    if ($original_owner && $borrower && $laptop_serial) {
        $stmt = $conn->prepare("INSERT INTO laptop_lending (laptop_serial, original_owner, borrower, status) VALUES (?, ?, ?, 'approved')");
        $stmt->bind_param("sss", $laptop_serial, $original_owner, $borrower);

        if ($stmt->execute()) {
            echo "<script>alert('Lending approved successfully!'); window.location.href = 'student_dashboard.php?reg=" . urlencode($original_owner) . "';</script>";
        } else {
            echo "Error approving lending: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Missing required fields.";
    }
} else {
    echo "Invalid request.";
}
?>

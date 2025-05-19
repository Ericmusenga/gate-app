<?php
include '../db_connection.php';

$regNumber = $_POST['regNumber'];
$serialNumber = $_POST['serialNumber'];

// Update student's record with laptop info and mark as lent
$query = "UPDATE students SET Laptop_SerialNumber = ?, laptop_status = 'LENT', lend_approved = 'NO' WHERE Registration_Number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $serialNumber, $regNumber);

if ($stmt->execute()) {
    echo "Laptop lending request submitted. Awaiting approval.";
} else {
    echo "Failed to submit lending request.";
}
$stmt->close();
$conn->close();
?>

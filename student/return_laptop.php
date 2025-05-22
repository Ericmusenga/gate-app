<?php
include '../db.php';

$regNumber = $_POST['Registration_Number'];
$serialNumber = $_POST['Laptop_SerialNumber'];

// Mark the return request
$query = "UPDATE students SET laptop_status = 'RETURN_REQUESTED', return_approved = 'NO' WHERE Registration_Number = ? AND Laptop_SerialNumber = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $regNumber, $serialNumber);

if ($stmt->execute()) {
    echo "Return request submitted. Awaiting approval.";
} else {
    echo "Failed to submit return request.";
}
$stmt->close();
$conn->close();
?>

<?php
include 'db_connection.php';

$regNumber = $_POST['regNumberReturn'];
$serialNumber = $_POST['serialNumberReturn'];

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

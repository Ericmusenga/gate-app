<?php
include '../db.php';

if (
    empty($_POST['reg_number']) || empty($_POST['name']) || empty($_POST['email']) ||
    empty($_POST['department']) || empty($_POST['program']) ||
    empty($_POST['class']) || empty($_POST['studentcard_id']) ||
    empty($_FILES['photo']['name'])
) {
    echo "❌ Please fill in all required fields.";
    exit();
}

// Collect data
$regNumber = $_POST['reg_number'];
$name = $_POST['name'];
$email = $_POST['email'];
$department = $_POST['department'];
$program = $_POST['program'];
$class = $_POST['class'];
$laptopSerial = $_POST['laptop_serial']; // optional
$studentCardId = $_POST['studentcard_id'];
$createdAt = date("Y-m-d H:i:s");

// Handle photo upload
$photoName = $_FILES['photo']['name'];
$photoTmp = $_FILES['photo']['tmp_name'];
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir);
}
$targetFile = $targetDir . basename($photoName);
move_uploaded_file($photoTmp, $targetFile);

// Insert into DB
$query = "INSERT INTO students 
(Registration_Number, password, Name, email, Department, Program, Class, Laptop_SerialNumber, studentcard_Id, photo, created_at)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssssss", $regNumber, $regNumber, $name, $email, $department, $program, $class, $laptopSerial, $studentCardId, $photoName, $createdAt);

if ($stmt->execute()) {
    echo "✅ Student registered successfully.";
 } else {
    echo "❌ Failed to register student. " . $stmt->error;
}

$stmt->close();
$conn->close();
header("Location: register.html?success=1");
exit();
?>

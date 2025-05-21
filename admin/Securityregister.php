<?php
include '../db.php';

if (
    empty($_POST['Name']) || empty($_POST['name']) ||
    empty($_POST['Security_ID']) || empty($_POST['id']) ||
    empty($_POST['Username']) || empty($_POST['username']) ||
    empty($_FILES['Password']['password'])
) {
    echo "❌ Please fill in all required fields.";
    exit();
}

// Collect data
$name = $_POST['name'];
$security_id = $_POST['security_id'];
$username= $_POST['username'];
$password= $_POST['password'];

// $targetFile = $targetDir . basename($photoName);
// move_uploaded_file($photoTmp, $targetFile);

// Insert into DB
$query = "INSERT INTO security 
( Name, Security_ID, Username, Password)
VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $name, $security_id, $username, $password);

if ($stmt->execute()) {
    echo "✅ Security Registered successfully.";
 } else {
    echo "❌ Failed to register security. " . $stmt->error;
}

$stmt->close();
$conn->close();
header("Location: register.html?success=1");
exit();
?>

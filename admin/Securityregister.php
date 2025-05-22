<?php
include '../db.php';

// Ensure the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim inputs and check for emptiness
    $name = trim($_POST['name'] ?? '');
    $security_id = trim($_POST['security_id'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($name) || empty($security_id) || empty($username) || empty($password)) {
        echo "❌ Please fill in all required fields.";
        exit();
    }

    // Prepare and insert into database
    $query = "INSERT INTO security (Name, Security_ID, Username, Password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $security_id, $username, $password);

    if ($stmt->execute()) {
        header("Location: Securityregister.html?success=1");
        exit();
    } else {
        echo "❌ Failed to register security. " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "❌ Invalid request method.";
}
?>

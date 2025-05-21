<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gate';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM visitors WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // This must match JS check
    } else {
        http_response_code(500);
        echo "SQL Error: " . $conn->error;
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}

$conn->close();
?>

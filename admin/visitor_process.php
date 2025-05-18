<?php
// Database configuration
$host = "localhost";
$dbname = "gate";
$username = "root"; // Change if different
$password = "";     // Change if different

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $visitor_name = $_POST['visitor_name'] ?? '';
    $id_number = $_POST['id_number'] ?? '';
    $visit_reason = $_POST['visit_reason'] ?? '';
    $photo_url = $_POST['photo_url'] ?? '';

    // Prepare SQL statement
    $sql = "INSERT INTO visitors (visitor_name, id_number, visit_reason, photo_url, visit_time)
            VALUES (:visitor_name, :id_number, :visit_reason, :photo_url, NOW())";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':visitor_name' => $visitor_name,
            ':id_number'    => $id_number,
            ':visit_reason' => $visit_reason,
            ':photo_url'    => $photo_url,
        ]);
        echo "Visitor registered successfully!";
    } catch (PDOException $e) {
        echo "Error saving visitor: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>

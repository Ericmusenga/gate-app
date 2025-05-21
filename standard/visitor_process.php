<?php
// Database configuration
$host = "localhost";
$dbname = "gate";
$username = "root"; 
$password = "";     

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
    $district = $_POST['district'] ?? '';
    $sector = $_POST['sector'] ?? '';
    $equipment = $_POST['equipment'] ?? '';

    // Prepare SQL statement
    $sql = "INSERT INTO visitors (visitor_name, id_number, visit_reason, district, sector, equipment, visit_time)
            VALUES (:visitor_name, :id_number, :visit_reason, :district, :sector, :equipment, NOW())";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':visitor_name' => $visitor_name,
            ':id_number'    => $id_number,
            ':visit_reason' => $visit_reason,
            ':district'    => $district,
            'sector' => $sector,
            'equipment' => $equipment,
        ]);
        echo "Visitor registered successfully!";
    } catch (PDOException $e) {
        echo "Error saving visitor: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>

<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gate';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update logic when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $visitor_name = $_POST['visitor_name'];
    $id_number = $_POST['id_number'];
    $visit_reason = $_POST['visit_reason'];
    $sector = $_POST['sector'];
    $district = $_POST['district'];
    $equipment = $_POST['equipment'];

    $sql = "UPDATE visitors SET 
                visitor_name = ?, 
                id_number = ?, 
                visit_reason = ?, 
                sector = ?, 
                district = ?, 
                equipment = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $visitor_name, $id_number, $visit_reason, $sector, $district, $equipment, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Visitor updated successfully.'); window.location.href = 'standard_dashboard.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    exit;
}

// Load existing visitor info
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM visitors WHERE id = $id");

    if ($result->num_rows == 1) {
        $visitor = $result->fetch_assoc();
        // window.location.reload();
        // exit();
    } else {
        echo "Visitor not found."; 
        exit;
    }
} else {
    echo "No visitor ID provided.";
    exit;
}
$conn->close();

?>

<!-- HTML Edit Form -->
<h2>Edit Visitor Information</h2>
<form method="post" action="edit_visitor.php">
    <input type="hidden" name="id" value="<?php echo $visitor['id']; ?>">

    <label>Visitor Name:</label><br>
    <input type="text" name="visitor_name" value="<?php echo $visitor['visitor_name']; ?>" required><br><br>

    <label>ID Number:</label><br>
    <input type="text" name="id_number" value="<?php echo $visitor['id_number']; ?>" required><br><br>

    <label>Visit Reason:</label><br>
    <input type="text" name="visit_reason" value="<?php echo $visitor['visit_reason']; ?>" required><br><br>

    <label>Sector:</label><br>
    <input type="text" name="sector" value="<?php echo $visitor['sector']; ?>" required><br><br>

    <label>District:</label><br>
    <input type="text" name="district" value="<?php echo $visitor['district']; ?>" required><br><br>

    <label>Equipment:</label><br>
    <input type="text" name="equipment" value="<?php echo $visitor['equipment']; ?>"><br><br>

    <input type="submit" value="Update Visitor">
</form>

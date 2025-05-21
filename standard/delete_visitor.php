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
    $sql = "DELETE FROM visitors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Visitor deleted successfully.";
        } else {
            echo "Error deleting visitor.";
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL.";
    }
} else {
    echo "No visitor ID specified.";
}

$conn->close();

?>
    <script>
    function deleteVisitor(id) {
    if (confirm("Are you sure you want to delete this visitor?")) {
        fetch('delete_visitor.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadContent('export_vistor_report.php'); // Reload updated content
        })
        .catch(error => {
            alert("Error deleting: " + error);
        });
    }
    }
    </script>
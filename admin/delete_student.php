<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gate';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize the ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // First, check if the student exists and get their photo
    $check = $conn->prepare("SELECT photo FROM students WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        echo "❌ Student not found.";
        exit;
    }

    $student = $result->fetch_assoc();

    // Delete student
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Optionally delete the photo
        if (!empty($student['photo'])) {
            $photoPath = "uploads/" . $student['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        echo "✅ Student deleted successfully.";
    } else {
        echo "❌ Failed to delete student.";
    }

    $stmt->close();
} else {
    echo "❌ Invalid student ID.";
}

$conn->close();
?>

<script>
function deleteStudent(id) {
    if (confirm("Are you sure you want to delete this student?")) {
        fetch('delete_student.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Refresh to reflect deletion
        })
        .catch(error => {
            alert("Error deleting: " + error);
        });
    }
}
</script>

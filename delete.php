<?php
include('db.php');

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "DELETE FROM students WHERE student_id = $student_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: view.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

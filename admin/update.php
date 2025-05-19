<?php
include('../db.php');

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE student_id = $student_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $department = $_POST['department'];
        $program = $_POST['program'];
        $class = $_POST['class'];
        $photo_url = $_POST['photo_url'];
        $serial_number = $_POST['serial_number'];

        $update_sql = "UPDATE students SET name='$name', department='$department', program='$program', 
                       class='$class', photo='$file', serial_number='$serial_number' 
                       WHERE student_id=$student_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "Record updated successfully";
            header("Location: view.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>update</title>
</head>
<body>
  <form method="POST">
    <label>Name:</label><input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>
    <label>Department:</label><input type="text" name="department" value="<?php echo $row['department']; ?>" required><br>
    <label>Program:</label><input type="text" name="program" value="<?php echo $row['program']; ?>" required><br>
    <label>Class:</label><input type="text" name="class" value="<?php echo $row['class']; ?>" required><br>
    <label>Photo URL:</label><input type="text" name="photo" value="<?php echo $row['photo']; ?>" required><br>
    <label>Serial Number:</label><input type="text" name="serial_number" value="<?php echo $row['serial_number']; ?>" required><br>
    <button type="submit">Update Student</button>
</form>

</body>
</html>

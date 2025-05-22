<?php
// DB connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gate';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request: student ID missing.");
}

$studentId = intval($_GET['id']);

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg = $_POST['reg_number'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $class = $_POST['class'];
    $laptop_serial = $_POST['laptop_serial'];
    $laptop_status = $_POST['laptop_status'];
    $card_id = $_POST['studentcard_id'];

    // Optional: handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photoName = basename($_FILES['photo']['name']);
        $photoTmp = $_FILES['photo']['tmp_name'];
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }
        $targetFile = $targetDir . $photoName;
        move_uploaded_file($photoTmp, $targetFile);

        $sql = "UPDATE students SET 
            Registration_Number=?, Name=?, Department=?, Program=?, Class=?, 
            Laptop_SerialNumber=?, laptop_status=?, studentcard_Id=?, photo=? 
            WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $reg, $name, $department, $program, $class, $laptop_serial, $laptop_status, $card_id, $photoName, $studentId);
    } else {
        $sql = "UPDATE students SET 
            Registration_Number=?, Name=?, Department=?, Program=?, Class=?, 
            Laptop_SerialNumber=?, laptop_status=?, studentcard_Id=? 
            WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $reg, $name, $department, $program, $class, $laptop_serial, $laptop_status, $card_id, $studentId);
    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ Student updated successfully.'); window.location.href='admin_dashboard.php';</script>";
        exit();
    } else {
        echo "❌ Failed to update: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch student data
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }
        form {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #3a80cb;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 20px;
            background-color: #3a80cb;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkblue;
        }
        img {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Edit Student</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Registration Number</label>
    <input type="text" name="reg_number" value="<?= htmlspecialchars($student['Registration_Number']) ?>" required>

    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($student['Name']) ?>" required>

    <label>Department</label>
    <input type="text" name="department" value="<?= htmlspecialchars($student['Department']) ?>" required>

    <label>Program</label>
    <input type="text" name="program" value="<?= htmlspecialchars($student['Program']) ?>" required>

    <label>Class</label>
    <input type="text" name="class" value="<?= htmlspecialchars($student['Class']) ?>" required>

    <label>Laptop Serial Number</label>
    <input type="text" name="laptop_serial" value="<?= htmlspecialchars($student['Laptop_SerialNumber']) ?>">

    <label>Laptop Status</label>
    <select name="laptop_status">
        <option value="Yes" <?= $student['laptop_status'] === 'Yes' ? 'selected' : '' ?>>Yes</option>
        <option value="No" <?= $student['laptop_status'] === 'No' ? 'selected' : '' ?>>No</option>
    </select>

    <label>Student Card ID</label>
    <input type="text" name="studentcard_id" value="<?= htmlspecialchars($student['studentcard_Id']) ?>" required>

    <label>Photo (optional)</label>
    <input type="file" name="photo">
    <?php if (!empty($student['photo'])): ?>
        <p>Current: <img src="uploads/<?= $student['photo'] ?>" width="100" /></p>
    <?php endif; ?>

    <button type="submit">Update Student</button>
</form>

</body>
</html>

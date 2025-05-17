<?php
// Enable error reporting (for development)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database config
$servername = "localhost";
$username = "root";
$password = "";
$database = "gate";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $database);

// Check DB connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["photo"])) {

    if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {

        $targetDir = "upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $originalName = basename($_FILES["photo"]["name"]);
        $photoPath = $targetDir . time() . "_" . $originalName;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath)) {

            $studentId     = $_POST['studentId'] ?? '';
            $name          = $_POST['name'] ?? '';
            $department    = $_POST['department'] ?? '';
            $program       = $_POST['program'] ?? '';
            $class         = $_POST['class'] ?? '';
            $serialNumber  = $_POST['serialNumber'] ?? '';

            if (
                !empty($studentId) && !empty($name) && !empty($department) &&
                !empty($program) && !empty($class) && !empty($serialNumber)
            ) {
                $sql = "INSERT INTO students (studentId, name, department, program, class, serialNumber, photo)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("sssssss", $studentId, $name, $department, $program, $class, $serialNumber, $photoPath);
                    if ($stmt->execute()) {
                        // ✅ Redirect with success flag
                        header("Location: register.html?success=1");
                        exit();
                    } else {
                        echo "❌ Database insert error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "❌ Failed to prepare SQL: " . $conn->error;
                }

            } else {
                echo "❌ Please fill in all required fields.";
            }

        } else {
            echo "❌ Failed to save uploaded file.";
        }

    } else {
        echo "❌ File upload error: " . fileUploadErrorMessage($_FILES["photo"]["error"]);
    }

} else {
    echo "❌ Invalid form submission or photo not provided.";
}

$conn->close();

function fileUploadErrorMessage($code) {
    $errors = [
        UPLOAD_ERR_INI_SIZE   => 'The file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
        UPLOAD_ERR_PARTIAL    => 'The file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.'
    ];
    return $errors[$code] ?? 'Unknown upload error.';
}
?>

<?php
// delete_visitor.php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'gate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM visitors WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success"; // must match JavaScript check
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No ID provided.";
}
?>
    <script>
    function deleteVisitor(id) {
        if (confirm("Are you sure you want to delete this visitor?")) {
            fetch('delete_visitor.php?id=' + id)
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => {
                alert("Error deleting: " + error);
            });
        }
    }
    </script>
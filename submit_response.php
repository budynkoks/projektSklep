<?php
require("include/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $responseText = htmlspecialchars($_POST['responseText']);
    
    
    $sql = "UPDATE messages SET responseText = ?, responseDate = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $responseText, $id);
    
    if ($stmt->execute()) {
        echo "Response sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

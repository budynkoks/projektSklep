<?php
require("include/db.php");
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questionId = $_POST['questionId'];
    $responseText = $_POST['responseText'];

   
    $stmt = $conn->prepare("UPDATE messages SET responseText = ?, responseDate = NOW() WHERE id = ?");
    $stmt->bind_param("si", $responseText, $questionId);
    
    if ($stmt->execute()) {
        header("Location: questions.php");
        exit();
    } else {
        echo "Błąd podczas wysyłania odpowiedzi.";
    }

    $stmt->close();
}
?>

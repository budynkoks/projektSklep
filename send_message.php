<?php
require("include/db.php");
require("include/header.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
   
    $idUser = isset($_POST['idUser']) && !empty($_POST['idUser']) ? $_POST['idUser'] : null;
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
    $subject = htmlspecialchars($_POST['subject']);
    $messageText = htmlspecialchars($_POST['messageText']);
    $idProduct = isset($_POST['idProduct']) ? $_POST['idProduct'] : null;

    
    $sql = "INSERT INTO messages (idUser, email, idProduct, subject, messageText) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $idUser, $email, $idProduct, $subject, $messageText);

    if ($stmt->execute()) {
        echo "<h1 class='big'>Wysłałeś wiadomość!</h1>";
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();
    $conn->close();
}
require("include/footer.php");
?>

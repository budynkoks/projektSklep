<?php
require("include/db.php");
require("include/header.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUser = $_SESSION['id'];
    $subject = htmlspecialchars($_POST['subject']);
    $messageText = htmlspecialchars($_POST['messageText']);
    $idProduct = $_POST['idProduct'] ?? null; 
    
    
    $userCheck = $conn->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
    $userCheck->bind_param("i", $idUser);
    $userCheck->execute();
    $userCheck->bind_result($userExists);
    $userCheck->fetch();
    $userCheck->close();

    if (!$userExists) {
        die("Error: The user does not exist.");
    }
    
    
    if ($idProduct) {
        $productCheck = $conn->prepare("SELECT COUNT(*) FROM products WHERE id = ?");
        $productCheck->bind_param("i", $idProduct);
        $productCheck->execute();
        $productCheck->bind_result($productExists);
        $productCheck->fetch();
        $productCheck->close();

        if (!$productExists) {
            die("Error: The product does not exist.");
        }
    }

    $sql = "INSERT INTO messages (idUser, idProduct, subject, messageText) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $idUser, $idProduct, $subject, $messageText);

    if ($stmt->execute()) {
        
        echo "Your message has been sent!";
        require("include/footer.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

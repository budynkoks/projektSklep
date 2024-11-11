<?php
require("include/session.php");
require("include/db.php");

if (!isset($_SESSION['id'])) {
    echo "Please log in first.";
    exit;
}

if (isset($_POST['product_id'])) {
    $idUser = $_SESSION['id'];
    $idProduct = $_POST['product_id'];

   
    $checkSql = "SELECT * FROM wishlist WHERE idUser = ? AND idProduct = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $idUser, $idProduct);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows === 0) {
       
        $sql = "INSERT INTO wishlist (idUser, idProduct) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $idUser, $idProduct);

        if ($stmt->execute()) {
            echo "Added to wishlist!"; 
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
     
        $deleteSql = "DELETE FROM wishlist WHERE idUser = ? AND idProduct = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("ii", $idUser, $idProduct);
        $deleteStmt->execute();
        
        echo "Item removed from wishlist!";
    }

    $checkStmt->close();
    $conn->close();
}
?>

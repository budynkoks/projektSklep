<?php
require("include/session.php");
require("include/db.php");

if (isset($_POST['product_id'])) {
    $idUser = $_SESSION['id'];
    $idProduct = $_POST['product_id'];

    $sql = "DELETE FROM wishlist WHERE idUser = ? AND idProduct = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUser, $idProduct);

    if ($stmt->execute()) {
        echo "Item removed from wishlist.";
    } else {
        echo "Error removing item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

header("Location: wishlist.php");
exit();
?>

<?php
require("include/session.php");
require("include/db.php");


if (isset($_POST['cartitem_id'])) {
    $cartItemId = $_POST['cartitem_id'];
    

    $sql = "DELETE FROM cartitems WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cartItemId);
    

    if ($stmt->execute()) {
        echo "Item removed successfully";
    } else {
        echo "Error removing item: " . $conn->error;
    }
    
    $stmt->close();
}


header("Location: cart.php");
exit();
?>

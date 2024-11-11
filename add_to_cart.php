<?php
require("include/session.php"); 
require("include/db.php");

if (isset($_POST['add_to_cart'])) {
    
    if (isset($_POST['product_id']) && isset($_POST['price'])) {
        $productId = intval($_POST['product_id']);
        $price = floatval($_POST['price']);

        
        if (isset($_SESSION['id'])) {
            $idUser = $_SESSION['id'];
            $idSession = session_id();; 
        } else {
            $idUser = null;
            $idSession = session_id();
        }

       
        $sql = "SELECT id FROM shoppingcart WHERE idUser = ? OR idSession = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $idUser, $idSession);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            
            $cart = $result->fetch_object();
            $cartId = $cart->id;
        } else {
           
            $sql = "INSERT INTO shoppingcart (idUser, idSession) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $idUser, $idSession);
            $stmt->execute();
            $cartId = $stmt->insert_id; 
        }

       
        $sql = "INSERT INTO cartitems (idProduct, idShoppingCart, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iid", $productId, $cartId, $price);
        $stmt->execute();

        
        header("Location: cart.php");
        exit(); 
    }
}
?>

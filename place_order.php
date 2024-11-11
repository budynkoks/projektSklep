<?php
require("include/header.php");


if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
} else {
    $idUser = null;
}
$session_id = session_id();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderDetails = $_POST['orderDetails'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];

    
    $sql = "SELECT ci.id, p.id AS product_id, ci.price 
            FROM cartitems ci 
            JOIN shoppingcart sc ON ci.idShoppingCart = sc.id 
            JOIN products p ON ci.idProduct = p.id 
            WHERE sc.idUser = ? AND sc.idSession = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $idUser, $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total = 0;
    $items = [];
    while ($row = $result->fetch_object()) {
        $items[] = $row;
        $total += $row->price;
    }
    $stmt->close();

    if (empty($items)) {
        echo "<p>Koszyk jest pusty. Nie możesz złożyć zamówienia.</p>";
    } else {
      
        $idStatus = 1;

       
        $order_sql = "INSERT INTO orders (idUsers, total, orderDetails, phoneNumber, email, idStatus) VALUES (?, ?, ?, ?, ?, ?)";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("idsssi", $idUser, $total, $orderDetails, $phoneNumber, $email, $idStatus);
        $order_stmt->execute();
        $order_id = $order_stmt->insert_id;
        $order_stmt->close();

        
        $order_item_sql = "INSERT INTO orderItems (idProduct, idOrder, price) VALUES (?, ?, ?)";
        $order_item_stmt = $conn->prepare($order_item_sql);
        foreach ($items as $item) {
            $order_item_stmt->bind_param("iid", $item->product_id, $order_id, $item->price);
            $order_item_stmt->execute();
        }
        $order_item_stmt->close();

     
        $clear_cart_sql = "DELETE FROM cartitems WHERE idShoppingCart = (SELECT id FROM shoppingcart WHERE idUser = ? AND idSession = ?)";
        $clear_cart_stmt = $conn->prepare($clear_cart_sql);
        $clear_cart_stmt->bind_param("is", $idUser, $session_id);
        $clear_cart_stmt->execute();
        $clear_cart_stmt->close();

        echo "<p>Twoje zamówienie zostało złożone pomyślnie!</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Dziękujemy za złożenie zamówienia!</h1>
    <p>Twoje zamówienie zostało pomyślnie złożone.</p>
    <a href="main.php">Wróć do strony głównej</a>
</body>
</html>

<?php require("include/footer.php"); ?>

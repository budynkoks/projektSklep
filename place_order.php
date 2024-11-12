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

    
    if ($idUser) {
        $sql = "SELECT ci.id AS cartitem_id, p.id AS product_id, ci.price 
                FROM cartitems ci 
                JOIN shoppingcart sc ON ci.idShoppingCart = sc.id 
                JOIN products p ON ci.idProduct = p.id 
                WHERE sc.idUser = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUser);
    } else {
        $sql = "SELECT ci.id AS cartitem_id, p.id AS product_id, ci.price 
                FROM cartitems ci 
                JOIN shoppingcart sc ON ci.idShoppingCart = sc.id 
                JOIN products p ON ci.idProduct = p.id 
                WHERE sc.idSession = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $session_id);
    }

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
        require("include/footer.php");
        exit();
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

        
        $delete_sql = "DELETE FROM cartitems WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);

        foreach ($items as $item) {
            $cartitem_id = $item->cartitem_id;
            $delete_stmt->bind_param("i", $cartitem_id);
            $delete_stmt->execute();
        }

        $delete_stmt->close();
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
    <h1 class="big">Dziękujemy za złożenie zamówienia!</h1>
    <p>Twoje zamówienie zostało pomyślnie złożone.</p>
    <a href="main.php">Wróć do strony głównej</a>
</body>
</html>

<?php require("include/footer.php"); ?>

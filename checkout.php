<?php
require("include/header.php");

if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
} else {
    $idUser = null; 
}
$session_id = session_id(); 

if ($idUser) {
    $sql = "SELECT ci.id, p.id AS product_id, p.product_name, p.image_main, ci.price, ci.addedAt 
            FROM cartitems ci 
            JOIN shoppingcart sc ON ci.idShoppingCart = sc.id 
            JOIN products p ON ci.idProduct = p.id 
            WHERE sc.idUser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUser);
} else {
    $sql = "SELECT ci.id, p.id AS product_id, p.product_name, p.image_main, ci.price, ci.addedAt 
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

$isCartEmpty = (count($items) === 0);

if ($isCartEmpty) {
    echo "<p>Koszyk jest pusty. Nie możesz przejść do realizacji zamówienia.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kasa</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
</head>
<body>
    <div class="container">
        <h1 class="big">Podsumowanie zamówienia</h1>

        <table>
            <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <a href="product_details.php?id=<?php echo $item->product_id; ?>">
                        <img src="images/<?php echo htmlspecialchars($item->image_main); ?>" alt="<?php echo htmlspecialchars($item->product_name); ?>" class="product-image">
                    </a>
                </td>
                <td>
                    <a href="product_details.php?id=<?php echo $item->product_id; ?>">
                        <?php echo htmlspecialchars($item->product_name); ?>
                    </a>
                </td>
                <td><?php echo number_format($item->price, 2); ?> PLN</td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p>Całkowita kwota: <?php echo number_format($total, 2); ?> PLN</p>

        <form action="place_order.php" method="post">
            <label for="orderDetails">Adres dostawy:</label>
            <textarea name="orderDetails" required></textarea><br>

            <label for="phoneNumber">Numer telefonu:</label>
            <input type="text" name="phoneNumber" required><br>

            <label for="email">E-mail:</label>
            <input type="email" name="email" value="<?php if (isset($_SESSION["email"])) { echo $_SESSION["email"]; } ?>" required><br>
            <p>Płatność przy odbiorze</p>
            <input type="submit" value="Złóż zamówienie" class="submit-btn">
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
require("include/footer.php");
?>

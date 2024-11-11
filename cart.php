<?php 
require("include/header.php");

$session_id = session_id(); 

if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
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
$isCartEmpty = ($result->num_rows === 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twój koszyk</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
</head>
<body>
    <div class="container">
        <h1 class="big">Twój koszyk</h1>

        <?php if ($isCartEmpty): ?>
            <p>Koszyk jest pusty.</p>
        <?php else: ?>
            <table>
                <?php while ($row = $result->fetch_object()): ?>
                <tr>
                    <td>
                        <a href="product_details.php?id=<?php echo $row->product_id; ?>">
                            <img src="images/<?php echo htmlspecialchars($row->image_main); ?>" alt="<?php echo htmlspecialchars($row->product_name); ?>" class="product-image">
                        </a>
                    </td>
                    <td>
                        <a href="product_details.php?id=<?php echo $row->product_id; ?>">
                            <?php echo htmlspecialchars($row->product_name); ?>
                        </a>
                    </td>
                    <td><?php echo number_format($row->price, 2); ?> PLN</td>
                    <td>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="cartitem_id" value="<?php echo $row->id; ?>">
                            <button type="submit" class="remove-btn">Usuń</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>

            <form action="checkout.php" method="post">
                <button type="submit" class="checkout-btn" <?php echo $isCartEmpty ? 'disabled' : ''; ?>>Do kasy</button>
            </form>
        <?php endif; ?>

        <a href="main.php" class="continue-shopping">Kontynuuj zakupy</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
require("include/footer.php");
?>

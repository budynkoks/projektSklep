<?php
require("include/header.php");

if (!isset($_SESSION['id'])) {
    echo "<p>Please log in to view your orders.</p>";
    exit();
}

$idUser = $_SESSION['id'];


$sql = "SELECT o.id, o.total, o.createdAt, o.orderDetails, o.phoneNumber, o.email, s.statusText 
        FROM orders o
        JOIN status s ON o.idStatus = s.id
        WHERE o.idUsers = ?
        ORDER BY o.createdAt DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Orders</title>
</head>
<body>
    <h1 class="big">Twoje zamówienia</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <div class="order">
                <h2 class="big">Szczegóły zamówienia:</h2>
                <p>Data złożenia zamówienia: <?php echo $order['createdAt']; ?></p>
                <p>Razem: <?php echo number_format($order['total'], 2); ?> PLN</p>
                <p>Status: <?php echo htmlspecialchars($order['statusText']); ?></p>
                <p>Adres dostawy: <?php echo htmlspecialchars($order['orderDetails']); ?></p>
                <p>Numer telefonu: <?php echo htmlspecialchars($order['phoneNumber']); ?></p>
                <p>Email: <?php echo htmlspecialchars($order['email']); ?></p>
                <p>Sposób zapłaty: Za pobraniem</p>

               
                <?php
                $orderId = $order['id'];
                $sql_items = "SELECT p.id AS product_id, p.product_name, p.image_main, oi.price
                              FROM orderitems oi
                              JOIN products p ON oi.idProduct = p.id
                              WHERE oi.idOrder = ?";
                $stmt_items = $conn->prepare($sql_items);
                $stmt_items->bind_param("i", $orderId);
                $stmt_items->execute();
                $items_result = $stmt_items->get_result();
                ?>

                <table>
                    
                    <?php while ($item = $items_result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="product_details.php?id=<?php echo $item['product_id']; ?>">
                                <img src="images/<?php echo htmlspecialchars($item['image_main']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" width="100">
                            </a>
                        </td>
                        <td>
                            <a href="product_details.php?id=<?php echo $item['product_id']; ?>">
                                <?php echo htmlspecialchars($item['product_name']); ?>
                            </a>
                        </td>
                        <td><?php echo number_format($item['price'], 2); ?> PLN</td>
                    </tr>
                    <?php endwhile; ?>
                </table>

                <?php $stmt_items->close(); ?>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nie masz żadnych zamówień.</p>
    <?php endif; ?>

    <a href="main.php">Wróć do strony głównej</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
require("include/footer.php");
?>

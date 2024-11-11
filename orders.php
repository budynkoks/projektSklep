<?php
require("include/header.php");


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Access denied.";
    exit();
}


$sql = "SELECT o.id, o.total, o.createdAt, o.orderDetails, o.phoneNumber, o.email, s.statusText, s.id AS status_id
        FROM orders o
        JOIN status s ON o.idStatus = s.id
        ORDER BY o.createdAt DESC";
$result = $conn->query($sql);


$statusOptions = $conn->query("SELECT id, statusText FROM status");
$statusList = [];
while ($statusRow = $statusOptions->fetch_assoc()) {
    $statusList[$statusRow['id']] = $statusRow['statusText'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zamówienia</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
    
</head>
<body>
    <h1 class="big">Wszystkie zamówienia</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <div class="order">
               <h2 class="big">Szczegóły zamówienia:</h2>
                <p>Data złożenia zamówienia: <?php echo $order['createdAt']; ?></p>
                <p>Razem: <?php echo number_format($order['total'], 2); ?> PLN</p>
                <form action="update_order_status.php" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <label for="status">Status:</label>
                    <select name="status_id" id="status">
                        <?php foreach ($statusList as $id => $statusText): ?>
                            <option value="<?php echo $id; ?>" <?php if ($id == $order['status_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($statusText); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Update Status">
                </form>
                <p>Adres dostawy: <?php echo htmlspecialchars($order['orderDetails']); ?></p>
                <p>Numer telefonu: <?php echo htmlspecialchars($order['phoneNumber']); ?></p>
                <p>Email: <?php echo htmlspecialchars($order['email']); ?></p>

             
               

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

                <?php
                $stmt_items->close();
                ?>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

    <a href="main.php">Back to the main page</a>
</body>
</html>

<?php
$conn->close();
require("include/footer.php");
?>

<?php require("include/header.php"); ?>

<?php
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if(isset($_SESSION['id'])){
    $idUser = $_SESSION['id'];
}

$sql = "SELECT p.id, p.product_name, p.price, p.image_main 
        FROM wishlist w 
        JOIN products p ON w.idProduct = p.id 
        WHERE w.idUser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ulubione</title>
</head>
<body>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <a href="product_details.php?id=<?php echo $row['id']; ?>">
                    <img src="images/<?php echo htmlspecialchars($row['image_main']); ?>"
                         alt="<?php echo htmlspecialchars($row['product_name']); ?>" 
                         style="width: 300px; height: auto;">
                    </a>
                    
                </td>
                <td><?php echo number_format($row['price'], 2); ?> PLN</td>
                <td>
                    <form action="remove_from_wishlist.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Brak ulubionych produktów.</p>
    <?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
<?php require("include/footer.php"); ?>

<?php
require("include/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['status_id'])) {
    $order_id = intval($_POST['order_id']);
    $status_id = intval($_POST['status_id']);

    $stmt = $conn->prepare("UPDATE orders SET idStatus = ? WHERE id = ?");
    $stmt->bind_param("ii", $status_id, $order_id);

    if ($stmt->execute()) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating order status.";
    }
    $stmt->close();
}
header("Location: orders.php");
exit();
?>

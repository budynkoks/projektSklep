<?php
require("include/db.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    
    $sql = "SELECT image_main FROM products WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_object();
        $main_image_path = "images/" . $row->image_main;
        if (file_exists($main_image_path)) {
            unlink($main_image_path);
        }
    }

    
    $additionalImagesSql = "SELECT imageUrl FROM product_images WHERE idProduct = $id";
    $additionalImagesResult = $conn->query($additionalImagesSql);
    while ($additionalRow = $additionalImagesResult->fetch_object()) {
        $additional_image_path = "images/" . $additionalRow->imageUrl;
        if (file_exists($additional_image_path)) {
            unlink($additional_image_path);
        }
    }

    
    $deleteAdditionalImagesSql = "DELETE FROM product_images WHERE idProduct = $id";
    $conn->query($deleteAdditionalImagesSql);

    
    $deleteProductSql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($deleteProductSql) === TRUE) {
        echo "Usunięto";
    } else {
        echo "Erorr: " . $conn->error;
    }
    
    $conn->close();
    header("Location: products.php");
    exit;
}
?>

<?php
require("include/db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $product_name = $_POST["product_name"];
    $description = $_POST["description"];
    $height = $_POST["height"];
    $width = $_POST["width"];
    $price = $_POST["price"];
    $idCategories = $_POST["idCategories"];

    $mainImage = basename($_FILES["image_main"]["name"]);
    $target_dir = "images/";
    $mainImageFile = $target_dir . $mainImage;
    $uploadOk = true;

   
    if ($mainImage) {
        if (!move_uploaded_file($_FILES["image_main"]["tmp_name"], $mainImageFile)) {
            echo "Sorry, there was an error uploading your main image.";
            $uploadOk = false;
        }
    } else {
       
        $sql = "SELECT image_main FROM products WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_object();
        $mainImage = $row->image_main;
    }

    if ($uploadOk) {
       
        $sql = "UPDATE products SET product_name=?, description=?, height=?, width=?, price=?, image_main=?, idCategories=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdddsii", $product_name, $description, $height, $width, $price, $mainImage, $idCategories, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully";

            
            if (!empty($_FILES['additional_images']['name'][0])) {
                foreach ($_FILES['additional_images']['name'] as $key => $additionalImageName) {
                    $additionalImageFile = $target_dir . basename($additionalImageName);

                    
                    if (move_uploaded_file($_FILES['additional_images']['tmp_name'][$key], $additionalImageFile)) {
                        
                        $sql = "INSERT INTO product_images (idProduct, imageUrl) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("is", $id, $additionalImageName);
                        $stmt->execute();
                    }
                }
            }

            header("Location: product_details.php?id=$id");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

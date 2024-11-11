<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $description = $_POST["description"];
    $height = $_POST["height"];
    $width = $_POST["width"];
    $price = $_POST["price"];
    $idCategories = $_POST["idCategories"];
    $idCondition = $_POST["idCondition"]; 

    $main_image = basename($_FILES["image_main"]["name"]);
    $target_dir = "images/";
    $target_main_file = $target_dir . $main_image;

    $conn = new mysqli("localhost", "root", "", "sklep");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    if (move_uploaded_file($_FILES["image_main"]["tmp_name"], $target_main_file)) {
        echo "The file " . htmlspecialchars($main_image) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading the main image.";
        exit;
    }
    

    $sql = "INSERT INTO products (product_name, description, height, width, price, image_main, idCategories, idCondition) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddssii", $product_name, $description, $height, $width, $price, $main_image, $idCategories, $idCondition);

    if ($stmt->execute()) {
        $product_id = $stmt->insert_id; 

       
        if (isset($_FILES['additional_images']) && $_FILES['additional_images']['error'][0] != UPLOAD_ERR_NO_FILE) {
            foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
                if ($_FILES["additional_images"]["error"][$key] == UPLOAD_ERR_OK) {
                    $additional_image = basename($_FILES["additional_images"]["name"][$key]);
                    $target_additional_file = $target_dir . $additional_image;

                   
                    if (move_uploaded_file($tmp_name, $target_additional_file)) {
                    
                        $sql_additional = "INSERT INTO product_images (idProduct, imageUrl) VALUES (?, ?)";
                        $stmt_additional = $conn->prepare($sql_additional);
                        $stmt_additional->bind_param("is", $product_id, $additional_image);
                        $stmt_additional->execute();
                        $stmt_additional->close();
                    } else {
                        echo "Error uploading additional image: " . $additional_image;
                    }
                }
            }
        }

        echo "New record created successfully";
        header("Location: products.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

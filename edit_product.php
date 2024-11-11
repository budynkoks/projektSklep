<?php
require("include/db.php");

$id = $_GET['id'];


$sql = "SELECT product_name, description, height, width, image_main, idCategories, price FROM products WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_object();


$imageSql = "SELECT imageUrl FROM product_images WHERE idProduct = $id";
$imageResult = $conn->query($imageSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
</head>
<body>
    
    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <p>Name: <input type="text" name="product_name" value="<?php echo $row->product_name; ?>"></p>
        
       
        <p>Current Main Image: <img src="images/<?php echo $row->image_main; ?>" alt="<?php echo $row->product_name; ?>"></p>
        <p>New Main Image: <input type="file" name="image_main"></p>
        
        <p>Description: <textarea name="description" rows="4" cols="50"><?php echo $row->description; ?></textarea></p>
        <p>Height: <input type="number" name="height" value="<?php echo $row->height; ?>"></p>
        <p>Width: <input type="number" name="width" value="<?php echo $row->width; ?>"></p>
        <p>Price: <input type="text" name="price" value="<?php echo $row->price; ?>"></p>

        
        <p>Category: <select name="idCategories">
            <?php
            $sql = "SELECT id, category_name FROM categories ORDER BY category_name ASC";
            $categoryResult = $conn->query($sql);
            while ($cat = $categoryResult->fetch_object()) {
                $selected = $cat->id == $row->idCategories ? "selected" : "";
                echo "<option value='{$cat->id}' $selected>{$cat->category_name}</option>";
            }
            ?>
        </select></p>

      
        <h3>Current Additional Images</h3>
        <div class="additional-images">
            <?php while ($imageRow = $imageResult->fetch_object()) : ?>
                <img src="images/<?php echo $imageRow->imageUrl; ?>" alt="Additional image for <?php echo $row->product_name; ?>">
            <?php endwhile; ?>
        </div>

        
        <p>New Additional Images: <input type="file" name="additional_images[]" multiple></p>
        
        <p><input type="submit" value="Update"></p>
    </form>
    <a href="products.php">Back to Home</a>
</body>
</html>

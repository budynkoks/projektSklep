<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Form</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
</head>
<body>
    <h2>Dodaj produkt</h2>
    <form action="insert_product.php" method="post" enctype="multipart/form-data">
        <p>Nazwa: <input type="text" name="product_name" required></p>
        <p>Obrazek główny: <input type="file" name="image_main" required></p>
        <p>Obrazki dodatkowe: <input type="file" name="additional_images[]" multiple></p>
        <p>Opis: <textarea name="description" rows="4" cols="50" required></textarea></p>
        <p>Szerokość: <input type="number" name="width" required></p>
        <p>Wysokość: <input type="number" name="height" required></p>
        <p>Cena: <input type="number" name="price" required step="0.01"></p>
        
        <p>Kategoria: 
            <select name="idCategories" required>
                <?php
                $conn = new mysqli("localhost", "root", "", "sklep");
                $sql = "SELECT id, category_name FROM categories ORDER BY category_name ASC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_object()) {
                    echo "<option value='{$row->id}'>{$row->category_name}</option>";
                }
                $conn->close();
                ?>
            </select>
        </p>

        <p>Stan: 
            <select name="idCondition" required>
                <?php
                $conn = new mysqli("localhost", "root", "", "sklep");
                $sql = "SELECT id, conditionText FROM conditionstate ORDER BY conditionText ASC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_object()) {
                    echo "<option value='{$row->id}'>{$row->conditionText}</option>";
                }
                $conn->close();
                ?>
            </select>
        </p>

        <p><input type="submit" value="Submit"></p>
    </form>
    <a href="products.php">Back to Home</a>
</body>
</html>

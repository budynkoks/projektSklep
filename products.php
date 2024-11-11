<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Antyki</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
  
</head>
<body>
    <?php require("include/header.php"); ?>

    <nav class="category-nav">
        <a href="products.php">Cały asortyment</a>
        
        
        <div class="dropdown">
            <a href="products.php?idCat=1">Żyrandole</a>
            <div class="dropdown-content">
                <a href="products.php?idCat=12">Lampy</a>
                <a href="products.php?idCat=13">Kinkiety</a>
            </div>
        </div>

      
        <div class="dropdown">
            <a href="products.php?idCat=2">Meble</a>
            <div class="dropdown-content">
                <a href="products.php?idCat=5">Szafy</a>
                <a href="products.php?idCat=6">Kredensy</a>
                <a href="products.php?idCat=7">Łoża</a>
                <a href="products.php?idCat=8">Komody</a>
                <a href="products.php?idCat=9">Stoły</a>
                <a href="products.php?idCat=10">Krzesła</a>
                <a href="products.php?idCat=11">Biurka</a>
            </div>
        </div>

        
        <a href="products.php?idCat=3">Obrazy</a>

      
        <a href="products.php?idCat=4">Rzeźby</a>
    </nav>

    <div class="search-container">
        <form method="get">
            <input type="text" name="fraza" placeholder="Wyszukaj produkty" value="<?= isset($_GET['fraza']) ? htmlspecialchars($_GET['fraza']) : '' ?>">
            <button type="submit">Wyszukaj</button>
        </form>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a class="add-product-link" href="insert_product_form.php">Dodaj przedmiot</a>
        <?php endif; ?>

    </div>

    <div class="product-list">
        <?php
      
        $categoryIds = [];

       
        if (isset($_GET["idCat"]) && is_numeric($_GET["idCat"])) {
            $categoryIds[] = $_GET["idCat"];
            $subCategoriesSql = "SELECT id FROM categories WHERE parent_id = ?";
            $subStmt = $conn->prepare($subCategoriesSql);
            $subStmt->bind_param("i", $_GET["idCat"]);
            $subStmt->execute();
            $subCategoriesResult = $subStmt->get_result();
            while ($subCatRow = $subCategoriesResult->fetch_object()) {
                $categoryIds[] = $subCatRow->id;
            }
            $subStmt->close();
        } elseif (isset($_GET["idSubCat"]) && is_numeric($_GET["idSubCat"])) {
            $categoryIds[] = $_GET["idSubCat"];
        }

 
        $sql = "SELECT id, product_name, image_main FROM products";
        if (!empty($categoryIds)) {
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
            $sql .= " WHERE idCategories IN ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat("i", count($categoryIds)), ...$categoryIds);
        } elseif (isset($_GET["fraza"])) {
            $sql .= " WHERE product_name LIKE ?";
            $stmt = $conn->prepare($sql);
            $fraza = "%{$_GET["fraza"]}%";
            $stmt->bind_param("s", $fraza);
        } else {
            $stmt = $conn->prepare($sql);
        }

    
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                echo "
                    <div class='product-item'>
                        <a href='product_details.php?id={$row->id}'>
                            <img src='images/{$row->image_main}' alt='" . htmlspecialchars($row->product_name) . "'>
                            <header>" . htmlspecialchars($row->product_name) . "</header>
                        </a>
                    </div>
                ";
            }
        } else {
            echo "<p class='no-results'>Brak wyników</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>

    <?php require("include/footer.php"); ?>
</body>
</html>

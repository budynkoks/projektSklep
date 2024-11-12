<?php 
require("include/header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT p.idCategories, c.category_name AS categoryName, p.product_name, p.image_main, p.description, p.height, p.width, p.price
        FROM products p 
        JOIN categories c ON p.idCategories = c.id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_object();

$imageSql = "SELECT imageUrl FROM product_images WHERE idProduct = ?";
$imageStmt = $conn->prepare($imageSql);
$imageStmt->bind_param("i", $id);
$imageStmt->execute();
$imageResult = $imageStmt->get_result();


$wishlistSql = "SELECT * FROM wishlist WHERE idUser = ? AND idProduct = ?";
$wishlistStmt = $conn->prepare($wishlistSql);
$wishlistStmt->bind_param("ii", $_SESSION['id'], $id);
$wishlistStmt->execute();
$wishlistResult = $wishlistStmt->get_result();
$isInWishlist = $wishlistResult->num_rows > 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
</head>
<body>

<div class="product-details">
    <a href="products.php">Meble</a> 
    <a href="products.php?idCat=<?php echo htmlspecialchars($row->idCategories); ?>"><?php echo htmlspecialchars($row->categoryName); ?></a></p>
    <h1><?php echo htmlspecialchars($row->product_name); ?></h1>
    
 
    <div class="product-image-container">
        <a href="javascript:void(0);" id="mainImageLink">
            <img id="mainImage" src="images/<?php echo htmlspecialchars($row->image_main); ?>" 
                 alt="<?php echo htmlspecialchars($row->product_name); ?>" class="main-image">
        </a>
        
        <div class="product-buttons">
            <form action="add_to_cart.php" method="post" id="contactForm">
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($row->price); ?>">
                <button type="submit" name="add_to_cart">Dodaj do koszyka</button>
            </form>
            </div>
            <?php if (isset($_SESSION["username"])): ?>
                <img id="wishlistHeart" 
                     src="images/<?php echo $isInWishlist ? 'icons8-heart-30red.png' : 'icons8-heart-50.png'; ?>" 
                     alt="Wishlist" 
                     style="cursor: pointer;" 
                     data-product-id="<?php echo $id; ?>" />
            <?php endif; ?>
        
    </div>
    
 
    <div class="additional-images">
        <img src="images/<?php echo htmlspecialchars($row->image_main); ?>" alt="Main image thumbnail" class="thumbnail">
        <?php while ($imageRow = $imageResult->fetch_object()) : ?>
            <img src="images/<?php echo htmlspecialchars($imageRow->imageUrl); ?>" 
                 alt="Additional image for <?php echo htmlspecialchars($row->product_name); ?>" 
                 class="thumbnail">
        <?php endwhile; ?>
    </div>
    
    <div id="lightbox" class="lightbox">
        <span class="close">&times;</span> 
        <img class="lightbox-content" id="lightboxImage">
    </div> 

    <p><strong>Opis:</strong> <?php echo htmlspecialchars($row->description); ?></p>
    <p><strong>Wysokość:</strong> <?php echo htmlspecialchars($row->height); ?> cm</p>
    <p><strong>Szerokość:</strong> <?php echo htmlspecialchars($row->width); ?> cm</p>
    <p><strong>Cena:</strong> <?php echo htmlspecialchars($row->price); ?> zł</p>


    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="edit_product.php?id=<?php echo $id; ?>">Edytuj</a>
        <a href="delete.php?id=<?php echo $id; ?>">Usuń</a>
    <?php endif; ?>

   
    <?php if (isset($_SESSION["username"])): ?>
    <div class="question-form">
        <h3>Zadaj pytanie o produkt</h3>
        <form action="send_message.php" method="post" id="contactForm">
            <label for="subject">Temat:</label>
            <input type="text" name="subject" id="subject" placeholder="Wpisz temat pytania..." required><br>
            
            <label for="messageText">Pytanie:</label>
            <textarea name="messageText" id="messageText" placeholder="Wpisz swoje pytanie tutaj..." required></textarea><br>
            
            <input type="hidden" name="idProduct" value="<?php echo $id; ?>">
            <button type="submit">Wyślij pytanie</button>
        </form>
    </div>
    <?php endif;?>  
</div>

<?php require("include/footer.php"); ?>
</body>
</html>

<?php
$stmt->close();
$imageStmt->close();
$wishlistStmt->close();
$conn->close();
?>

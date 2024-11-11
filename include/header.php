<?php
require("include/db.php");
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/styles.css"> 
   <title>Antyki</title>
</head>
<body>

<div class="navigation">
    <nav>
        <a href="main.php"><img src="images/Logo.webp" alt="Logo" class="logo"></a>
        <ul class="nav-links">
            <li><a href="products.php?idCat=2">Meble</a></li>
            <li><a href="products.php?idCat=1">Żyrandole</a></li>
            <li><a href="products.php?idCat=3">Obrazy</a></li>
            <li><a href="about_us.php">O nas</a></li>
            <li><a href="questions.php">Pytania</a></li>
            
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="orders.php">Zamówienia</a></li>
                <?php endif; ?>
            
            
            <li><a href="contact.php">Kontakt</a></li>
        </ul>
        <div class="icons">
            <a href="wishlist.php"><img src="images/icons8-love-96.png" alt="Wishlist"></a>
            <a href="account.php"><img src="images/icons8-account-96.png" alt="Account"></a>
            <a href="cart.php"><img src="images/icons8-basket-96.png" alt="Basket"></a>
            
            <?php if (isset($_SESSION["username"])): ?>
                <a href="logout.php" class="logout-button">Wyloguj</a>
            <?php endif; ?>
        </div>
    </nav>
</div> 

</body>
</html>

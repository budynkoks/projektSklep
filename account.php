<?php
require("include/header.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$idUser = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
    <style>
        
        .account-links {
            display: flex;
            gap: 20px; 
            justify-content: center; 
        }
        .account-links a {
            text-decoration: none;
            color: #000;
            font-size: 18px;
        }
        .account-links a:hover {
            color: #007BFF; 
        }

       
        .delete-account-form {
            display: flex;
            justify-content: center; 
            margin-top: 30px; 
        }
    </style>
</head>
<body>

<div class="container">
  
    <div class="account-links">
        <a href="user_orders.php">Zamówienia</a>
        <a href="questions.php">Pytania</a>
        <a href="wishlist.php">Ulubione</a>
        <a href="cart.php">Koszyk</a>
    </div>

   
    <div class="delete-account-form">
        <form method="post" action="delete_account.php" onsubmit="return confirm('Czy na pewno chcesz usunąć konto ?');">
            <input type="submit" value="Usuń konto" style="background-color: red; color: white;">
        </form>
    </div>
</div>

<?php require("include/footer.php"); ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
   
</head>
<body>
<?php require("include/header.php");?>
<?php
 require("include/db.php");
 if (isset($_POST["username"])) {
 $username = $_POST["username"];
 $password = $_POST["password"];
 $email = $_POST["email"];
 

 $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '" . md5($password) .
"', '$email')";
 $result = $conn->query($sql);
 if ($result) {
 echo "<div class='form'>
 <h3>Zostałeś pomyślnie zarejestrowany.</h3><br/>
 <p class='link'>Kliknij tutaj, aby się <a href='login.php'>zalogować</a></p>
 </div>";
 } else {
 echo "<div class='form'>
 <h3>Nie wypełniłeś wymaganych pól.</h3><br/>
 <p class='link'>Kliknij tutaj, aby ponowić próbę <a
href='registration.php'>rejestracji</a>.</p>
 </div>";
 }
 }
?>
<div class="form-container">
 <form class="form" action="" method="post">
 <h1 class="username-title">Rejestracja</h1>
 <input type="text" class="username-input" name="username" placeholder="username" required/>
 <input type="password" class="username-input" name="password" placeholder="Hasło"
required/>
 <input type="text" class="username-input" name="email" placeholder="Adres email"
required/>
 <input type="submit" name="submit" value="Zarejestruj się" class="username-button">
 <p class="link"><a href="login.php">Zaloguj się</a></p>
 </form>
</div>

    
</body>
</html>

<?php require("include/footer.php"); ?>
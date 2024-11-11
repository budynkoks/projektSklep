<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
  
    
</head>
<body>

<?php
require("include/header.php");
require("include/db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

   
    $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

   
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (md5($password) === $user['password']) {  
            
            
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $user["id"];
            $_SESSION["email"] = $user["email"]; 
            $_SESSION["role"] = $user["role"]; 
            header("Location: account.php");
            exit();
        } else {
            $error = "Nieprawidłowy login lub hasło.";
        }
    } else {
        $error = "Nieprawidłowy login lub hasło.";
    }
    $stmt->close();
}
?>
<div>
<div class="form-container">
    <form method="post" action="login.php">
        <h1>Logowanie</h1>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Nazwa użytkownika" required autofocus>
        <input type="password" name="password" placeholder="Hasło" required>
        <input type="submit" value="Zaloguj">
        <p class="link"><a href="registration.php">Zarejestruj się</a></p>
    </form>
</div>
</div>

<?php require("include/footer.php"); ?>

</body>
</html>

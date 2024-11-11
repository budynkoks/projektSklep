<?php
require("include/db.php");
require("include/session.php");



if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}


$idUser = $_SESSION['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn->begin_transaction();
    
    
     
        $deleteOrders = $conn->prepare("DELETE FROM orders WHERE idUsers = ?");
        $deleteOrders->bind_param("i", $idUser);
        $deleteOrders->execute();
        
        $deleteMessages = $conn->prepare("DELETE FROM messages WHERE idUser = ?");
        $deleteMessages->bind_param("i", $idUser);
        $deleteMessages->execute();
        
        
        
     
        $deleteUser = $conn->prepare("DELETE FROM users WHERE id = ?");
        $deleteUser->bind_param("i", $idUser);
        $deleteUser->execute();
        
       
        $conn->commit();
        
      
        session_destroy();
        header("Location: main.php");
        exit;
   
}


header("Location: main.php");
exit;
?>

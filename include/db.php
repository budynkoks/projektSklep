
<?php
 $conn = new mysqli("localhost", "root", "", "sklep");
 if ($conn->connect_error) {
 exit("Connection failed: " . $conn->connect_error);
 }
?>
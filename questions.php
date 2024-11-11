<?php
require("include/db.php");
require("include/header.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';


$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; 


if ($isAdmin) {
    if ($filter == 'unanswered') {
        $sql = "SELECT m.id, m.subject, m.messageText, m.sentAt, m.responseText, m.responseDate, u.username, p.product_name, p.id AS idProduct
                FROM messages m
                JOIN users u ON m.idUser = u.id
                LEFT JOIN products p ON m.idProduct = p.id
                WHERE m.responseText = 'Jeszcze nie ma odpowiedzi.'";
    } elseif ($filter == 'answered') {
        $sql = "SELECT m.id, m.subject, m.messageText, m.sentAt, m.responseText, m.responseDate, u.username, p.product_name, p.id AS idProduct
                FROM messages m
                JOIN users u ON m.idUser = u.id
                LEFT JOIN products p ON m.idProduct = p.id
                WHERE m.responseText != 'Jeszcze nie ma odpowiedzi.'";
    } else {
        $sql = "SELECT m.id, m.subject, m.messageText, m.sentAt, m.responseText, m.responseDate, u.username, p.product_name, p.id AS idProduct
                FROM messages m
                JOIN users u ON m.idUser = u.id
                LEFT JOIN products p ON m.idProduct = p.id";
    }
} else {
   
    if ($filter == 'unanswered') {
        $sql = "SELECT m.id, m.subject, m.messageText, m.sentAt, m.responseText, m.responseDate, p.product_name, p.id AS idProduct
                FROM messages m
                LEFT JOIN products p ON m.idProduct = p.id
                WHERE m.idUser = ? AND responseText = 'Jeszcze nie ma odpowiedzi.'";
    } elseif ($filter == 'answered') {
        $sql = "SELECT m.id, m.subject, m.messageText, m.sentAt, m.responseText, m.responseDate, p.product_name, p.id AS idProduct
                FROM messages m
                LEFT JOIN products p ON m.idProduct = p.id
                WHERE m.idUser = ? AND responseText != 'Jeszcze nie ma odpowiedzi.'";
    } else {
        $sql = "SELECT m.id, m.subject, m.messageText, m.sentAt, m.responseText, m.responseDate, p.product_name, p.id AS idProduct
                FROM messages m
                LEFT JOIN products p ON m.idProduct = p.id
                WHERE m.idUser = ?";
    }
}

$stmt = $conn->prepare($sql);


if (!$isAdmin) {
    $stmt->bind_param("i", $_SESSION['id']);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pytania</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="js/scripts.js"></script> 
</head>
<body>

<div class="container">
    

    <?php if ($isAdmin): ?>
        <h1 class="big">Pytania użytkowników</h1>
        <div class="filter-options">
            <a href="questions.php?filter=all">Wszystkie pytania</a> | 
            <a href="questions.php?filter=unanswered">Nieodpowiedziane pytania</a> | 
            <a href="questions.php?filter=answered">Odpowiedziane pytania</a>
        </div>
    <?php else: ?>
        <p>Przeglądaj swoje pytania.</p>
        <div class="filter-options">
            <a href="questions.php?filter=all">Wszystkie pytania</a> | 
            <a href="questions.php?filter=unanswered">Nieodpowiedziane pytania</a> | 
            <a href="questions.php?filter=answered">Odpowiedziane pytania</a>
        </div>
    <?php endif; ?>

    <div class="questions-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="question-item">
                    <h2 class="big">Temat: <?php echo htmlspecialchars($row['subject']); ?></h2>
                    <p><strong>Wiadomość:</strong> <?php echo nl2br(htmlspecialchars($row['messageText'])); ?></p>
                    <p><strong>Data wysłania:</strong> <?php echo $row['sentAt']; ?></p>
                    
                    <?php if (!empty($row['idProduct'])): ?>
                        <p><strong>Produkt:</strong> <a href="product_details.php?id=<?php echo $row['idProduct']; ?>"><?php echo htmlspecialchars($row['product_name']); ?></a></p>
                    <?php endif; ?>

                    <?php if ($isAdmin): ?>
                        <div class="response-section">
                            <h3>Odpowiedź</h3>
                            <form method="POST" action="respond_question.php">
                                <textarea name="responseText" placeholder="Wpisz odpowiedź"><?php echo htmlspecialchars($row['responseText']); ?></textarea>
                                <input type="hidden" name="questionId" value="<?php echo $row['id']; ?>">
                                <button type="submit">Wyślij odpowiedź</button>
                            </form>
                            <p><strong>Data odpowiedzi:</strong> <?php echo $row['responseDate']; ?></p>
                        </div>
                    <?php else: ?>
                        <p><strong>Odpowiedź:</strong> <?php echo nl2br(htmlspecialchars($row['responseText'])); ?></p>
                        <p><strong>Data odpowiedzi:</strong> <?php echo $row['responseDate']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Brak pytań do wyświetlenia.</p>
        <?php endif; ?>
    </div>
</div>

<?php require("include/footer.php"); ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

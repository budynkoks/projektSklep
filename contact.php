<?php require("include/header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
    <div class="container">
        <div class="contact-wrapper">
            <form action="send_message.php" method="post" class="contact-form">
                <input type="hidden" name="idUser" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>">

                <?php if (isset($_SESSION['email'])): ?>
                    <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                <?php else: ?>
                    <p>
                        <label for="email">Adres email:</label>
                        <input type="email" id="email" name="email" required>
                    </p>
                <?php endif; ?>

                <p>
                    <label for="subject">Temat:</label>
                    <input type="text" id="subject" name="subject" required>
                </p>

                <p>
                    <label for="messageText">Treść wiadomości:</label>
                    <textarea id="messageText" name="messageText" rows="5" required></textarea>
                </p>

                <p>
                    <button type="submit" class="submit-btn">Wyślij wiadomość</button>
                </p>
            </form>

            <div class="contact-info">
                <p><strong>Adres:</strong><br>
                Mokobody, ul. Księdza Brzóski 22<br>
                Mokobody 08-124</p>

                <p><strong>Dane kontaktowe</strong><br>
                Telefon - <a href="tel:+48885334813">555 555 555</a><br>
                Email - <a href="mailto:email@wp.pl">email@wp.pl</a></p>

                <p><strong>Godziny otwarcia</strong><br>
                Poniedziałek - sobota: 8:00 - 22:00<br>
                Niedziela: Zamknięte</p>
            </div>
        </div>
    </div>
</body>
</html>

<?php require("include/footer.php"); ?>

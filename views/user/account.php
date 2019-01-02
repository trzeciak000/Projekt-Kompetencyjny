<?php
    include '../../config.php';
    include '../../navbar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>What2Eat</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
    
</head>
<body>
    <!--dane uzytkownika (mozliwość edycji hasła, avatara itd????????) -->
    <div class="fullscreen">
        <h3>Panel użytkownika</h3>
        <center><h1>Witaj <?php echo $_SESSION['dane_usera']['login']; ?></h1></center><br />
        <a class = "btn btn-secondary" href="<?php echo ROOT_URL; ?>">Powrót do strony głównej</a><br /><br />
        <a class = 'btn btn-info' href="changepass.php">Zmień hasło</a>
    </div>
    <!-- JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/offcanvas.js"></script>
</body>
</html>
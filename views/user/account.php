<?php
    include '../../config.php';
?>
<!DOCTYPE html>
<html>
<?php include '../../layout/head.php'; ?>
<body>
    <?php include '../../layout/navbar.php'; ?>
    <!--dane uzytkownika (mozliwość edycji hasła, avatara itd????????) -->
    <div class="fullscreen">
        <h3>Panel użytkownika</h3>
        <center><h1>Witaj <?php echo $_SESSION['dane_usera']['login']; ?></h1></center><br />
        <a class = "btn btn-secondary" href="<?php echo ROOT_URL; ?>">Powrót do strony głównej</a><br /><br />
        <a class = 'btn btn-info' href="changepass.php">Zmień hasło</a>
    </div>
    
    <?php include '../../layout/scripts.php'; ?>
</body>
</html>
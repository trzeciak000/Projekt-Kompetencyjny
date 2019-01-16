<?php
    session_start();
    include '../../config.php';
?>
<!DOCTYPE html>
<html>
<?php include '../../layout/head.php'; ?>
<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="page-top-section setbg" style="background-image: url(<?php echo ROOT_URL; ?>img/page-top-bg.jpg);">
    	<div class="container">
    		<h2>Moje konto</h2>
    	</div>
    </section>
    
    <div class="fullscreen">
        <h1 class="text-center mt-5">Witaj <?php echo $_SESSION['dane_usera']['login']; ?></h1><br />
        <a class = "btn btn-secondary" href="<?php echo ROOT_URL; ?>">Powrót do strony głównej</a><br /><br />
        <a class = 'btn btn-info' href="changepass.php">Zmień hasło</a>
    </div>
    
    <?php include '../../layout/scripts.php'; ?>
</body>
</html>
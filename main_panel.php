<?php
    session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo ROOT_URL; ?>">What2eat</a>
    <div class="navbar panel" id="navbarText">
    <span class="navbar-text justify-content-end">
      <ul class="nav">
        <?php if(isset($_SESSION['zalogowany'])) : ?>
            <li><a class="nav-link" href="#">Witaj <?php echo $_SESSION['dane_usera']['login']; ?></a></li>
            <li><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/user/logout.php">Wyloguj</a></li>
        <?php else : ?>
            <li><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/user/logowanie.php">Logowanie</a></li>
            <li><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/user/rejestracja.php">Rejestracja</a></li>
        <?php endif; ?>
      </ul>
    </span>
</div>
</nav>
<?php
    session_start();
?>
<nav class="navbar navbar-dark bg-dark" id="main-navbar">
    <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>">What2Eat</a>
      
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        menu<span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT_URL; ?>searchsite.php">Znajdź przepis</a></li>
            <li class="nav item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/listall.php">Wsystkie przepisy</a></li>
            <li class="nav item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/losowy_przepis.php">Losowe danie</a></li>
            <?php if(isset($_SESSION['zalogowany'])) : ?>
                <li class="nav-item"><a class="nav-link" href="#">Witaj <?php echo $_SESSION['dane_usera']['login']; ?></a></li>
                <li class="nav item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/user/logout.php">Wyloguj</a></li>
            <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/user/logowanie.php">Zaloguj</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/user/rejestracja.php">Zarejestruj</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
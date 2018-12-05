<?php
    session_start();
?>
<nav id="mainNavbar" class="navbar navbar-light bg-light navbar-expand-lg">
	<a href="<?php echo ROOT_PATH; ?>" id="brand" class="navbar-brand ml-2 mr-auto">What2eat</a>

	<button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

    <div class="navbar-collapse collapse" id="navbarToggle" style="">
        <ul class="navbar-nav m-auto">
            <li class="nav-item mx-2"><a class="nav-link" href="<?php echo ROOT_PATH; ?>searchsite.php">Znajdź przepis</a></li>
            <li class="nav item mx-2"><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/listall.php">Wsystkie przepisy</a></li>
            <li class="nav item mx-2"><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/losowy_przepis.php">Losowe danie</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if(isset($_SESSION['zalogowany'])) : ?>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Witaj <?php echo $_SESSION['dane_usera']['login']; ?></a></li>
                <li class="nav item mx-2"><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/user/logout.php">Wyloguj</a></li>
            <?php else : ?>
                <li class="nav-item mx-2"><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/user/logowanie.php">Zaloguj</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="<?php echo ROOT_PATH; ?>views/user/rejestracja.php">Zarejestruj</a></li>
            <?php endif; ?>
        </ul>
	</div>
</nav>
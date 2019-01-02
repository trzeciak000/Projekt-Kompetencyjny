<?php
    session_start();
?>
<nav class="navbar navbar-light bg-white" id="main-navbar">
    
    <?php if(isset($_SESSION['zalogowany'])) : ?>
    
    <div class="dropdown show">
        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded-circle user-img" src="img/meal_icon.png" alt="username"> <!--tutaj zdjecie usera-->
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <span class="dropdown-item text-secondary"><?php echo $_SESSION['dane_usera']['login'];?></span>
            <a class="dropdown-item" href="<?php echo ROOT_URL; ?>views/user/account.php">Moje konto</a>
            <a class="dropdown-item" href="<?php echo ROOT_URL; ?>views/user/logout.php">Wyloguj</a>
        </div>
    </div>
    
    <?php endif; ?>
    
    <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>">What2Eat</a>
    
    <button class="navbar-toggler p-0 border-0 ml-auto" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT_URL; ?>searchsite.php">Znajdź przepis</a></li>
            <hr>
            <li class="nav item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/listall.php">Wsystkie przepisy</a></li>
            <hr>
            <li class="nav item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/losowy_przepis.php">Losowe danie</a></li>
            <hr>
            
            <?php if(isset($_SESSION['zalogowany'])) : ?>
            
            <li class="nav item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/user/logout.php">Wyloguj</a></li>
            
            <?php else : ?>
            
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/user/logowanie.php">Zaloguj</a></li>
            <hr>
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT_URL; ?>views/user/rejestracja.php">Zarejestruj</a></li>
            
            <?php endif; ?>
        </ul>
    </div>
</nav>
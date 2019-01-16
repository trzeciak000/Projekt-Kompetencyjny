<header class="header-section">
	<div class="header-top">
		<div class="container">
			<div class="header-social">
				<a href="#"><i class="fa fa-pinterest"></i></a>
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-linkedin"></i></a>
            </div>
			<div class="user-panel">
				<?php if(!isset($_SESSION['zalogowany'])) : ?>
				<a href="<?php echo ROOT_URL; ?>views/user/rejestracja.php">Rejestracja</a> / 
				<a href="<?php echo ROOT_URL; ?>views/user/logowanie.php">Logowanie</a>
				<?php else : ?>
				<a href="<?php echo ROOT_URL; ?>views/user/account.php"><?php echo $_SESSION['dane_usera']['login'] ?></a> / 
				<a href="<?php echo ROOT_URL; ?>views/user/logout.php">Wyloguj</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
			<a href="<?php echo ROOT_URL; ?>" class="site-logo">
				<img src="<?php echo ROOT_URL.'img/logo.png' ?>" alt="">
			</a>
			<div class="nav-switch">
				<i class="fa fa-bars"></i>
			</div>
			
			<ul class="main-menu">
				<li><a href="<?php echo ROOT_URL; ?>">Główna</a></li>
				<li><a href="<?php echo ROOT_URL; ?>views/listall.php">Wszyskie</a></li>
				<li><a href="<?php echo ROOT_URL; ?>views/listall.php">Wyszukaj</a></li>
				<li><a href="<?php echo ROOT_URL; ?>views/przepis.php?id=0">Losowy</a></li>
				<?php if(isset($_SESSION['zalogowany'])) : ?>
				<li><a href="<?php echo ROOT_URL; ?>search.php">Lodówka</a></li>
				<li><a href="<?php echo ROOT_URL; ?>wstaw_przepis.php">Dodaj przepis</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</header>
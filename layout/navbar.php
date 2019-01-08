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
				<a href="<?php echo ROOT_URL; ?>views/user/rejestracja.php">Rejestracja</a> / 
				<a href="<?php echo ROOT_URL; ?>views/user/logowanie.php">Logowanie</a>
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
			<div class="header-search">
				<a href="#"><i class="fa fa-search"></i></a>
			</div>
			<ul class="main-menu">
				<li><a href="<?php echo ROOT_URL; ?>">Główna</a></li>
				<li><a href="<?php echo ROOT_URL; ?>views/listall.php">Wszyskie</a></li>
				<li><a href="<?php echo ROOT_URL; ?>views/listall.php">Wyszukaj</a></li>
				<li><a href="<?php echo ROOT_URL; ?>przepis.php?id=0">Losowy</a></li>
			</ul>
		</div>
	</div>
</header>
<?php
	session_start();
	require 'config.php';
	include 'Flash.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
	$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY data_dodania DESC LIMIT 6";

	$result = $conn->query($sql);

    $przepisy = array();
    while($row = $result->fetch_assoc()){
        array_push($przepisy, $row);
    }

    $sql = "SELECT * FROM kategorie;";
    $result = $conn->query($sql);
    $kategorie = array();
    while($row = $result->fetch_assoc()){
        array_push($kategorie, $row);
	}
	
	$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY ocena DESC LIMIT 5";
	$result = $conn->query($sql);
	$best = array();
    while($row = $result->fetch_assoc()){
        array_push($best, $row);
	}
	
	$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY IDPrzepisu DESC LIMIT 5";
	$result = $conn->query($sql);
	$most = array();
    while($row = $result->fetch_assoc()){
        array_push($most, $row);
    }


	$count = count($przepisy);
?>

<!DOCTYPE html>
<html lang="pl">

<?php include 'layout/head.php'; ?>

<body>
	<?php Flash::display(); ?>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

    <?php include 'layout/navbar.php'; ?>

	<!-- Hero section -->
	<section class="hero-section">
		<div class="hero-slider owl-carousel">
			<div class="hero-slide-item setbg" style="background-image: url(img/slider-bg-1.jpg);">
				<div class="hs-text">
					<h2 class="hs-title-1"><span>Wspaniałe przepisy</span></h2>
					<h2 class="hs-title-2"><span>prosto od Grupy I</span></h2>
					<h2 class="hs-title-3"><span>dla wszystkich w tej sali :)</span></h2>
				</div>
			</div>
		</div>
	</section>
	<!-- Hero section end -->

	<!-- Recipes section -->
	<section class="recipes-section spad">
		<div class="container">
			<div class="section-title">
				<h2>Najnowsze przepisy</h2>
			</div>
			<div class="row">
				<?php foreach ($przepisy as $przepis) : ?>
				<?php
					$sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = ".$przepis['IDPrzepisu']." LIMIT 1;";
					$zdjecie = $conn->query($sql)->fetch_assoc();
					$zdjecie = $zdjecie['Link'];
				?>
				<div class="col-lg-4 col-md-6">
					<a href="<?php echo ROOT_URL.'views/przepis.php?id='.$przepis['IDPrzepisu']; ?>">
						<div class="recipe">
							<div class="recipe-image setbg" style="background-image: url(<?php echo ROOT_URL.'img/przepisy/'.$zdjecie ?>);"></div>
							<div class="recipe-info-warp">
								<div class="recipe-info">
									<h3 class="text-capitalize"><?php echo $przepis['Nazwa'] ?></h3>
									
								</div>
							</div>
						</div>
					</a>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!-- Recipes section end -->


	
	<section class="bottom-widgets-section spad">
		<div class="container">
			<div class="row">
				<div class="col-md-6 ftw-warp">
					<div class="section-title">
						<h3>Najwyżej oceniane</h3>
					</div>
					<ul class="sp-recipes-list">
						<?php foreach ($best as $przepis) : 
							$sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = ".$przepis['IDPrzepisu']." LIMIT 1;";
							$zdjecie = $conn->query($sql)->fetch_assoc();
							$zdjecie = $zdjecie['Link'];

							$phpdate = strtotime($przepis['data_dodania']);
							$mysqldate = date( 'd.m.Y', $phpdate);
						?>
						<li>
							<div class="rl-thumb setbg" style="background-image: url(<?php echo ROOT_URL.'img/przepisy/'.$zdjecie ?>)"></div>
							<div class="rl-info">
								<span><?php echo $mysqldate; ?></span>
								<a href="<?php echo ROOT_URL.'views/przepis.php?id='.$przepis['IDPrzepisu']; ?>"><h6 class="text-capitalize"><?php echo $przepis['Nazwa']; ?></h6></a>
								<div class="rating">
									<?php for ($i = 1; $i <= 5; $i++) {
										if ($i <= intval($przepis['ocena'])) {
											echo '<i class="fa fa-star"> </i>';
										} else {
											echo '<i class="fa fa-star is-fade"> </i>';
										}
									}
									?>
								</div>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-md-6 ftw-warp">
					<div class="section-title">
						<h3>Najczęściej robione</h3>
					</div>
					<ul class="sp-recipes-list">
						<?php foreach ($most as $przepis) : 
							$sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = ".$przepis['IDPrzepisu']." LIMIT 1;";
							$zdjecie = $conn->query($sql)->fetch_assoc();
							$zdjecie = $zdjecie['Link'];

							$phpdate = strtotime($przepis['data_dodania']);
							$mysqldate = date( 'd.m.Y', $phpdate);
						?>
						<li>
							<div class="rl-thumb setbg" style="background-image: url(<?php echo ROOT_URL.'img/przepisy/'.$zdjecie ?>)"></div>
							<div class="rl-info">
								<span><?php echo $mysqldate; ?></span>
								<a href="<?php echo ROOT_URL.'views/przepis.php?id='.$przepis['IDPrzepisu']; ?>"><h6 class="text-capitalize"><?php echo $przepis['Nazwa']; ?></h6></a>
								<div class="rating">
									<?php for ($i = 1; $i <= 5; $i++) {
										if ($i <= intval($przepis['ocena'])) {
											echo '<i class="fa fa-star"> </i>';
										} else {
											echo '<i class="fa fa-star is-fade"> </i>';
										}
									}
									?>
								</div>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!--
	<div class="gallery">
		<div class="gallery-slider owl-carousel">
			<div class="gs-item setbg" data-setbg="img/instagram/1.jpg"></div>
			<div class="gs-item setbg" data-setbg="img/instagram/2.jpg"></div>
			<div class="gs-item setbg" data-setbg="img/instagram/3.jpg"></div>
			<div class="gs-item setbg" data-setbg="img/instagram/4.jpg"></div>
			<div class="gs-item setbg" data-setbg="img/instagram/5.jpg"></div>
			<div class="gs-item setbg" data-setbg="img/instagram/6.jpg"></div>
		</div>
	</div>
	-->


	<?php include 'layout/footer.php' ?>
	<?php include 'layout/scripts.php' ?>
</body>
</html>
<?php
    include "../config.php";

	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$conn->query("SET CHARSET utf8");
	$przepis = array();
	$id = $_GET['id'];
	
	//jezeli random to losujemy id
	if($id == 0) {
		$sql = "SELECT COUNT(IDPrzepisu) AS row_count FROM przepisy;";
    	$row = $conn->query($sql)->fetch_assoc();
		$id = rand(1, intval($row['row_count']));	
	}
	
	$sql = "SELECT * FROM przepisy WHERE IDPrzepisu = ".$id.";";
	$przepis = $conn->query($sql)->fetch_assoc();

	$sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = ".($id)." LIMIT 1;";
    $zdjecie = $conn->query($sql)->fetch_assoc();
	$zdjecie = $zdjecie["Link"];
	
	$sql = "SELECT kategoria FROM kategorie WHERE id =" . $przepis['id_kategorii'] . " LIMIT 1;";
    $kat = $conn->query($sql)->fetch_assoc();
    $kat = $kat['kategoria'];

	$sql = "SELECT * FROM skladniki_przepisow as sp join skladniki as s on s.IDSkladnika=sp.IDSkladnika WHERE sp.IDPrzepisu=".$id.";";
    $ingredients = mysqli_fetch_all($conn->query($sql), MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="pl">

<?php include '../layout/head.php'; ?>

<body>

<?php include '../layout/navbar.php'; ?>

<section class="page-top-section set-bg" style="background-image: url(<?php echo ROOT_URL; ?>img/page-top-bg.jpg);">
	<div class="container">
		<h2>Przepis</h2>
	</div>
</section>
	
<!-- Recipe image view -->
<section class="recipe-view-section">
	<div class="rv-warp set-bg mt-5" style="background-image: url(<?php echo ROOT_URL.'img/przepisy/'.$zdjecie; ?>)"></div>
</section>

	<!-- Recipe details section -->
	<section class="recipe-details-section">
		<div class="container">
			<div class="recipe-meta">
				<div class="racipe-cata">
					<span><?php echo $kat ?></span>
				</div>
				<h2><?php echo $przepis['Nazwa']; ?></h2>
				<div class="recipe-date">15 Grudnia, 2018</div>
				<!--<div class="rating">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star is-fade"></i>
				</div>-->
			</div>
			<div class="row">
				<div class="col-lg-5">
					<div class="recipe-filter-warp">
						<div class="filter-top">
							<div class="filter-top-text">
								<p>Przygotowanie: <?php echo $przepis['CzasPrzygotowania']; ?></p>
								<p>Porcje: <?php echo $przepis['IloscPorcji']; ?></p>
							</div>
						</div>
						<!-- recipe filter form -->
						<div class="filter-form-warp">
							<h2>Składniki</h2>
							<form class="filter-form">
                                <?php foreach ($ingredients as $skladnik) : ?>
								<div class="check-warp">
									<input type="checkbox" id="one">
									<label for="one"><?php echo $skladnik["Nazwa"]." (".$skladnik["Ilosc"]." ".$skladnik["Jednostka"].")"; ?></label>
								</div>
                                <?php endforeach; ?>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-7">
					<ul class="recipe-info-list">
						
							<h2>Przygotowanie:</h2>
							<p><?php echo $przepis["Przygotowanie"] ?></p>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- Recipe details section end -->

<?php 
    include '../layout/footer.php';
    include '../layout/scripts.php'; 
?>
</body>
</html>
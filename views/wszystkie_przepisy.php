<?php
    require "../config.php";

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
	
	if($_POST['sortowanie'] == 0) {
		$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY Nazwa";
		$result = $conn->query($sql);
	} else if($_POST['sortowanie'] == 1) {
		$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY Nazwa DESC";
		$result = $conn->query($sql);
	} else if($_POST['sortowanie'] == 2) {
		$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY CzasPrzygotowania";
		$result = $conn->query($sql);
	} else if($_POST['sortowanie'] == 3) {
		$sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY CzasPrzygotowania DESC";
		$result = $conn->query($sql);
	}

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
	
?>
<?php foreach ($przepisy as $przepis) : ?>
<?php
	$sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = ".$przepis['IDPrzepisu']." LIMIT 1;";
	$zdjecie = $conn->query($sql)->fetch_assoc();
	$zdjecie = $zdjecie['Link'];
?>
<div class="col-lg-4 col-md-6">
	<a href="<?php echo ROOT_URL.'views/przepis.php?id='.$przepis['IDPrzepisu']; ?>">
		<div class="recipe">
			<img src="<?php echo ROOT_URL.'img/przepisy/'.$zdjecie; ?>" alt="no image">
			<div class="recipe-info-warp">
				<div class="recipe-info">
					<h3><?php echo $przepis['Nazwa']; ?></h3>
					<div class="rating">
						
					</div>
				</div>
			</div>
		</div>
	</a>
</div>
<?php endforeach; ?>
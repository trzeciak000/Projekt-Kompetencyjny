<?php
    require "../config.php";

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
	$sql = "SELECT * FROM przepisy WHERE visible = 1";

	switch ($_POST['sortowanie']) {
		case 0:
			$sql =  $sql." ORDER BY Nazwa";
			break;
		case 1:
			$sql =  $sql." ORDER BY Nazwa DESC";
			break;
		case 2:
			$sql =  $sql." ORDER BY CzasPrzygotowania";
			break;
		case 3:
			$sql =  $sql." ORDER BY CzasPrzygotowania DESC";
			break;
		default:
			break;
	}
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
	
	$count = count($przepisy);
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
			<div class="recipe-image setbg" style="background-image: url(<?php echo ROOT_URL.'img/przepisy/'.$zdjecie; ?>);"></div>
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


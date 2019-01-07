<?php
    require "../config.php";
    include "../navbar.php";
	include "wyswietl.php";
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
	$sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = '" . $przepis['IDPrzepisu'] . "' LIMIT 1;";
	$zdjecie = $conn->query($sql)->fetch_assoc();
	$zdjecie = $zdjecie['Link'];
?>
<div class="card">
	<img class="card-img-top"
		<?php if ($zdjecie == null || $zdjecie == "") : ?> src="<?php echo ROOT_PATH; ?>img/przepisy/brak.png"
		<?php else : ?> src="<?php echo ROOT_PATH; ?>img/przepisy/<?php echo $zdjecie; ?>"<?php endif; ?>
	>    
	<div class="card-body">
		<h5 class="card-title"><?php echo $przepis['Nazwa']; ?></h5>
		<p class="card-text"><?php echo $przepis['Opis'] ?></p>
		<p class="card-tex">
			<i class="fas fa-th"></i> <?php foreach($kategorie as $row) {if($row['id'] == $przepis['id_kategorii']){echo $row['kategoria']; break;}}?>
			<i class="far fa-clock"></i> <?php echo $przepis['CzasPrzygotowania']; ?>
		</p>
	</div>
	<a class="btn btn-info" href="przepis.php?id=<?php echo $przepis['IDPrzepisu']; ?>">Przejdź</a>
</div>
<?php endforeach; ?>
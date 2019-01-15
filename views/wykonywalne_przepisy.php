<?php
    require "../config.php";
	include "../Flash.php";

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
	if( !isset($_SESSION['zalogowany']) )
		Flash::setMessage('Musisz być zalogowany aby mieć dostęp do lodówki', 'error');
		exit();
	$IDuzytkownika = $_SESSION['dane_usera']['id'];
	
	$zapytanie = 
			"SELECT p.IDPrzepisu FROM przepisy AS p
			JOIN (
				SELECT sp.IDPrzepisu, COUNT(*) as IloscDostepnychSkladnikow FROM 
				skladniki_przepisow AS sp
				JOIN (
					SELECT * FROM magazyn WHERE IDUzytkownika=$IDuzytkownika
				) AS m ON sp.IDSkladnika=m.IDSkladnika
				GROUP BY IDPrzepisu 
			) AS a ON a.IDPrzepisu=p.IDPrzepisu
			WHERE p.IloscRodzajowSkladnikow=IloscDostepnychSkladnikow AND p.visible = 1 ";
	
	if($_POST['sortowanie'] == 0) {
		$sql = $zapytanie . "ORDER BY p.Nazwa";
		$result = $conn->query($sql);
	} else if($_POST['sortowanie'] == 1) {
		$sql = $zapytanie . "ORDER BY p.Nazwa DESC";
		$result = $conn->query($sql);
	} else if($_POST['sortowanie'] == 2) {
		$sql = $zapytanie . "ORDER BY p.CzasPrzygotowania";
		$result = $conn->query($sql);
	} else if($_POST['sortowanie'] == 3) {
		$sql = $zapytanie . "ORDER BY p.CzasPrzygotowania DESC";
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
	<a class="btn btn-info" href="przepis.php?id=<?php echo $przepis['IDPrzepisu']; ?>">PrzejdÅº</a>
</div>
<?php endforeach; ?>
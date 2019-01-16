<?php
	session_start();
    require "../config.php";
	  include "../Flash.php";

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
	if( !isset($_SESSION['zalogowany']) ){
		Flash::setMessage('Musisz być zalogowany aby mieć dostęp do lodówki', 'error');
		exit();
	}
	$IDuzytkownika = $_SESSION['dane_usera']['id'];
	
	$zapytanie = 
			"SELECT * FROM przepisy AS p
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
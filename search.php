<?php
session_start();
require "config.php";
require "Flash.php";

if(!isset($_SESSION['zalogowany'])) {
	Flash::setMessage('Zaloguj się aby korzystać z lodówki', 'info');
	header('Location: '.ROOT_URL);
	exit();
}
	
	$i = 0;
	$IDUzytkownika = $_SESSION['dane_usera']['id'];
	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!$conn) {
		die("Connection to server failed: " . mysqli_connect_error());
	}
    $conn->query("SET CHARSET utf8");
	$sql = 
	"SELECT s.Nazwa, m.Ilosc, m.Jednostka FROM
		(SELECT * FROM magazyn AS m WHERE IDUzytkownika=$IDUzytkownika ) AS m
	JOIN skladniki AS s ON s.IDSkladnika=m.IDSkladnika";
	$wynik = mysqli_query( $conn, $sql );
?>

<!doctype html>
<?php include 'layout/head.php'; ?>

<body>
<?php include 'layout/navbar.php'; ?>

<section class="page-top-section setbg" style="background-image: url(<?php echo ROOT_URL; ?>img/page-top-bg.jpg);">
	<div class="container">
		<h2>Moja Lodówka</h2>
	</div>
</section>

<section class="fridge-section spad">
    <div class="container p-4 bg-pink">
		<form action="proces_search.php" method="post" class="centeredform">
			
			<?php
				while($rzad = mysqli_fetch_assoc($wynik)) :
			?>
        	
			<div class="form-group row">
				<label class="col-sm-2 col-form-label font-weight-bold text-light">Składnik:</label>
				<div class="col-sm-4">
					<input type="text" placeholder="Nazwa" value="<?php echo $rzad['Nazwa'];?>" name="<?php echo "nazwa_".$i;?>" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Ilość:</label>
				<div class="col-sm-2">
					<input type="text" placeholder="1, 5.5, 200" value="<?php echo $rzad['Ilosc'];?>" name="<?php echo "ilosc_".$i;?>" pattern="^\d*\.?\d*$" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Jednostka:</label>
				<div class="col-sm-2">
					<input type="text" placeholder="g, kg, l, łyżki"  value="<?php echo $rzad['Jednostka'];?>" name="<?php echo "jednostka_".$i;?>" class="form-control">
    			</div>
			</div>

			<?php
				$i++;
				endwhile;
			?>
					
            <div class="form-group row">
				<label class="col-sm-2 col-form-label font-weight-bold text-light">Składnik:</label>
				<div class="col-sm-4">
					<input type="text" placeholder="Nazwa" name="<?php echo "nazwa_".$i;?>" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Ilość:</label>
				<div class="col-sm-2">
					<input type="text" placeholder="1, 5.5, 200" name="<?php echo "ilosc_".$i;?>" pattern="^\d*\.?\d*$" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Jednostka:</label>
				<div class="col-sm-2">
					<input type="text" placeholder="g, kg, l, łyżki" name="<?php echo "jednostka_".$i;?>" class="form-control">
    			</div>
			</div>

			<?php $i++; ?>

              <input id="iloscSkladnikow" type="number" name="ilosc_skladnikow" value="<?php echo $i?>" hidden>
			  <input type="text" name="id_uzytkownika" value="<?php echo $IDUzytkownika?>" hidden>
              <!--<button id="dodajButton" class="btn btn-info btn-block"><i class="fas fa-plus"></i></button>-->
			  <input type="button" class="btn btn-light btn-block" id="dodajButton" value="+">
			  <input type="submit" class="btn btn-dark btn-block" value="Dodaj składniki">
        </form>
    </div>
</section>

<?php include 'layout/scripts.php'; ?>
<script>
$(document).ready(function(){
	//dodawanie wierszy
    $("#dodajButton").click(function(){
		var is = $("#iloscSkladnikow").val();
        $("#dodajButton").before(`
			<div class="form-group row">
				<label class="col-sm-2 col-form-label font-weight-bold text-light">Składnik:</label>
				<div class="col-sm-4">
					<input type="text" placeholder="Nazwa" name="<?php echo "nazwa_".$i;?>" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Ilość:</label>
				<div class="col-sm-2">
					<input type="text" placeholder="1, 5.5, 200" name="<?php echo "ilosc_".$i;?>" pattern="^\d*\.?\d*$" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Jednostka:</label>
				<div class="col-sm-2">
					<input type="text" placeholder="g, kg, l, łyżki" name="<?php echo "jednostka_".$i;?>" class="form-control">
    			</div>
			</div>
		`);
		$("#iloscSkladnikow").val( parseInt(is) + 1);
    });
	
});
</script>
</body>
</html>
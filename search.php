<?php
session_start();
require "config.php";
require "Flash.php";

$i = 0;
if( isset($_SESSION['dane_usera']['id']) )
{
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

<section class="fridge-section">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-4">

            </div>
        </div>
    </div>
</section>
    
   
                <form action="proces_search.php" method="post" class="centeredform" >
<?php
	while( $rzad = mysqli_fetch_assoc( $wynik ) )
	{
?>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" 
						value="<?php echo $rzad['Nazwa'];?>"
						placeholder="Produkt"
						style="width: 120px" name="<?php echo "nazwa_" . $i;?>">
						
                    <div class="input-group-append">
                      <input type="text" pattern="^\d*\.?\d*$"
						class="input-group" value="<?php echo $rzad['Ilosc'];?>"
						placeholder="Ilosc"
						style="width: 60px" name="<?php echo "ilosc_" . $i;?>">
						
                      <div class="input-group-append">
                          <input type="text" class="input-group-text"
						  value="<?php echo $rzad['Jednostka'];?>"
						  placeholder="J."
						  style="width: 60px"
						  name="<?php echo "jednostka_" . $i;?>">
                      </div>
                    </div>
                  </div>
<?php
		$i++;
	}
}
?>
					
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" 
						placeholder="Produkt"
						style="width: 120px" name="<?php echo "nazwa_" . $i;?>">
						
                    <div class="input-group-append">
                      <input type="text" pattern="^\d*\.?\d*$"
						class="input-group" placeholder="Ilosc"
						style="width: 60px" name="<?php echo "ilosc_" . $i;?>">
						
                      <div class="input-group-append">
                          <input type="text" class="input-group-text"
						  placeholder="J."
						  style="width: 60px"
						  name="<?php echo "jednostka_" . $i;?>">
                      </div>
                    </div>
                  </div>
<?php $i++; ?>
                  <input id="iloscSkladnikow" type="number" name="ilosc_skladnikow" value="<?php echo $i?>" hidden>
				  <input type="text" name="id_uzytkownika" value="<?php echo $IDUzytkownika?>" hidden>
                  <!--<button id="dodajButton" class="btn btn-info btn-block"><i class="fas fa-plus"></i></button>-->
				  <input type="button" id="dodajButton" value="+">
				  <input type="submit" value="submit"
				  <?php if( !isset($_SESSION['dane_usera']['id']) )
						echo 'disabled';
					?>>
                </form>
            </div>


<?php include 'layout/scripts.php'; ?>
<script>
$(document).ready(function(){
	//dodawanie wierszy
    $("#dodajButton").click(function(){
		var is = $("#iloscSkladnikow").val();
        $("#dodajButton").before(`
			<div class="input-group mb-3">
				<input type="text" class="form-control" 
					placeholder="Produkt"
					style="120px" name="nazwa_${is}">
					
				<div class="input-group-append">
				  <input type="text" pattern="^\\d*\\.?\\d*$"
					class="input-group" placeholder="Ilosc"
					style="width: 60px" name="ilosc_${is}">
					
				  <div class="input-group-append">
					  <input type="text" class="input-group-text"
					  placeholder="J."
					  style="width: 60px"
					  name="jednostka_${is}">
				  </div>
				</div>
			</div>
		`);
		$("#iloscSkladnikow").val( parseInt(is) + 1);
    });
	
});
</script>
</body>
</html>
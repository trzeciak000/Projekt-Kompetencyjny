<?php
session_start();
require "config.php";
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
<html lang="pl">
  <head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>What2Eat</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body>
    <div class="fullscreen">
        <div class="container">
          <div class="row" style="align-items: center; justify-content: center;">
            <div class="col-md-4">
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




            <div class="col-md-7 text-center">
              <div class="row">

                <div class="col-md-4 mb-4">
                  <div class="square">
                    <a class="link" href="views/losowy_przepis.php">
                      <div class="content" style="background-image: url(https://i0.wp.com/slowcookergourmet.net/wp-content/uploads/2018/02/Instant-Pot-Spaghetti-4-of-5.jpg?resize=500%2C500&ssl=1); background-size: cover;">
                        <p class="text-light" style="font-size: 1.25rem">Spaghetti z kurczakiem</p> 
                      </div>
                    </a>
                  </div>          
                </div>

                <div class="col-md-4 mb-4">
                    <div class="square">
                      <div class="content" style="background-image: url(https://www.przyslijprzepis.pl/media/cache/default_view/uploads/media/recipe/0002/62/79806fd95cd24598bf6575ae4241e2c61431e811.jpeg); background-size: cover;">
                        <p class="text-light" style="font-size: 1.25rem">Tagliatelle z kurczakiem</p> 
                      </div>
                    </div>          
                  </div>

                  <div class="col-md-4 mb-4">
                      <div class="square">
                        <div class="content" style="background-image: url(https://www.przyslijprzepis.pl/media/cache/gallery_view/uploads/media/recipe/0001/81/f984bcfaab0c9e5762028335c594db70ede517ed.jpeg); background-size: cover;">
                          <p class="text-light" style="font-size: 1.25rem">Makaron smażony z kurczakiem</p> 
                        </div>
                      </div>          
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="square">
                          <div class="content" style="background-image: url(https://www.przyslijprzepis.pl/media/cache/gallery_view/uploads/media/recipe/0002/34/b1c877d349dc2e29f82ac47b1332bdd11c4ed0d2.jpeg); background-size: cover;">
                            <p class="text-light" style="font-size: 1.25rem">Noodle z orientalnym kurczakiem </p> 
                          </div>
                        </div>          
                      </div>

              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/all.min.js"></script>
	<script>
	window.onload = function() {
		if (window.jQuery) {  
		} else {
			// jQuery is not loaded
			alert("JQuery niezaladowane");
		}
	}
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
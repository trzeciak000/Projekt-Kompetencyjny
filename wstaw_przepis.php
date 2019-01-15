<?php
session_start();
include 'config.php';
include 'Flash.php';
?>

<!DOCTYPE html>
<html>
<?php include 'layout/head.php'; ?>
<body>
	<?php 
		include 'layout/navbar.php'; 
		Flash::display();
	?>
	<section class="page-top-section setbg" style="background-image: url(<?php echo ROOT_URL; ?>img/page-top-bg.jpg);">
		<div class="container">
			<h2>Dodaj przepis</h2>
		</div>
	</section>

	<div class="wrapper setbg py-5" style="background-image:url(img/slider-bg-1.jpg);">
	<div class="container p-4 bg-pink">
		<form action="proces_wstaw_przepis.php" method="post" enctype="multipart/form-data">
			<div class="custom-file mb-3">
  				<input type="file" class="custom-file-input" id="customFile" name="obraz" accept="image/*">
  				<label class="custom-file-label" for="customFile">Wybierz zdjęcie</label>
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Nazwa:</label>
    			<div class="col-sm-10">
    				<input type="text" name="nazwa" class="form-control" placeholder="Nazwa">
    			</div>
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Źródło:</label>
    			<div class="col-sm-10">
    				<input type="text" name="zrodlo" class="form-control" placeholder="Źródło">
    			</div>
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Czas przyrządzenia</label>
    			<div class="col-sm-10">
    				<input type="text" name="czas_przygotowania" pattern="^([0-1][0-9]|[2][0-3]):([0-5][0-9])$" class="form-control" placeholder="01:30">
    			</div>
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Ilość porcji:</label>
    			<div class="col-sm-10">
    				<input type="number" name="ilosc_porcji" class="form-control" placeholder="1">
    			</div>
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Kategoria:</label>
    			<div class="col-sm-10">
    				<input type="text" name="kategoria" class="form-control" placeholder="Kategoria">
    			</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label font-weight-bold text-light">Składnik:</label>
				<div class="col-sm-4">
					<input type="text" name="skladnik_0" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Ilość:</label>
				<div class="col-sm-2">
					<input type="text" name="ilosc_0" pattern="^\d*?\.?\d*$" class="form-control">
    			</div>
				<label class="col-sm-1 col-form-label font-weight-bold text-light">Jednostka:</label>
				<div class="col-sm-2">
					<input type="text" name="jednostka_0" class="form-control">
    			</div>
			</div>
			<div class="form-group" id="wierszDodajButtona">
				<input class="btn btn-block btn-light" type="button" id="dodajButton" value="+">
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Przygotowanie:</label>
    			<div class="col-sm-10">
					<textarea name="przygotowanie" rows="6" cols="30" class="form-control"></textarea>
    			</div>
			</div>
			<div class="form-group row">
    			<label class="col-sm-2 col-form-label font-weight-bold text-light">Opis:</label>
    			<div class="col-sm-10">
					<textarea name="opis" rows="6" cols="30" class="form-control"></textarea>
    			</div>
			</div>
			<input id="iloscSkladnikow" type="number" name="ilosc_skladnikow" value="1" hidden>
			<div class="form-group">
				<input class="btn btn-block btn-dark" type="submit" value="Dodaj przepis">
			</div>
		</form>
	</div>
	</div>
	
	<?php
	#dane LOGa. użyć przy testowaniu
	if( count($_GET) > 0 ){ Flash::setMessage($_GET['niepowodzenie'], 'error'); }
	if( count($_GET) > 0 ){ Flash::setMessage($_GET['powodzenie'], 'success'); }
	?>
	
	<?php include 'layout/scripts.php'; ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		$('#customFile').change(function() {
  			var i = $(this).prev('label').clone();
  			var file = $('#customFile')[0].files[0].name;
  			$(this).next('label').text(file);
		});

		$(document).ready(function(){
			//dodawanie wierszy
		    $("#dodajButton").click(function(){
				var is = $("#iloscSkladnikow").val();
		        $("#wierszDodajButtona").before(`
					<div class="form-group row">
						<label class="col-sm-2 col-form-label font-weight-bold text-light">Składnik:</label>
						<div class="col-sm-4">
							<input type="text" name="skladnik_${is}" class="form-control">
    					</div>
						<label class="col-sm-1 col-form-label font-weight-bold text-light">Ilość:</label>
						<div class="col-sm-2">
							<input type="text" name="ilosc_${is}" pattern="^\d*?\.?\d*$" class="form-control">
    					</div>
						<label class="col-sm-1 col-form-label font-weight-bold text-light">Jednostka:</label>
						<div class="col-sm-2">
							<input type="text" name="jednostka_${is}" class="form-control">
    					</div>
					</div>
				`);
				$("#iloscSkladnikow").val( parseInt(is) + 1);
		    });
		});
	</script>
</body>
</html>
<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html>
<?php include 'layout/head.php'; ?>
<body>
	<?php include 'layout/navbar.php'; ?>
	
	<form action="proces_wstaw_przepis.php" method="post" enctype="multipart/form-data">
		Zdjęcie: <input type="file" name="obraz" accept="image/*">
		<table>
		<tr> <td>Nazwa:</td><td><input type="text" name="nazwa"></td> <td></td> </tr>
		<tr> <td>Źródło:</td><td><input type="text" name="zrodlo"></td> <td></td> </tr>
		<tr> <td>Czas przygotowania:</td><td><input type="text" name="czas_przygotowania" pattern="^([0-1][0-9]|[2][0-3]):([0-5][0-9])$"></td> <td></td> </tr>
		<tr> <td>Ilość porcji:</td><td><input type="number" name="ilosc_porcji"></td> <td></td> </tr>
		<tr> <td>Kategoria:</td><td><input type="text" name="kategoria"></td> <td></td> </tr>
		<tr> <td>Skladnik</td> <td>ilość</td> <td>jednostka</td> </tr>
		<tr>
			<td><input type="text" name="skladnik_0"></td> 
			<td><input type="text" name="ilosc_0" pattern="^\d*\.?\d*$"></td>
			<td><input type="text" name="jednostka_0"></td>
		</tr>
		<tr id="wierszDodajButtona"> <td><input type="button" id="dodajButton" value="+"></td> <td></td> <td></td> </tr>
		</table>
		<table>
		<tr> <td>Przygotowanie:</td><td><textarea name="przygotowanie" rows="6" cols="30"></textarea></td> </tr>
		<tr> <td>Opis:</td><td><textarea name="opis" rows="6" cols="30"></textarea></td> </tr>
		</table>
		<input id="iloscSkladnikow" type="number" name="ilosc_skladnikow" value="1" hidden>
		<input type="submit" value="submit">
	</form>
	<p>
	<?php
	#dane LOGa. użyć przy testowaniu
	if( count($_GET) > 0 ){ echo $_GET['niepowodzenie']; }?>
	</p>
	<p>
	<?php
	if( count($_GET) > 0 ){ echo $_GET['powodzenie']; }?>
	</p>
	
	<?php include 'layout/scripts.php'; ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			//dodawanie wierszy
		    $("#dodajButton").click(function(){
				var is = $("#iloscSkladnikow").val();
		        $("#wierszDodajButtona").before(`
					<tr>
						<td><input type="text" name="skladnik_${is}"></td> 
						<td><input type="text" name="ilosc_${is}" pattern="^\\d*\\.?\\d*$"></td>
						<td><input type="text" name="jednostka_${is}"></td>
					</tr>
				`);
				$("#iloscSkladnikow").val( parseInt(is) + 1);
		    });
		});
	</script>
</body>
</html>
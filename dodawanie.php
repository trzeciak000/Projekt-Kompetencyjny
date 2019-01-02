<?php
include 'config.php';
mb_internal_encoding('UTF-8');

function string_obrobka($str)
{
	$str = mysql_real_escape_string($str);
	return $str;
}

function string_obrobka_case_insensitive($str)
{
	$str = mb_strtolower($str);
	$str = mysql_real_escape_string($str);
	return $str;
}

function id_skladnika_o_nazwie($nazwa, $conn)
{
	$sql = "SELECT IDSkladnika FROM skladniki WHERE Nazwa='$nazwa'";
	$wynik = mysqli_query( $conn, $sql );
	$i = 0;
	while( $rzad = mysqli_fetch_assoc( $wynik ) )
	{
		$id = $rzad['IDSkladnika'];
		$i++;
	}
	if($i == 0)
		$id = 'e0';
	else if($i > 1)
		$id = 'e1';
	return $id;
}

$text1 = '';
$text2 = '';

if( count($_POST) > 0 )
{
    $conn = mysqli_connect(DB_HOST,DB_USER, DB_PASS, DB_NAME);

    if (!$conn) {
		die("Connection to server failed: " . mysqli_connect_error());
	}
	
	$nazwa = string_obrobka_case_insensitive($_POST['nazwa']);
	$przygotowanie = string_obrobka($_POST['przygotowanie']);
	$opis = string_obrobka($_POST['opis']);
	$czas_przygotowania = $_POST['czas_przygotowania'];
	$ilosc_porcji = $_POST['ilosc_porcji'];
	if($ilosc_porcji == '' OR $ilosc_porcji < 1)
		$ilosc_porcji = 1;
	$zrodlo = string_obrobka($_POST['zrodlo']);
	$is = $_POST['ilosc_skladnikow'];
	
	$sql = "INSERT INTO przepisy (Nazwa, Przygotowanie, Opis, CzasPrzygotowania, IloscPorcji, Zrodlo) VALUES ( '$nazwa', '$przygotowanie', '$opis', '$czas_przygotowania', $ilosc_porcji, '$zrodlo' )";
	if( mysqli_query( $conn, $sql ) )
	{
		$text1 = 'Przepis dodany pomyślnie';
		
		$sql = "SELECT IDPrzepisu FROM przepisy WHERE Nazwa='$nazwa' AND Zrodlo='$zrodlo'";
		$i = 0;
		$wynik = mysqli_query( $conn, $sql );
		while( $rzad = mysqli_fetch_assoc( $wynik ) )
		{
			$id_przepisu = $rzad['IDPrzepisu'];
			$i++;
		}
		if($i == 1)
		{
			$faktyczna_ilosc_dodanych_skladnikow = 0;
			
			for ($j = 0; $j < $is; $j++) {
				$skladnik = string_obrobka_case_insensitive($_POST["skladnik_{$j}"]);
				$ilosc = $_POST["ilosc_{$j}"];
				$jednostka = string_obrobka($_POST["jednostka_{$j}"]);
				
				if($skladnik == '')
				{
					$text1 = $text1 . "\nLinia " . $j + 1 . " niedodana.";
					continue;
				}
				if($ilosc == '')
					$ilosc = 0;
				
				$id_skladnika = id_skladnika_o_nazwie( $skladnik, $conn );
				
				if($id_skladnika == 'e0')
				{
					$sql = "INSERT INTO skladniki (Nazwa) VALUES ( '$skladnik' )";
					if( mysqli_query( $conn, $sql ) )
						$text1 = $text1 . "<br>Składnik {$skladnik} dodany pomyślnie";
					
					$id_skladnika = id_skladnika_o_nazwie( $skladnik, $conn );
					if( $id_skladnika == 'e0' )
					{
						$text1 = $text1 . "<br>Dodanie skladnika o nazwie {$skladnik} zakończone niepowodzeniem.";
						continue;
					}
					else if( $id_skladnika == 'e1' )
					{
						$text1 = $text1 . "<br>Teraz mamy wiele składników o nazwie {$skladnik}. Obecne wersje algorytmów niedopuszczają tego.";
						continue;
					}
				}
				else if($id_skladnika == 'e1')
				{
					$text1 = $text1 . "<br>Istnieje wiele składników o nazwie {$skladnik}. Obecne wersje algorytmów niedopuszczają tego. Składnik niedodany.";
					continue;
				}
				
				$sql = "INSERT INTO skladniki_przepisow (IDPrzepisu, IDSkladnika, Jednostka, Ilosc) VALUES ( $id_przepisu, $id_skladnika, '$jednostka', $ilosc)";
				if( mysqli_query( $conn, $sql ) )
				{
					$text1 = $text1 . "<br>Składnik {$skladnik} dodany pomyślnie jako składnik przepisu.";
					$faktyczna_ilosc_dodanych_skladnikow++;
				}
				else
					$text1 = $text1 . "<br>Próba dodania składnika {$skladnik} jako składnik przepisu zakończona niepowodzeniem.<br>$sql";
			}
			
			if($faktyczna_ilosc_dodanych_skladnikow > 0)
			{
				$sql = "UPDATE Przepisy SET IloscRodzajowSkladnikow = $faktyczna_ilosc_dodanych_skladnikow WHERE IDPrzepisu={$id_przepisu}";
				if( mysqli_query( $conn, $sql ) )
					$text1 = $text1 . "<br>Przepis zaktualizowany o ilość rodzajów składników.";
				else
					$text1 = $text1 . "<br>Aktualizacja przepisu o ilość rodzajów składników zakończona niepowodzeniem.";
			}
			#pokazuje jak zapisał się opis przepisu
			$sql = "SELECT Przygotowanie FROM Przepisy WHERE IDPrzepisu={$id_przepisu}";
			$wynik = mysqli_query( $conn, $sql );
			$rzad = mysqli_fetch_assoc( $wynik );
			$text2 = $rzad['Przygotowanie'];
			$text2 = preg_replace( "/\r/", "<br>", $text2 );#przekształca znaki nowej lini na kod html
			$text2 = preg_replace( "/\n/", "", $text2 );
		}
		else
			$text1 = $text1 . " ale okazuje się że istnieje podobny z tego samego zródła. Składniki niedodane.";
	}
	else
		$text1 = 'Przepis nie dodany pomyślnie<br>' . $sql;
}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
$(document).ready(function(){
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

if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
}
		</script>
	</head>
	<body>
		<h1>Narzędzie Administratorskie</h1>
		<form action="dodawanie.php" method="post">
			<table>
			<tr> <td>Nazwa:</td><td><input type="text" name="nazwa"></td> <td></td> </tr>
			<tr> <td>Źródło:</td><td><input type="text" name="zrodlo"></td> <td></td> </tr>
			<tr> <td>Czas przygotowania:</td><td><input type="text" name="czas_przygotowania" pattern="^([0-1][0-9]|[2][0-3]):([0-5][0-9])$"></td> <td></td> </tr>
			<tr> <td>Ilość porcji:</td><td><input type="number" name="ilosc_porcji"></td> <td></td> </tr>
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
		<h5>
		LOG:
		</h5>
		<p>
		<?php echo $text1 ?>
		</p>
		<p>
		<?php echo $text2 ?>
		</p>
	</body>
</html>
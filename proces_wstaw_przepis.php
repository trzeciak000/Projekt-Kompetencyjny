<?php
//---------------------------------------------------------------------------------------------------------------------------------------------
include 'config.php';
mb_internal_encoding('UTF-8');
//---------------------------------------------------------------------------------------------------------------------------------------------
function string_obrobka($str, $conn)
{
	$str = mysqli_real_escape_string($conn, $str);
	return $str;
}

function string_obrobka_case_insensitive($str, $conn)
{
	$str = mb_strtolower($str);
	$str = mysqli_real_escape_string($conn, $str);
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

function id_kategorii_o_nazwie($nazwa, $conn)
{
	$sql = "SELECT id FROM kategorie WHERE kategoria='$nazwa'";
	$wynik = mysqli_query( $conn, $sql );
	$i = 0;
	while( $rzad = mysqli_fetch_assoc( $wynik ) )
	{
		$id = $rzad['id'];
		$i++;
	}
	if($i == 0)
		$id = 'e0';
	else if($i > 1)
		$id = 'e1';
	return $id;
}

//---------------------------------------------------------------------------------------------------------------------------------------------
//Połączenie z bazą danych

$powodzenie = '';
$niepowodzenie = '';
$conn = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->query("SET CHARSET utf8");

if (!$conn) {
	die("Connection to server failed: " . mysqli_connect_error());
}

//---------------------------------------------------------------------------------------------------------------------------------------------
//post do zmiennych

$nazwa = string_obrobka_case_insensitive($_POST['nazwa'], $conn);
$kategoria = string_obrobka_case_insensitive($_POST['kategoria'], $conn);
$przygotowanie = string_obrobka($_POST['przygotowanie'], $conn);
$opis = string_obrobka($_POST['opis'], $conn);
$czas_przygotowania = $_POST['czas_przygotowania'];
$ilosc_porcji = $_POST['ilosc_porcji'];
if($ilosc_porcji == '' OR $ilosc_porcji < 1)
	$ilosc_porcji = 1;
$zrodlo = string_obrobka($_POST['zrodlo'], $conn);
$is = $_POST['ilosc_skladnikow'];

$exit = 0;//decyduje czy wstrzymać dodanie przepiusu

//---------------------------------------------------------------------------------------------------------------------------------------------
//uzyskanie id kategorii z jej nazwy (jeśli brak tokowej to zostanie ona stworzona)

$id_kategorii = id_kategorii_o_nazwie($kategoria, $conn);
if( $id_kategorii == 'e0' )
{
	$sql = "INSERT INTO kategorie (kategoria) VALUES ( '$kategoria' )";
	if( mysqli_query( $conn, $sql ) )
	{
		$powodzenie = $powodzenie . "<br>kategoria {$kategoria} dodana pomyślnie";
		$id_kategorii = id_kategorii_o_nazwie($kategoria, $conn);
	}
	else
	{
		$niepowodzenie = $niepowodzenie . "<br>kategoria {$kategoria} nie dodana.";
		$exit = 1;
	}
}
else if( $id_kategorii == 'e1' )
{
	$niepowodzenie = $niepowodzenie . "<br>wiele kategorii o nazwie {$kategoria}.";
	$exit = 1;
}

//---------------------------------------------------------------------------------------------------------------------------------------------
//wprowadzenie przepisu

$sql = "INSERT INTO przepisy (Nazwa, Przygotowanie, Opis, CzasPrzygotowania, IloscPorcji, Zrodlo, id_kategorii) VALUES ( '$nazwa', '$przygotowanie', '$opis', '$czas_przygotowania', $ilosc_porcji, '$zrodlo', $id_kategorii )";
if( ($exit == 0) && mysqli_query( $conn, $sql ) )
{
	$powodzenie = $powodzenie . '<br>Przepis dodany pomyślnie';
	
	//uzyskanie id wprowadzonego przepisu poprzez jego nazwe i żródło
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
		//wprowadzanie składników przepisu. składniki bez nazwy niezostaną dodane.
		
		$faktyczna_ilosc_dodanych_skladnikow = 0;
		
		for ($j = 0; $j < $is; $j++) {
			//uzyskanie danych o składnikach
			$skladnik = string_obrobka_case_insensitive($_POST["skladnik_{$j}"], $conn);
			$ilosc = $_POST["ilosc_{$j}"];
			$jednostka = string_obrobka($_POST["jednostka_{$j}"], $conn);
			//składniki bez nazwy niezostaną dodane
			if($skladnik == '')
			{
				$text1 = $text1 . "<br>Linia " . $j + 1 . " niedodana.";
				continue;
			}
			//domyślna ilość: 0
			if($ilosc == '')
				$ilosc = 0;
			
			$id_skladnika = id_skladnika_o_nazwie( $skladnik, $conn );
			//jeżeli składnika o podanej nazwie niema w BD to zostanie on utworzony
			if($id_skladnika == 'e0')
			{
				$sql = "INSERT INTO skladniki (Nazwa) VALUES ( '$skladnik' )";
				if( mysqli_query( $conn, $sql ) )
					$powodzenie = $powodzenie . "<br>Składnik {$skladnik} dodany pomyślnie";
				
				$id_skladnika = id_skladnika_o_nazwie( $skladnik, $conn );
				if( $id_skladnika == 'e0' )
				{
					$niepowodzenie = $niepowodzenie . "<br>Dodanie skladnika o nazwie {$skladnik} zakończone niepowodzeniem.";
					continue;
				}
				else if( $id_skladnika == 'e1' )
				{
					$niepowodzenie = $niepowodzenie . "<br>Teraz mamy wiele składników o nazwie {$skladnik}. Obecne wersje algorytmów niedopuszczają tego.";
					continue;
				}
			}
			else if($id_skladnika == 'e1')
			{
				$niepowodzenie = $niepowodzenie . "<br>Istnieje wiele składników o nazwie {$skladnik}. Obecne wersje algorytmów niedopuszczają tego. Składnik niedodany.";
				continue;
			}
			//wprowadzenie skłądnika jako składnik przepisu
			$sql = "INSERT INTO skladniki_przepisow (IDPrzepisu, IDSkladnika, Jednostka, Ilosc) VALUES ( $id_przepisu, $id_skladnika, '$jednostka', $ilosc)";
			if( mysqli_query( $conn, $sql ) )
			{
				$powodzenie = $powodzenie . "<br>Składnik {$skladnik} dodany pomyślnie jako składnik przepisu.";
				$faktyczna_ilosc_dodanych_skladnikow++;
			}
			else
				$niepowodzenie = $niepowodzenie . "<br>Próba dodania składnika {$skladnik} jako składnik przepisu zakończona niepowodzeniem.<br>$sql";
		}
		//zaktualizowanie 
		if($faktyczna_ilosc_dodanych_skladnikow > 0)
		{
			$sql = "UPDATE Przepisy SET IloscRodzajowSkladnikow = $faktyczna_ilosc_dodanych_skladnikow WHERE IDPrzepisu={$id_przepisu}";
			if( mysqli_query( $conn, $sql ) )
				$powodzenie = $powodzenie . "<br>Przepis zaktualizowany o ilość rodzajów składników: $faktyczna_ilosc_dodanych_skladnikow";
			else
				$niepowodzenie = $niepowodzenie . "<br>Aktualizacja przepisu o ilość rodzajów składników zakończona niepowodzeniem.";
		}
//---------------------------------------------------------------------------------------------------------------------------------------------
		//obraz upload
		$folder_docelowy = 'img/przepisy/';
		$nazwa_pliku = 'przepis_' . $id_przepisu . '_' . $_FILES['obraz']['name'];
		$sciezka = $folder_docelowy . $nazwa_pliku;
		if (move_uploaded_file($_FILES['obraz']['tmp_name'], $sciezka))
		{
			$powodzenie = $powodzenie . "<br>Obraz zuploadowany pomyślnie";
			//wprowadzenie linku obrazu do bazy danych
			$sql = "INSERT INTO obrazy_przepisy (IDPrzepisu, Link) VALUES ( $id_przepisu, '$nazwa_pliku' )";
			if( mysqli_query( $conn, $sql ) )
			{
				$powodzenie = $powodzenie . "<br>Link do obrazu pomyślnie zapisany";
			}
			else
			{
				$niepowodzenie = $niepowodzenie . "<br>Link do obrazu niezapisany";
				if( unlink($sciezka) )
				{
					$powodzenie = $powodzenie . "<br>Obraz skasowany";
				}
				else
				{
					$niepowodzenie = $niepowodzenie . "<br>Pruba skasowania obrazu niepowiodła się";
				}
			}
		}
		else
		{ 
			$niepowodzenie = $niepowodzenie . "<br>Upload się nie powiódł";
		}
	}
	else
		$niepowodzenie = $niepowodzenie . "Okazuje się że istnieje podobny z tego samego zródła. Składniki niedodane.";
}
else
	$niepowodzenie = $niepowodzenie . '<br>Przepis nie dodany pomyślnie<br>' . $sql;

$get = array (
	'powodzenie' => $powodzenie,
	'niepowodzenie' => $niepowodzenie
);
header( 'Location: wstaw_przepis.php?' . http_build_query($get),true,303);
exit();
?>
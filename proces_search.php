<?php
//---------------------------------------------------------------------------------------------------------------------------------------------
include 'config.php';
mb_internal_encoding('UTF-8');
//---------------------------------------------------------------------------------------------------------------------------------------------
function string_obrobka($str, $conn)
{
	#$str = mysqli_real_escape_string($str, $conn);
	return $str;
}

function string_obrobka_case_insensitive($str, $conn)
{
	$str = mb_strtolower($str);
	#$str = mysqli_real_escape_string($str, $conn);
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
//---------------------------------------------------------------------------------------------------------------------------------------------
//Połączenie z bazą danych

$powodzenie = '';
$niepowodzenie = '';
$conn = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->query("SET CHARSET utf8");
if (!$conn) {
	die("Connection to server failed: " . mysqli_connect_error());
}
//wprowadzanie produktów. składniki bez nazwy niezostaną dodane.

$is = $_POST['ilosc_skladnikow'];
$powodzenie = $powodzenie . ' ' . $is;
$id_uzytkownika = $_POST['id_uzytkownika'];
if( $is > 0 )
{
	$sql = "DELETE FROM magazyn WHERE `IDUzytkownika`=$id_uzytkownika";
	if( mysqli_query( $conn, $sql ) )
		$powodzenie = $powodzenie . "<br>Dotychczasowe składniki usunięte";
}
for ($j = 0; $j < $is; $j++) {
	//uzyskanie danych o składnikach
	$skladnik = string_obrobka_case_insensitive($_POST["nazwa_{$j}"], $conn);
	$powodzenie = $powodzenie . ' ' . $skladnik;
	$ilosc = $_POST["ilosc_{$j}"];
	$jednostka = string_obrobka($_POST["jednostka_{$j}"], $conn);
	//składniki bez nazwy niezostaną dodane
	if($skladnik == '')
	{
		#$powodzenie = $powodzenie . "<br>Linia " . $j + 1 . " niedodana.";
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
	//wprowadzenie skłądnika do magazynu
	
	$sql = "INSERT INTO magazyn (IDUzytkownika, IDSkladnika, Jednostka, Ilosc) VALUES ( $id_uzytkownika, $id_skladnika, '$jednostka', $ilosc)";
	if( mysqli_query( $conn, $sql ) )
	{
		$powodzenie = $powodzenie . "<br>Składnik {$skladnik} dodany pomyślnie do magazynu.";
		$faktyczna_ilosc_dodanych_skladnikow++;
	}
	else
		$niepowodzenie = $niepowodzenie . "<br>Próba dodania składnika {$skladnik} do magazynu zakończona niepowodzeniem.<br>$sql";
}
$get = array (
	'powodzenie' => $powodzenie,
	'niepowodzenie' => $niepowodzenie
);
header( 'Location: search.php?' . http_build_query($get),true,303);
exit();
?>
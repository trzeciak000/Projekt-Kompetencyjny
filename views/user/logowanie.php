<?php
session_start();
require "../../config.php";
$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
$connect->query("SET CHARSET utf8");

function filtruj($zmienna) {
    if(get_magic_quotes_gpc()) $zmienna = stripslashes($zmienna);
    return mysqli_real_escape_string(mysqli_connect(DB_HOST,DB_USER,DB_PASS), htmlspecialchars(trim($zmienna)));
}

if (isset($_POST['submit'])) {
    $login = filtruj($_POST['name']);
    $haslo = filtruj($_POST['password']);
    if ($login != "" && $haslo != "") {
        if (mysqli_num_rows(mysqli_query($connect, "SELECT Nazwa, Haslo FROM uzytkownicy WHERE Nazwa = '".$login."' AND Haslo = '".md5($haslo)."';")) > 0) {
            $sql = "SELECT IDUzytkownika, Nazwa, role_id FROM uzytkownicy WHERE Nazwa='" . $login . "';";
            $result = $connect->query($sql)->fetch_assoc();
            $_SESSION['zalogowany'] = true;
            $_SESSION['dane_usera'] = array(
                "id" => $result['IDUzytkownika'],
                "Nazwa" => $result['Nazwa'],
                "role_id" => $result['role_id']
            );
        }
        else echo "Wpisano złe dane.";
    } else {
        echo "Uzupełnij wszystkie pola.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
</head>
<body>
<?php if( !isset($_SESSION['zalogowany']) ) : ?>
    <div class="panel2">
        <div class="panel-heading">
            <h3 class="panel-title">Login</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="logowanie.php">
                <div class="form-group">
                    <label>Nazwa użytkownika</label>
                    <input type="text" name="name" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Hasło:</label>
                    <input type="password" name="password" class="form-control" />
                </div>
                <input class="btn btn-primary" name="submit" type="submit" value="Submit">
            </form>
        </div>
    </div>
<?php else : ?>
    Jesteś zalogowany.
    <form method="post" action="logout.php">
        <input type="submit" name="submit" value="Wyloguj">
    </form>

<?php endif; ?>
</body>
</html>
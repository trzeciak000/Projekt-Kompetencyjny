<?php
    require "../../config.php";
    include "../../main_panel.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
</head>
<body>
<?php if ( !isset($_SESSION['zalogowany'])) : ?>
<div class="panel2"><br /><br />
    <div class="panel-heading">
        <h3 class="panel-title">Zarejestruj nowe konto:</h3>
    </div>
    <div class="panel-body">
        <form method="post" action="rejestracja.php">
            <div class="form-group">
                <label>Nazwa użytkownika</label>
                <input type="text" name="name" class="form-control" />
            </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control" />
            </div>
            <div class="form-group">
                <label>Powtórz hasło</label>
                <input type="password" name="password2" class="form-control" />
            </div>
            <input class="btn btn-primary" name="submit" type="submit" value="Zarejestruj">
        </form>
    </div>
</div>
<?php else : ?>
Jesteś aktualnie zalogowany.
    <form method="post" action="logout.php">
        <input type="submit" name="submit" value="Wyloguj">
    </form>
<?php endif; ?>
</body>
</html>

<?php
    $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    $connect->query("SET CHARSET utf8");

    function filtruj($zmienna) {
        if(get_magic_quotes_gpc()) $zmienna = stripslashes($zmienna);
            return mysqli_real_escape_string(mysqli_connect(DB_HOST,DB_USER,DB_PASS), htmlspecialchars(trim($zmienna)));
    }


    if (isset($_POST['submit']))
    {
        $login = filtruj($_POST['name']);
        $haslo1 = filtruj($_POST['password']);
        $haslo2 = filtruj($_POST['password2']);

        if ($login != "" && $haslo1 != "" && $haslo2 != "") {
            if (mysqli_num_rows(mysqli_query($connect, "SELECT Nazwa FROM uzytkownicy WHERE Nazwa = '" . $login . "';")) == 0) {
                if ($haslo1 == $haslo2) {
                    $sql = "INSERT INTO uzytkownicy (Nazwa, Haslo) VALUES ('" . $login . "', '" . md5($haslo1) . "');";
                    mysqli_query($connect, $sql);
                    echo "Konto zostało utworzone! Możesz przejść do logowania.";
                } else echo "Hasła nie są takie same.";
            } else echo "Podany login jest już zajęty.";
        } else echo "Wszystkie pola są wymagane.";
    }

?>
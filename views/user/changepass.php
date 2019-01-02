<?php
    include '../../config.php';
    include '../../navbar.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>What2Eat</title>

        <!-- CSS -->
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/custom.css">
    </head>
    <body>
        <div class="fullscreen">
            <br />
            <a class="btn btn-secondary" href="account.php">Powrót</a><br /><br />
            <form method="post" action="changepass.php">
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Obecne hasło">
                </div>

                <div class="form-group">
                    <input name="password2" type="password" class="form-control" placeholder="Nowe hasło">
                </div>

                <div class="form-group">
                    <input name="password3" type="password" class="form-control" placeholder="Powtórz nowe hasło">
                </div>

                <button name="submit" type="submit" class="btn btn-outline-dark btn-block mb-4">Zmień hasło</button>
            </form>
        </div>

        <!-- JavaScripts -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/all.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/offcanvas.js"></script>
    </body>
</html>
<?php
include '../../config.php';
include '../../navbar.php';
$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
$connect->query("SET CHARSET utf8");

function filtruj($zmienna) {
    if(get_magic_quotes_gpc()) $zmienna = stripslashes($zmienna);
    return mysqli_real_escape_string(mysqli_connect(DB_HOST,DB_USER,DB_PASS), htmlspecialchars(trim($zmienna)));
}

if(isset($_POST['submit'])){
    $haslo1 = filtruj($_POST['password']);
    $haslo2 = filtruj($_POST['password2']);
    $haslo3 = filtruj($_POST['password3']);

    if($haslo1 != '' && $haslo2 != '' && $haslo3 != ''){
        if(md5($haslo1) == $_SESSION['dane_usera']['password']){
            if($haslo2 == $haslo3){
                $sql = 'UPDATE uzytkownicy SET Haslo = "' . md5($haslo2) . '" WHERE IDUzytkownika = ' . $_SESSION['dane_usera']['id'] . ';';
                $connect->query($sql);
                header('Location: ' . ROOT_URL);
            } else {
                echo "Nowe hasła się nie zgadzają.";
            }
        } else {
            echo "Stare hasło nieprawidłowe.";
        }
    } else {
        echo "Wszystkie pola są wymagane.";
    }
}
?>
<?php
    require "../../config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>What2Eat | Rejestracja</title>
    
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
</head>

<body>
<?php if ( !isset($_SESSION['zalogowany'])) : ?>
    <div class="fullscreen d-flex align-items-center" style="background:url('../../img/food_bg_blurred.jpg') no-repeat fixed center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 m-auto text-center bg-light">
                    <h4 class="text-dark my-4">Utwórz konto</h4>
                    <form method="post" action="rejestracja.php">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control" placeholder="Nazwa użytkownika">
                        </div>
    
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" placeholder="Hasło">
                        </div>
    
                        <div class="form-group">
                            <input name="password" type="password2" class="form-control" placeholder="Powtórz hasło">
                        </div>
    
                        <button name="submit" type="submit" class="btn btn-outline-dark btn-block mb-4">Zarejestruj</button>
                    </form>
                    
                    <p class="text-secondary mb-4">
                        Masz już konto? <a class="text-info" href="<?php echo ROOT_PATH; ?>views/user/logowanie.php">Zaloguj się</a><br>
                        Rejestrując się akceptujesz <a class="text-info" href="">Regulamin</a>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>

<?php else : ?>
Jesteś aktualnie zalogowany.
    <form method="post" action="logout.php">
        <input type="submit" name="submit" value="Wyloguj">
    </form>
<?php endif; ?>

    <!-- JavaScript -->
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/custom.js"></script>
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
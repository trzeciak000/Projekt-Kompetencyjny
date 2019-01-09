<?php
session_start();
require "../../config.php";

if(isset($_SESSION['zalogowany'])){
    $_SESSION['errMsg'] = "Jesteś już zalogowany!";
    header("Location: ".ROOT_URL);
}

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
            $sql = "SELECT IDUzytkownika, Nazwa, role_id, Haslo FROM uzytkownicy WHERE Nazwa='" . $login . "';";
            $result = $connect->query($sql)->fetch_assoc();
            var_dump($result);
            $_SESSION['zalogowany'] = true;
            $_SESSION['dane_usera'] = array(
                "id" => $result['IDUzytkownika'],
                "login" => $result['Nazwa'],
                "role_id" => $result['role_id'],
                "password" => $result['Haslo']
            );
            header("Location: ".ROOT_URL);
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
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>What2Eat | Logowanie</title>
    
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
</head>

<body>
    <div class="fullscreen d-flex align-items-center" style="background:url('../../img/food_bg_blurred.jpg') no-repeat fixed center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 m-auto text-center bg-light">
                    <?php if ( !isset($_SESSION['zalogowany'])) : ?>
                    <h4 class="text-dark my-4">Zaloguj się</h4>
                    <form method="post" action="logowanie.php">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control" placeholder="Nazwa użytkownika">
                        </div>
    
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" placeholder="Hasło">
                        </div>
    
                        <button name="submit" type="submit" class="btn btn-outline-dark btn-block mb-4">Zaloguj</button>
                    </form>
                    
                    <p class="text-secondary mb-4">
                        Nie masz konta? <a class="text-info" href="<?php echo ROOT_PATH; ?>views/user/rejestracja.php">Zarejestruj się</a><br>
                        
                    </p>
                    <?php else : ?>
                        Jesteś aktualnie zalogowany.<br />
                        <a href="<?php echo ROOT_URL; ?>">Powrót do strony głównej.</a>
                        <form method="post" action="logout.php">
                            <input type="submit" name="submit" value="Wyloguj">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



    <!-- JavaScript -->
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/custom.js"></script>
</body>
</html>
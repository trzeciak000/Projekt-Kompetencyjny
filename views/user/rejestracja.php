<?php
session_start();
require "../../config.php";
include "../../Flash.php";

if(isset($_SESSION['zalogowany'])){
    Flash::setMessage("Jesteś już zalogowany!", 'info');
    header("Location: ".ROOT_URL);
    exit();
}

$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
$connect->query("SET CHARSET utf8");

function filtruj($zmienna) {
    if(get_magic_quotes_gpc()) $zmienna = stripslashes($zmienna);
        return mysqli_real_escape_string(mysqli_connect(DB_HOST,DB_USER,DB_PASS), htmlspecialchars(trim($zmienna)));
}

if (isset($_POST['submit'])) {
    $login = filtruj($_POST['name']);
    $haslo1 = filtruj($_POST['password']);
    $haslo2 = filtruj($_POST['password2']);
    if ($login != "" && $haslo1 != "" && $haslo2 != "") {
        if (mysqli_num_rows(mysqli_query($connect, "SELECT Nazwa FROM uzytkownicy WHERE Nazwa = '" . $login . "';")) == 0) {
            if ($haslo1 == $haslo2) {
                $sql = "INSERT INTO uzytkownicy (Nazwa, Haslo) VALUES ('" . $login . "', '" . md5($haslo1) . "');";
                mysqli_query($connect, $sql);
                Flash::setMessage("Konto zostało utworzone! Możesz się zalogować.", "success");
                header("Location: ".ROOT_URL."views/user/logowanie.php");
                exit();
            } else Flash::setMessage("Hasła nie są takie same.", 'error');
        } else Flash::setMessage("Podany login jest już zajęty.", 'error');
    } else Flash::setMessage("Wszystkie pola są wymagane.", 'error');
}
?>

<!DOCTYPE html>
<html>

<?php include '../../layout/head.php'; ?>

<body>
    <?php Flash::display(); ?>
    <div class="fullscreen d-flex align-items-center" style="background:url('../../img/slider-bg-1.jpg') no-repeat fixed center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 m-auto text-center bg-pink">
                    <h2 class="text-light my-4">Utwórz konto</h2>
                    <form class="" method="post" action="rejestracja.php">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control form-control-lg" placeholder="Nazwa użytkownika">
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control form-control-lg" placeholder="Hasło">
                        </div>
                        <div class="form-group">
                            <input name="password2" type="password" class="form-control form-control-lg" placeholder="Powtórz hasło">
                        </div>
                        <button name="submit" type="submit" class="btn btn-dark btn-block btn-lg mb-4">Zarejestruj</button>
                    </form>
                    <p class="text-light font-weight-bold mb-4">
                        Masz już konto? <a class="text-dark" href="<?php echo ROOT_PATH; ?>views/user/logowanie.php">Zaloguj się</a><br>
                        Rejestrując się akceptujesz <a class="text-dark" href="">Regulamin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


<?php include '../../layout/scripts.php'; ?>
</body>
</html>
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
    $haslo = filtruj($_POST['password']);
    if ($login != "" && $haslo != "") {
        if (mysqli_num_rows(mysqli_query($connect, "SELECT Nazwa, Haslo FROM uzytkownicy WHERE Nazwa = '".$login."' AND Haslo = '".md5($haslo)."';")) > 0) {
            $sql = "SELECT IDUzytkownika, Nazwa, role_id, Haslo FROM uzytkownicy WHERE Nazwa='" . $login . "';";
            $result = $connect->query($sql)->fetch_assoc();
            $_SESSION['zalogowany'] = true;
            $_SESSION['dane_usera'] = array(
                "id" => $result['IDUzytkownika'],
                "login" => $result['Nazwa'],
                "role_id" => $result['role_id'],
                "password" => $result['Haslo']
            );
            header("Location: ".ROOT_URL);
            exit();
        }
        else Flash::setMessage("Wpisano błędne dane!", 'error');
    } else {
        Flash::setMessage("Uzupełnij wszystkie pola!", 'error');
    }
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
                    <h2 class="text-light my-4">Zaloguj się</h2>
                    <form method="post" action="logowanie.php">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control form-control-lg" placeholder="Nazwa użytkownika">
                        </div>
    
                        <div class="form-group">
                            <input name="password" type="password" class="form-control form-control-lg" placeholder="Hasło">
                        </div>
    
                        <button name="submit" type="submit" class="btn btn-dark btn-block btn-lg mb-4">Zaloguj</button>
                    </form>
                    
                    <p class="text-light font-weight-bold mb-4">
                        Nie masz konta? <a class="text-dark " href="<?php echo ROOT_URL; ?>views/user/rejestracja.php">Zarejestruj się</a><br>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <?php include '../../layout/scripts.php' ?>
</body>
</html>
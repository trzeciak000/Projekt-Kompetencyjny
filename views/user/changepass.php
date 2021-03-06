<?php
    include '../../config.php';
    include '../../Flash.php';
?>
<!DOCTYPE html>
<html>
<?php include '../../layout/head.php'; ?>
    <body>
    <?php include '../../layout/navbar.php'; ?>
    <?php Flash::display(); ?>
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

        <?php include '../../layout/scripts.php'; ?>
    </body>
</html>
<?php
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
                Flash::setMessage("Pomyślnie zmieniono hasło.", "success");
                header('Location: ' . ROOT_URL);
            } else {
                Flash::setMessage("Nowe hasła się nie zgadzają.", "error");
            }
        } else {
            Flash::setMessage("Stare hasło nieprawidłowe.", "error");
        }
    } else {
        Flash::setMessage("Wszystkie pola są wymagane.","error");
    }
}
?>
<?php
    require "config.php";
    include "navbar.php";
?>
<!doctype html>
<html lang="pl">
    <head>
        <!-- meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>What2Eat</title>

        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/custom.css">

    </head>
    
    <body>
        <div class="fullscreen d-flex align-items-center" style="background:url('img/food_bg_blurred.jpg') no-repeat fixed center; background-size: cover;">
            <div class="container" style="height: 80%;">
                <div class="row justify-content-around" style="height: 100%;">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 align-self-start">
                        <div class="bg-white p-4">
                            <h2 class="h2 text-center mb-4">Przegląd lodówki</h2>
                            <div class="icon-to-icon mb-4">
                                <img class="rounded-circle" src="img/fridge_icon.png" alt="">
                                <i class="fas fa-angle-right fa-3x" ></i>
                                <img class="rounded-circle" src="img/meal_icon.png" alt="">
                            </div>
                            <p>Coś zalega Ci w lodówce i nie masz pomysłu jak to wykorzystać? Znajdź go tutaj!</p>
                            <a href="<?php echo ROOT_URL; ?>search.php" class="btn btn-danger btn-block btn-lg">Zacznij teraz</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 align-self-end">
                        <div class="bg-white p-4">
                            <h2 class="h2 text-center mb-4">Chcesz więcej?</h2>
                            <div class="icon-to-icon mb-4">
                                <img class="rounded-circle" src="img/user_gray.png" alt="">
                                <i class="fas fa-angle-right fa-3x" ></i>
                                <img class="rounded-circle" src="img/user_color.png" alt="">
                            </div>
                            <p>Nie bądź szarakiem!<br>Zarejestruj się w aplikacji aby uzyskać dostęp ukrytych pereł kulinarnego świata i innych osób, które z praktycznie niczego robią coś dobrego!</p>
                            <a href="<?php echo ROOT_URL; ?>views/user/logowanie.php" class="btn btn-outline-info btn-lg">Logowanie</a>
                            <a href="<?php echo ROOT_URL; ?>views/user/rejestracja.php" class="btn btn-info btn-lg">Rejestracja</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- JavaScript -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/all.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/offcanvas.js"></script>
    </body>
</html>
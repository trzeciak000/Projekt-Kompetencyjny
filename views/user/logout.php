<?php
    session_start();
    include '../../config.php';
    unset($_SESSION['zalogowany']);
    unset($_SESSION['dane_usera']);
    session_destroy();
    //redirect
    header('Location: '.ROOT_URL);
    exit();
?>
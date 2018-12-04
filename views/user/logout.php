<?php
    session_start();
    unset($_SESSION['zalogowany']);
    unset($_SESSION['dane_usera']);
    session_destroy();
    //redirect
    header('Location: ../../index.php');
?>
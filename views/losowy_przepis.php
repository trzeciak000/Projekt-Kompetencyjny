<?php
    include "../config.php";
    include "../navbar.php";
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
    $sql = "SELECT * FROM przepisy WHERE visible=1;";
    $result = $conn->query($sql);
    $przepisy = array();
    while($row = $result->fetch_assoc()){
        array_push($przepisy, $row);
    }
    $losowy = rand(0,sizeof($przepisy)-1);
    $przepis = $przepisy[$losowy];
    $sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu =" . ($losowy + 1) . " LIMIT 1;";
    $zdjecie = $conn->query($sql)->fetch_assoc();
    $zdjecie = $zdjecie["Link"];
?>

<!doctype html>
<html lang="pl">
  <head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>What2Eat</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
  </head>
  <body>
    <div class="fullscreen">
        <div class="col-lg-3 col-sm-6 left">
            <?php if($zdjecie == null || $zdjecie == "") : ?>
                <img src="../img/przepisy/brak.png" width="200" height="200">
            <?php else : ?>
                <img src="../img/przepisy/<?php echo $zdjecie; ?>" alt="../img/przepisy/brak.png" width="200" height="200">
            <?php endif; ?>
        </div>
        <div class="col-lg-9 col-sm-18 right">
            <h2>Nazwa:</h2>
            <?php echo $przepis["Nazwa"]; ?><br /><br />
            <h4>Opis:</h4>
            <?php
                if($przepis["Opis"] == "") echo "brak opisu";
                else echo $przepis["Opis"];
            ?><br /><br />
            <h4>Porcji:</h4>
            <?php echo $przepis["IloscPorcji"]; ?><br /><br />
            <h4>Czas przygotowania:</h4>
            <?php echo $przepis["CzasPrzygotowania"]; ?><br /><br />
            <h4>Przygotowanie :</h4>
            <?php echo $przepis["Przygotowanie"]; ?>
        </div>
    </div>
    

    <!-- JavaScript -->
    <script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>

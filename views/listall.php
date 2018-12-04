<?php
    require "../config.php";
    include "../main_panel.php";
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
    $sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY Nazwa";
    $result = $conn->query($sql);

    if(isset($_POST['sortuj'])){
        if($_POST['sortowanie'] == 0) {
            $sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY Nazwa";
            $result = $conn->query($sql);
        } else if($_POST['sortowanie'] == 1) {
            $sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY Nazwa DESC";
            $result = $conn->query($sql);
        } else if($_POST['sortowanie'] == 2) {
            $sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY CzasPrzygotowania";
            $result = $conn->query($sql);
        } else if($_POST['sortowanie'] == 3) {
            $sql = "SELECT * FROM przepisy WHERE visible = 1 ORDER BY CzasPrzygotowania DESC";
            $result = $conn->query($sql);
        }
    }

    $przepisy = array();
    while($row = $result->fetch_assoc()){
        array_push($przepisy, $row);
    }

    $sql = "SELECT * FROM kategorie;";
    $result = $conn->query($sql);
    $kategorie = array();
    while($row = $result->fetch_assoc()){
        array_push($kategorie, $row);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Wszystkie przepisy</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
</head>
<body>
<br /><br />
<!--<form method="post" action="listall.php">-->
<!--    <label>Zobacz wg kategorii: </label>-->
<!--    <select name="category">-->
<!--        <option value="0">all</option>-->
<!--        --><?php //foreach ($kategorie as $cat) : ?>
<!--            <option value="--><?php //echo $cat['id']; ?><!--">--><?php //echo $cat['kategoria']; ?><!--</option>-->
<!--        --><?php //endforeach; ?>
<!--    </select>-->
<!--    <input class="btn btn-primary" type="submit" name="kategoria" value="Zobacz">-->
<!--</form><br />-->
<form method="post" action="listall.php">
    <label>Sortuj według: </label>
    <select name="sortowanie">
        <option value="0">Nazwy A-Z</option>
        <option value="1">Nazwy Z-A</option>
        <option value="2">Czasu rosnąco</option>
        <option value="3">Czasu malejąco</option>
    </select>
    <input class="btn btn-primary" type="submit" name="sortuj" value="Sortuj">
</form><br /><br />
<?php foreach ($przepisy as $przepis) : ?>
    <?php
        $sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = '" . $przepis['IDPrzepisu'] . "' LIMIT 1;";
        $zdjecie = $conn->query($sql)->fetch_assoc();
        $zdjecie = $zdjecie['Link'];
    ?>
    <div style="display: flex">
        <div class="col-lg-3 col-sm-6 left">
            <?php if ($zdjecie == null || $zdjecie == "") : ?>
            <img src="<?php echo ROOT_URL; ?>img/przepisy/brak.png" alt="<?php echo ROOT_URL; ?>img/przepisy/brak.png" width="150px" height="150px">
            <?php else : ?>
            <img src="<?php echo ROOT_URL; ?>img/przepisy/<?php echo $zdjecie; ?>" alt="<?php echo ROOT_URL; ?>img/przepisy/brak.png" width="150px" height="150px">
            <?php endif; ?>
            <br /><br />
        </div>
        <div class="col-lg-9 col-sm-18 right">
            <b>Nazwa: </b><?php echo $przepis['Nazwa']; ?><br /><br />
            <small><b>Kategoria: </b><?php foreach($kategorie as $row) {if($row['id'] == $przepis['id_kategorii']){echo $row['kategoria']; break;}}?></small><small><b> Czas przygotowania:</b> <?php echo $przepis['CzasPrzygotowania']; ?></small><br />
            <b>Opis: </b><?php echo $przepis['Opis'] ?><br /><br />
        </div>
    </div>
<?php endforeach; ?>



</body>
</html>

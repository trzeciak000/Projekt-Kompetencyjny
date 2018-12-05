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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>What2Eat | Przepisy</title>
    
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
</head>
<body>
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
    <div class="fullscreen" style="overflow-y: scroll;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-lg-6">
                    <h4 class="text-dark">Przepisy</h4>
                    <form method="post" action="listall.php">
                        <div class="form-row align-items-center">
                            <div class="col-md-3">
                                <label class="text-dark">Sortuj według </label>
                            </div>
                            <div class="col-md-5">
                                <select name="sortowanie" type="text" class="form-control">
                                    <option value="0">Nazwa A-Z</option>
                                    <option value="1">Nazwa Z-A</option>
                                    <option value="2">Czas rosnąco</option>
                                    <option value="3">Czas malejąco</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button name="sortuj" type="submit" class="btn btn-outline-dark btn-block">Sortuj</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-columns">
                <?php foreach ($przepisy as $przepis) : ?>
                <?php
                    $sql = "SELECT Link FROM obrazy_przepisy WHERE IDPrzepisu = '" . $przepis['IDPrzepisu'] . "' LIMIT 1;";
                    $zdjecie = $conn->query($sql)->fetch_assoc();
                    $zdjecie = $zdjecie['Link'];
                ?>
                <div class="card">
                    <img class="card-img-top"
                        <?php if ($zdjecie == null || $zdjecie == "") : ?> src="<?php echo ROOT_PATH; ?>img/przepisy/brak.png"
                        <?php else : ?> src="<?php echo ROOT_PATH; ?>img/przepisy/<?php echo $zdjecie; ?>"<?php endif; ?>
                    >    
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $przepis['Nazwa']; ?></h5>
                        <p class="card-text"><?php echo $przepis['Opis'] ?></p>
                        <p class="card-tex">
                            <i class="fas fa-th"></i> <?php foreach($kategorie as $row) {if($row['id'] == $przepis['id_kategorii']){echo $row['kategoria']; break;}}?>
                            <i class="far fa-clock"></i> <?php echo $przepis['CzasPrzygotowania']; ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/all.min.js"></script>
    <script src="../js/custom.js"></script>
</body>
</html>

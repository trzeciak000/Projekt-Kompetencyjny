<?php 
    session_start();
    include '../config.php';
?>

<!DOCTYPE html>
<html>
<?php include '../layout/head.php' ?>
<body>
<<<<<<< HEAD
<?php include '../layout/navbar.php' ?>
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
                                <label class="text-dark">Pokaż </label>
                            </div>
                            <div class="col-md-5">
                                <select name="pokaz" id="pokazSelect" type="text" class="form-control"
								<?php if( !isset($_SESSION['dane_usera']['id']) )
										echo 'disabled';
								?>>
                                    <option value="0">Wszystkie</option>
                                    <option value="1">Dające się zrealizować</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="col-md-3">
                                <label class="text-dark">Sortuj według </label>
                            </div>
                            <div class="col-md-5">
                                <select name="sortowanie" id="sortSelect" type="text" class="form-control">
                                    <option value="0">Nazwa A-Z</option>
                                    <option value="1">Nazwa Z-A</option>
                                    <option value="2">Czas rosnąco</option>
                                    <option value="3">Czas malejąco</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <!--<button name="sortuj" type="submit" class="btn btn-outline-dark btn-block">Sortuj</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
=======
    <?php include '../layout/navbar.php' ?>


	<!-- Hero section -->
	<section class="page-top-section setbg" style="background-image: url(<?php echo ROOT_URL.'img/page-top-bg.jpg' ?>);">
		<div class="container">
			<h2>Przepis</h2>
		</div>
	</section>
	<!-- Hero section end -->

>>>>>>> gui

	<!-- Search section -->
	<div class="search-form-section">
		<div class="sf-warp">
			<div class="container">
				<form class="big-search-form"  method="post" action="listall.php">
					<select name="pokaz" id="pokazSelect" type="text">
                        <option value="0">Wszystkie</option>
                        <option value="1">Dające się zrealizować</option>
					</select>
					<select name="sortowanie" id="sortSelect" type="text">
                        <option value="0">Nazwa A-Z</option>
                        <option value="1">Nazwa Z-A</option>
                        <option value="2">Czas rosnąco</option>
                        <option value="3">Czas malejąco</option>
					</select>
					<input type="text" placeholder="Search Receipies">
					<button class="bsf-btn" name="sortuj" type="submit">Search</button>
				</form>
			</div>
		</div>
	</div>
	<!-- Search section end -->


	<!-- Recipes section -->
	<section class="recipes-page spad">
		<div class="container">
			<div class="row" id="przepisy">
				<!-- tutaj laduja przepisy -->
			</div>
			<div class="site-pagination">
				<span>01</span>
				<a href="#">02</a>
				<a href="#">03</a>
			</div>
		</div>
	</section>
	<!-- Recipes section end -->

    <?php 
        include '../layout/footer.php'; 
        include '../layout/scripts.php'
    ?>
    <script>
	function wszystkiePrzepisyCall() {
		var call = []
		call[0] = "wszystkie_przepisy.php"
		call[1] = "wykonywalne_przepisy.php"
		var i = $("#pokazSelect").val()
		$.post(call[i],
		{
			sortowanie: $("#sortSelect").val()
		},
		function(data, status){
			$("#przepisy").html(data);
		});
	}
	$(document).ready(function()
	{
		wszystkiePrzepisyCall();
		$(":root").on("change","#sortSelect",wszystkiePrzepisyCall);
		$(":root").on("change","#pokazSelect",wszystkiePrzepisyCall);
	});
	</script>
</body>

                
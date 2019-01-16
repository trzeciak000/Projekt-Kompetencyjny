<?php 
    session_start();
    include '../config.php';
    include '../Flash.php';
?>

<!DOCTYPE html>
<html>
<?php include '../layout/head.php' ?>
<body>
    <?php include '../layout/navbar.php' ?>

    <?php Flash::display(); ?>

	<!-- Hero section -->
	<section class="page-top-section setbg" style="background-image: url(<?php echo ROOT_URL.'img/page-top-bg.jpg' ?>);">
		<div class="container">
			<h2>Przepis</h2>
		</div>
	</section>
	<!-- Hero section end -->

	<!-- Search section -->
	<div class="search-form-section">
		<div class="sf-warp">
			<div class="container">
				<form class="big-search-form"  method="post" action="listall.php">
					<select name="pokaz" id="pokazSelect" type="text">
                        <option value="0">Wszystkie</option>
                        <option value="1">Z lodówki</option>
					</select>
					<select name="sortowanie" id="sortSelect" type="text">
                        <option value="0">Nazwa A-Z</option>
                        <option value="1">Nazwa Z-A</option>
                        <option value="2">Czas rosnąco</option>
                        <option value="3">Czas malejąco</option>
					</select>
					<input name="nazwa" type="text" placeholder="Wyszukaj przepis">
					<button class="bsf-btn" name="sortuj" type="submit">Szukaj</button>
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
	function przepisyCall() {
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
		przepisyCall();
		$(":root").on("change","#sortSelect",przepisyCall);
		$(":root").on("change","#pokazSelect",przepisyCall);
	});
	</script>
</body>

                
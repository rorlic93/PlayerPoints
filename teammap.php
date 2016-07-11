<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<?php
		include 'predlozak/head.php';
		?>
		<?php 
		include 'predlozak/skripte.php';
		?>
	</head>
	<body>

		<!-- Zaglavlje -->
		<?php
		include_once 'predlozak/zaglavlje.php';
		?>

		<!--Izbornik-->
		<?php
		include_once 'predlozak/izbornik.php';
		?>
		<div class="row">
			<div class="large-12 columns">
				<div class="callout tijelo">
					
					<div>
						<h1 class="map_title">Teams on map</h1>
					</div>
					
					<div class="win_wrapper"> 
					<!-- Mapa -->
					<?php
					include 'predlozak/mapa.php';
					?>
					</div>
					
				</div>
			</div>
		</div>
		

		

	</body>
</html>

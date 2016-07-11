<?php session_start();?>

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
			<div class="large-5 columns">
				<div class="callout tijelo">
					<form method="POST" action="php/get.php" style="position: static;">
						<select name="players">
							<option name="Curry">Stephen Curry</option>
							<option name="Durant">Keivn Durant</option>
							<option name="James">Lebron James</option>
						  </select>
						<input type="text" name="Opp" value="W"/>
						<input type="text" name="Column1" value="W"/>
						<input type="text" name="MP" value="30:00:00"/>
						<input type="text" name="FGA" value="25"/>
						<input type="text" name="FG%" value="0.6"/>
						<input type="text" name="FT%" value="0.7"/>
						<input type="text" name="TRB" value="6"/>
						<input type="text" name="AST" value="5"/>
						<input type="text" name="TOV" value="4"/>
						<button type="submit">Calculate</button>
					</form>
				</div>
			</div>
			<div class="large-7 columns">
				<div class="callout tijelo">
					<canvas id="myChart" height="200"></canvas>
				</div>
			</div>
		</div>
		

		

	</body>
</html>


<?php if (isset($_SESSION["AZURE_RESPONSE"])):?>
	<script>
		var azureResponse = <?php echo $_SESSION["AZURE_RESPONSE"];?>;

		var fields = ["FGA", "FG%", "FT%", "TRB", "AST", "TOV", "Scored Labels"];
		drawChart(azureResponse, fields);
	</script>
<?php endif;?>
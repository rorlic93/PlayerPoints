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
			<div class="large-4 columns">
				<div class="callout tijelo">
					<form method="POST" action="php/get.php" style="position: static;">
						<h6>Player: </h6>
						<select name="Players" method="POST">
							<option>...</option>
							<option value="Curry">Stephen Curry</option>
							<option value="Durant">Keivn Durant</option>
							<option value="James">Lebron James</option>
						</select>
						<h6>Opponent - East or West(E or W): </h6>
						<input type="text" name="Opp" value="W"/>
						<h6>Win or lose situation (W or L)</h6>
						<input type="text" name="Column1" value="W"/>
						<h6>Minutes (mm:ss:ms): </h6>
						<input type="text" name="MP" value="30:00:00"/>
						<h6>Number of field goal attempts</h6>
						<input type="text" name="FGA" value="25"/>
						<h6>Field goal percentage: </h6>
						<input type="text" name="FG%" value="0.6"/>
						<h6>Free throw percentage: </h6>
						<input type="text" name="FT%" value="0.7"/>
						<h6>Total rebounds (offensive+deffensive): </h6>
						<input type="text" name="TRB" value="6"/>
						<h6>Assists: </h6>
						<input type="text" name="AST" value="5"/>
						<h6>Turnovers: </h6>
						<input type="text" name="TOV" value="4"/>
						<button type="submit" class="button alert">Calculate</button>
					</form>
				</div>
			</div>
			<div class="large-8 columns">
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
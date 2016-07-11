<?php 

session_start();

if(isset($_POST['calculate'])){
	$_SESSION['opp'] = $_POST["Opp"];
	$_SESSION['column1'] = $_POST["Column1"];
	$_SESSION['mp'] = $_POST["MP"];
	$_SESSION['fga'] = $_POST["FGA"];
	$_SESSION['fg'] = $_POST['FG%'];
	$_SESSION['ft'] = $_POST['FT%'];
	$_SESSION['trb'] = $_POST['TRB'];
	$_SESSION['ast'] = $_POST['AST'];
	$_SESSION['tov'] = $_POST['TOV'];
}	
?>

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
						<p >Player: </p >
						<select name="Players" method="POST">
							<option disabled="disabled" selected="selected"><?php echo @$_SESSION['player'] . " (was selected)"; 
							<option value="Curry">Stephen Curry</option>
							<option value="Durant">Kevin Durant</option>
							<option value="James">Lebron James</option>
						</select>
						<p >Opponent - East or West(E or W): </p >
						<input type="text" name="Opp" value="<?php echo @$_SESSION['opp']; ?>";/>
						<p >Win or lose situation (W or L)</p >
						<input type="text" name="Column1" value="<?php echo @$_SESSION['column1']; ?>" />
						<p >Minutes (mm:ss:ms): </p >
						<input type="text" name="MP" value="<?php echo @$_SESSION['mp']; ?>" />
						<p >Number of field goal attempts</p >
						<input type="text" name="FGA" value="<?php echo @$_SESSION['fga']; ?>" />
						<p >Field goal percentage: </p >
						<input type="text" name="FG%" value="<?php echo @$_SESSION['fg']; ?>" />
						<p >Free throw percentage: </p >
						<input type="text" name="FT%" value="<?php echo @$_SESSION['ft']; ?>" />
						<p >Total rebounds (offensive+deffensive): </p >
						<input type="text" name="TRB" value="<?php echo @$_SESSION['trb']; ?>" />
						<p >Assists: </p >
						<input type="text" name="AST" value="<?php echo @$_SESSION['ast']; ?>" />
						<p >Turnovers: </p >
						<input type="text" name="TOV" value="<?php echo @$_SESSION['tov']; ?>" />
						<button type="submit" name="calculate" class="button alert">Calculate</button>
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
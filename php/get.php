<?php
session_start();

if(isset($_POST['calculate'])){
	$_SESSION['player'] = $_POST["Players"];
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

if($_POST["Players"] == "Durant"){
	$url = 'https://ussouthcentral.services.azureml.net/workspaces/2a93444a939245d7baf10b3963496fbe/services/73a1db611eb34aacb0b98d349a4bde60/execute?api-version=2.0&details=true';
	$api_key = 'o8AN+pNJ0ZZKIi74WxUBE9vZzufBCCl2RHViGhXgzP8hTMagso8+6RumjtF/MJjHfSCPhLHTxl5itDcl/0XFBQ=='; 	
}
else if($_POST["Players"] == "Curry"){
	$url = 'https://ussouthcentral.services.azureml.net/workspaces/2a93444a939245d7baf10b3963496fbe/services/30a22e00f6da48bf9d6304ffd13ff345/execute?api-version=2.0&details=true';
	$api_key = '3s2Gq8nEPefYiDo2e8Uq8/VD+ltNe+SNWeXqcUqi00QvmOOIp1aJ2h9z1OhTYRoPzpbRjrq/gzGWEZlsq870Vw=='; 	
}
else if($_POST["Players"] == "James"){
	$url = 'https://ussouthcentral.services.azureml.net/workspaces/2a93444a939245d7baf10b3963496fbe/services/d9605567e9ca43b4b4ac074223a7595d/execute?api-version=2.0&details=true';
	$api_key = '36ox+238r6C++sUArT+B+24KtQ8rJpCv75ncS8UDt51XLEWPfBQv6kiqQNEGtAdIeCdkrrzw6n5QfHP1O86t0g=='; 
}

	$opp = $_POST["Opp"];
	$column1 = $_POST["Column1"];
	$mp = $_POST["MP"];
	$fga = $_POST["FGA"];
	$fg = $_POST["FG%"];
	$ft = $_POST["FT%"];
	$trb = $_POST["TRB"];
	$ast = $_POST["AST"];
	$tov = $_POST["TOV"];

	$data = array(
		'Inputs' => array('input1' => array(
			'ColumnNames' => array(
				"Opp",
		        "Column1",
		        "MP",
		        "FGA",
		        "FG%",
		        "FT%",
		        "TRB",
		        "AST",
		        "TOV",
		        "PTS"
			), 
			'Values' => array(
		        array(
		          	$opp,
					$column1,
					$mp,
					$fga,
					$fg,
					$ft,
					$trb,
					$ast,
					$tov,
		          	"0"
		        ),
		        array(
		          	$opp,
					$column1,
					$mp,
					$fga,
					$fg,
					$ft,
					$trb,
					$ast,
					$tov,
		          	"0"
		        )
		    )
		        
		)),
		"GlobalParameters" => null
	);



$body = json_encode($data);
//var_dump($body);
$headers = array('Content-Type: application/json', 'Authorization:Bearer ' . $api_key, 'Content-Length: ' . strlen($body));

$curl = curl_init($url); 
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);

$_SESSION["AZURE_RESPONSE"] = $response;

header("Location: ../players.php");

var_dump(json_decode(curl_exec($curl)));
	
?>
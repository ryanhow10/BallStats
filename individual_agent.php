<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  	<link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  	<link href="css/landing-page.css" rel="stylesheet">
</head>


<body>
	<!--Button to navigate to home page-->
	<a href="index.php"><button class = "btn btn-outline-dark">Back to Home</button></a><br>
	<!--Button to navigate to agents page-->
	<a href="agents.php"><button class = "btn btn-outline-dark">Back to Agents</button></a><br>
	<img src= "default.png" alt="picture is supposed to go here" height="200">


	<?php
	//Opening connection with database
	error_reporting(E_ALL ^ E_NOTICE);
	include('my_connect.php');
	$mysqli = get_mysqli_conn();
	?>


	<?php
	//Query to list info on a user specified agent
	$sql = "SELECT agent_first_name, agent_last_name, first_name, last_name, team_city, team_name, player.team_id, player_id
	        FROM (agent NATURAL JOIN player) JOIN team USING(team_id)
	        WHERE agent_id = ?";
	$stmt = $mysqli->prepare($sql);
	$agent_id = $_GET['agent_id']; //Getting user input
	$stmt->bind_param('i', $agent_id); //Binding user input to query
	$stmt->bind_result($agent_first_name, $agent_last_name, $first_name, $last_name, $team_city, $team_name, $player_team_id, $player_id); //Binding results to varibales
	$stmt->execute();
	//Fetching results
	while ($stmt->fetch()) {
		//Ouputting results elegantly
		echo ('<h1>'.$agent_first_name. " ". $agent_last_name . '</h1>');
	    $fullTeamName = $team_city . ' ' . $team_name;
	    $playerFullName = $first_name . ' ' . $last_name;
	    echo('<table class = "table"><tr><th>First Name</th><th>Last Name</th><th>Player</th><th>Player Team</th></tr>');
	    echo('<tr><th>'. $agent_first_name .'</th><th>'. $agent_last_name .'</th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_player.php?player_id=' .$player_id . '"><button class = "btn btn-outline-dark">'. $playerFullName .'</button></a></th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $player_team_id . '"><button class = "btn btn-outline-dark">'. $fullTeamName .'</button></a></th></tr></table>');
	}

	$stmt->close(); //Closing prepared statements
	$mysqli->close(); //Closing connection with database
?>

</body>
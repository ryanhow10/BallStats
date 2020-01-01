<head>
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
  	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  	<link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="css/landing-page.css" rel="stylesheet">
	<title>Teams</title>
</head>

<body>
	<!--Button to navigate back to home page-->
	<a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a>
	<h1>Teams</h1>

	<!--If submitted, redirect to capspace.php-->
	<form action="capspace.php" method="post">
	    Please set the league's salary cap to see which teams are over/under
		<input type="number" min="0" name="caplimit" method="post">
		<button type="submit" value="submit" class="btn btn-outline-dark">submit</button>
	</form>

	<!--If submitted, redirect to individual_team.php-->
	<form action="individual_team.php" method="get">
	<?php
	//Opening connection with database
	error_reporting(E_ALL ^ E_NOTICE);
	include('my_connect.php');
	$mysqli = get_mysqli_conn();
	?>

	<?php
	//Query to get information on all teams
	$sql = "SELECT team_id, team_city, team_name, year_established 
	        FROM team";

	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($team_id, $team_city, $team_name, $year_established);

	echo('<table class = "table"><tr><th>Team Name</th><th>Year Established</th></tr>');
	while ($stmt->fetch())
	{
	    $teamFullName = $team_city . " " . $team_name;
	    echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="team_id" value="' . $team_id . '">' .$teamFullName .'</th><th>' . $year_established . '</th></tr>');
	}
	echo('<br>');
	echo('</table>');
	$stmt->close(); //Close prepared statement
	$mysqli->close(); //Closing database connection
	?>

	</form>
</body>
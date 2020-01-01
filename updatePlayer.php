<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>
<body>
    <!--Button to navigate back to the home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <!--Button to navigate back to the players page-->
    <a href="players.php"><button class="btn btn-outline-dark">Back to Players</button></a>

<center>
    <!--When submitted, redirect to new_player_success.php-->
    <form action = "update_player_success.php" method="post"> 
        <?php
            //Opening connection with the database
            error_reporting(E_ALL ^ E_NOTICE);
            include('my_connect.php');
            $mysqli = get_mysqli_conn();
            
            $playerId = $_GET['player_id'];
            $player = "SELECT first_name, last_name FROM player WHERE player_id = ?";
            $playerStmt = $mysqli->prepare($player);
            $playerStmt->bind_param('i', $playerId);
            $playerStmt->execute();
            $playerStmt->bind_result($first_name, $last_name);
            while($playerStmt->fetch()){
                echo('<input type="hidden" name="player_id" value="' . $playerId . '">');
            }
            echo('<h2>Updating for ' .$first_name . ' ' . $last_name .'</h2>');
            $playerStmt->close(); //Closing prepared statement
        ?>
        Update the required information below <br>
        <select placeholder = "Team Name" name="teamId" method = "post" required>
        <option value="0" disabled selected>Player's New Team</option>
        <?php
            //Query to get information on team
            $sql = "SELECT team_city, team_name, team_id FROM team ";
            $stmt = $mysqli->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($team_city, $team_name, $teamId); //Binding results to variables
            while ($stmt->fetch()){
                echo('<option value ='.$teamId.' >' . $team_city . " ". $team_name . '</option>');
            }
            $stmt->close(); //Closing prepared statement
            $mysqli->close(); //Closing database connection
        ?></select><br>
        <input type = "submit" class="btn btn-outline-dark" value= "submit">

    </form>
</center>
</body>



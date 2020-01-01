<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>
<body>
    <!--Button to navigate back to home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <!--Button to navigate back to stats page-->
    <a href="playerStats.php"><button class="btn btn-outline-dark">Back to Player Stats</button></a>
    
    <?php
    //Openign connection with database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <!--When submitted, redirect to individual_player.php-->
    <form action="individual_player.php" method="get">
    <?php
        //Query to get the tallest players
    	$tallestPlayers =
            "SELECT first_name, last_name, height, player_id
            FROM player
            ORDER BY height DESC
            LIMIT 5";
        $stmtTallestPlayers = $mysqli->prepare($tallestPlayers);
        $stmtTallestPlayers->execute();
        $stmtTallestPlayers->bind_result($tallestPlayersFirstName, $tallestPlayersLastName, $tallestPlayersHeight, $tallestPlayersId);

        echo('<h3>Top 5 Tallest Players</h3>');
        echo('<table class = "table"><tr><th>Name</th><th>Height (inches)</td></tr>');
        while ($stmtTallestPlayers->fetch())
        {
            $tallestPlayersFullName = $tallestPlayersFirstName . ' ' . $tallestPlayersLastName;
            echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$tallestPlayersId.'">'.$tallestPlayersFullName.'</button></th><th>'. $tallestPlayersHeight .'</th></tr>');
            
        }
        echo('<br>');
        echo('</table>');

        //Query to get the highest jumpers
        $standingVertical =
            "SELECT first_name, last_name, standing_vertical, player_id
            FROM player
            ORDER BY standing_vertical DESC
            LIMIT 5";
        $stmtStandingVertical = $mysqli->prepare($standingVertical);
        $stmtStandingVertical->execute();
        $stmtStandingVertical->bind_result($standingVerticalFirstName, $standingVerticalLastName, $standingVerticalHeight, $standingVerticalPlayerId);

        echo('<h3>Top 5 Highest Jumpers</h3>');
        echo('<table class = "table"><tr><th>Name</th><th>Leap (inches)</td></tr>');
        while ($stmtStandingVertical->fetch())
        {
            $standingVerticalFullName = $standingVerticalFirstName . ' ' . $standingVerticalLastName;
            echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$standingVerticalPlayerId.'">'.$standingVerticalFullName.'</button></th><th>'. $standingVerticalHeight .'</th></tr>');
            
        }
        echo('<br>');
        echo('</table>');

        //Query to get the most agile players
        $laneAgility =
            "SELECT first_name, last_name, lane_agility, player_id
            FROM player
            ORDER BY lane_agility ASC
            LIMIT 5";
        $stmtLaneAgility = $mysqli->prepare($laneAgility);
        $stmtLaneAgility->execute();
        $stmtLaneAgility->bind_result($laneAgilityFirstName, $laneAgilityLastName, $laneAgilityTime, $laneAgilityPlayerId);

        echo('<h3>Top 5 Agile Players</h3>');
        echo('<table  class = "table"><tr><th>Name</th><th>Lane Agility Time (seconds)</td></tr>');
        while ($stmtLaneAgility->fetch())
        {
            $laneAgilityFullName = $laneAgilityFirstName . ' ' . $laneAgilityLastName;
            $laneAgilityTime = round($laneAgilityTime, 2);
            echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$laneAgilityPlayerId.'">'.$laneAgilityFullName.'</button></th><th>'. $laneAgilityTime .'</th></tr>');
            
        }
        echo('<br>');
        echo('</table>');

        //Query to get the fastest players
        $sprint =
            "SELECT first_name, last_name, sprint, player_id
            FROM player
            ORDER BY sprint ASC
            LIMIT 5";
        $stmtSprint = $mysqli->prepare($sprint);
        $stmtSprint->execute();
        $stmtSprint->bind_result($sprintFirstName, $sprintLastName, $sprintTime, $sprintPlayerId);

        echo('<h3>Top 5 Fastest Players</h3>');
        echo('<table class = "table"><tr><th>Name</th><th>Sprint Time (seconds)</td></tr>');
        while ($stmtSprint->fetch())
        {
            $sprintFullName = $sprintFirstName . ' ' . $sprintLastName;
            $sprintTime = round($sprintTime, 2);
            echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$sprintPlayerId.'">'.$sprintFullName.'</button></th><th>'. $sprintTime .'</th></tr>');
            
        }
        echo('<br>');
        echo('</table>');

        $stmtTallestPlayers->close(); //Closing prepared statements
        $stmtStandingVertical->close(); //Closing prepared statements
        $stmtLaneAgility->close(); //Closing prepared statements
        $stmtSprint->close(); //Closing prepared statements
        $mysqli->close(); //Closing connection with database

    ?>
</form>
</body>

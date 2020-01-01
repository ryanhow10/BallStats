<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <a href="players.php"><button class="btn btn-outline-dark">Back to Players</button></a><br><br>

    <?php
    //Opening database connection
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <?php
    //Query to get data on a user specified player
    $sql = "SELECT player.image_path, team_id, agent_id, player_id, first_name, last_name, jersey_number, age, salary, position, draft_year, draft_pick, hometown_city, hometown_state, standing_reach, height, wingspan, standing_vertical, vertical_leap, lane_agility, sprint, college, team_city, team_name, agent_first_name, agent_last_name
            FROM (player JOIN team USING(team_id)) NATURAL JOIN agent
            WHERE player_id = ?";

    $stmt = $mysqli->prepare($sql);
    $player_id = $_GET['player_id']; //Getting user input
    $stmt->bind_param('i', $player_id); //Binding user input to query
    $stmt->bind_result($image_path,$team_id,$agent_id, $player_id, $first_name, $last_name, $jersey_number, $age, $salary, $position, $draft_year, $draft_pick, $hometown_city, $hometown_state, $standing_reach, $height, $wingspan, $standing_vertical, $vertical_leap, $lane_agility, $sprint, $college, $team_city, $team_name, $agent_first_name, $agent_last_name); //Binding results to variables
    $stmt->execute();

    //Fetching results
    while ($stmt->fetch()) {
        $teamFullName = $team_city . ' ' . $team_name;
        $agentFullName = $agent_first_name . ' ' . $agent_last_name;
        //in our database, to signify that a player is came out of highschool, we leave it as an empty value, here we switch it back
        if($college == ''){
            $college = 'Drafted out of High School';
        }
        //in our database, to signify that a player is undrafted, we use the number 0, here we switch it back
        if($draft_pick == 0){
            $draft_pick = "Undrafted";
        }
        //in our database,position is stored as 1, 2 or 3 corresponding to Guard, Forward and Center,
        switch($position){
            case 1:
                $position = "G";
                break;
            case 2: 
                $position = "F";
                break;
            
            case 3: 
                $position = "C";
                break;
        }
        //displaying player image
        echo('<img src= "' .$image_path . '" alt="picture is supposed to go here" height="200"> ');
        echo ('<h1>'. $first_name . " " . $last_name .'<h1>');

        //diplaying player stats in table
        echo('<table class = "table"><tr><th>Agent</th><th>Team</th><th>Jersey Number</th><th>Age</th><th>Salary</th><th>Position</th><th>Draft Year</th><th>Draft Pick</th><th>Hometown City</th><th>Hometown State</th><th>Standing Reach (inches)</th><th>Height (inches)</th><th>Wingspan (inches)</th><th>Standing Vertical (inches)</th><th>Vertical Leap (inches)</th><th>Lane Agility (seconds)</th><th>Sprint (seconds)</th><th>College</th></tr>');
        echo('<tr><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_agent.php?agent_id=' . $agent_id .'"><button class="btn btn-outline-dark">'. $agentFullName .'</button class="btn btn-outline-dark"></a></th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $team_id .'"><button class="btn btn-outline-dark">'. $teamFullName .'</button></a></th><th>'. $jersey_number .'</th><th>'. $age .'</th><th>'. '$'. $salary .'</th><th>'. $position .'</th><th>'. $draft_year .'</th><th>'. $draft_pick .'</th><th>' . $hometown_city .'</th><th>'. $hometown_state .'</th><th>'. $standing_reach .'</th><th>'. $height .'</th><th>' .$wingspan . '</th><th>' . $standing_vertical . '</th><th>' . $vertical_leap . '</th><th>'. $lane_agility . '</th><th>' . $sprint . '</th><th>' . $college . '</tr></table>');
    }

    $stmt->close(); //Closing prepared statement
    $mysqli->close(); //Closing database connection
    ?>

    <form action="updatePlayer.php" method="get">
    <?php
        echo('<center>');
        echo('<h2><button type="submit" name=player_id class="btn btn-outline-dark" value="' .$player_id.'">Player Traded?</button></h2>');
        echo('</center>');
    ?>

</body>
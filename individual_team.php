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
     <!--Button to navigate back to teams-->
    <a href="teams.php"><button class="btn btn-outline-dark">Back to Teams</button></a><br><br>
    <?php
    //Opening connection with database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <!--If submitted, redirect to individual_player.php-->
    <form action="individual_player.php" method="get">
    <?php
    //Query to retunr information on a user specified team
    $sql = "SELECT team_city, team_name, first_name, last_name, position, team.image_path, player_id
            FROM player INNER JOIN team ON(player.team_id = team.team_id)
            WHERE player.team_id = ?";
    $stmt = $mysqli->prepare($sql);
    $team_id = $_GET['team_id']; //Getting user input
    $stmt->bind_param('i', $team_id); //Binding user input to query
    $stmt->bind_result($team_city, $team_name, $first_name, $last_name, $position, $image_path, $player_id); //Binding results to variables
    $stmt->execute();

    echo('<table class = "table"><tr><th>Player Name</th><th>Position</th></tr>');

    $counter = 0;
    //Fetching results
    while ($stmt->fetch()) {
        $playerFullName = $first_name . ' ' . $last_name;
        if($counter == 0){ //Display image and team name once
            echo('<img src= "' .$image_path . '" alt="picture is supposed to go here" height="200"><br>');
            echo('<h2>'. $team_city . ' ' . $team_name . '</h2>');

            $counter++;
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

        //diplaying player stats in table
        echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="'. $player_id .'">' . $playerFullName .'</button></th><th>' . $position . '</th></tr>');
    }
    echo('</br>');
    echo('</table>');

    $stmt->close(); //Closing prepared statement
    $mysqli->close(); //Closing database connection
    ?>
    </form>

    <form action="deletePlayer.php" action="get">
    <?php
        echo('<center>');
        echo('<h2><button type="submit" class="btn btn-outline-dark" name="team_id" value="' . $team_id .'">Remove Player</button></h2>');
    ?>
    </form>
</body>

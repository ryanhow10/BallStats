<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
    <title>Games</title>
</head>

<body>
    <!--Button to navigate back to home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a>
    <h1>Games</h1>
    <!--Button to add game-->
    <h2><a href="new_game.php"><button class="btn btn-outline-dark">The season isn't over yet, add new games here!</button></a></h2>

    <?php
    //Opening database connection
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <?php
    //Query to display info on games
    $sql = "SELECT away_id, t1.team_city, t1.team_name, home_id, t2.team_city, t2.team_name, away_score, home_score, game_date 
            FROM (plays JOIN team as t1 ON(plays.away_id = t1.team_id)) JOIN team as t2 ON(plays.home_id = t2.team_id)";

    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($away_id, $away_team_city, $away_team_name, $home_id, $home_team_city, $home_team_name, $away_score, $home_score, $game_date); //Binding results to variables

    //Displaying results in table form
    echo('<table class = "table"><tr><th>Away Team</th><th>Away Score</th><th>Home Team</th><th>Home Score</th><th>Winner</th><th>Loser</th><th>Date</th></tr>');
    //Fetching results
    while ($stmt->fetch())
    {
        $awayTeamFullName = $away_team_city . ' ' . $away_team_name;
        $homeTeamFullName = $home_team_city . ' ' . $home_team_name;
        if($home_score > $away_score){ //Determining who is the winner off of socre
            $winner = $homeTeamFullName;
            $loser = $awayTeamFullName;
            $winner_id = $home_id;
            $loser_id = $away_id;
        }
        else{
            $winner = $awayTeamFullName;
            $loser = $homeTeamFullName;
            $winner_id = $away_id;
            $loser_id = $home_id;
        }
        echo('<tr><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $away_id . '"><button class="btn btn-outline-dark">' . $awayTeamFullName .'</button></a></th><th>' . $away_score .'</th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $home_id . '"><button class="btn btn-outline-dark">' . $homeTeamFullName .'</button></a></th><th>' . $home_score .'</th><th>' . $winner .'</th><th>' . $loser .'</th><th>' . $game_date .'</th></tr>'); //Displaying results in links and buttons
    }
    echo('<br>');
    echo('</table>');
    $stmt->close(); //closing prepared statament
    ?>
    <!--When submitted, redirect to individual_team.php-->
    <form action="individual_team.php" method="get">
    <?php
    //Query to get teams who have no played a home game
    $home = "SELECT team_id, team_city, team_name 
            FROM team 
            WHERE NOT EXISTS(SELECT home_id 
                            FROM plays 
                            WHERE team_id = home_id)";

    $stmtHome = $mysqli->prepare($home);
    $stmtHome->execute();
    $stmtHome->bind_result($homeTeamId, $homeTeamCity, $homeTeamName); //Binding results to variables

    echo('<h2>Teams that Have Not Played a Home Game</h2>');
    //Displaying results in table form
    echo('<table class = "table"><tr><th>Team Name</th></tr>');
    //Fetching results
    while ($stmtHome->fetch())
    {
        $homeFullTeamName = $homeTeamCity . ' ' . $homeTeamName;
        echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="team_id" value="' . $homeTeamId .'">' . $homeFullTeamName .'</button></tr>'); //Displaying results in links and buttons
    }
    echo('<br>');
    echo('</table>');

    //Query to get temas who have played no away games
    $away = "SELECT team_id, team_city, team_name 
            FROM team 
            WHERE NOT EXISTS(SELECT away_id 
                            FROM plays 
                            WHERE team_id = away_id)";

    $stmtAway = $mysqli->prepare($away);
    $stmtAway->execute();
    $stmtAway->bind_result($awayTeamId, $awayTeamCity, $awayTeamName); //Binding results to variables

    echo('<h2>Teams that Have Not Played an Away Game</h2>');
    //Displaying results in table form
    echo('<table class = "table"><tr><th>Team Name</th></tr>');
    //Fetching results
    while ($stmtAway->fetch())
    {
        $awayFullTeamName = $awayTeamCity . ' ' . $awayTeamName;
        echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="team_id" value="' . $awayTeamId .'">' . $awayFullTeamName .'</button></tr>'); //Displaying results in links and buttons
    }
    echo('<br>');
    echo('</table>');

    $stmtHome->close(); //Closing prepared statements
    $stmtAway->close(); //Closing prepared statements
    $mysqli->close(); //Closing database connection
    ?>
    </form>
</body>
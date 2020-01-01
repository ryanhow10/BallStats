<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
    <title>Players</title>
</head>
<?php
    //Opening connection with database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
?>
<body>
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a>
    <h2><a href = "new_player.php"><button class="btn btn-outline-dark">Don't see your favourite player? Add player here!</button></a></h2>

<div class = "row">
    <div class = "col">   
            <h2>All Players</h2>   
            <!--When submitted, redirect to individual_players.php-->
            <form action="individual_player.php" method="get">
                <?php
                    //Querying all players
                    $allPlayers = "SELECT player_id, first_name, last_name s
                                    FROM player ";

                    $stmtAllPlayers = $mysqli->prepare($allPlayers);
                    $stmtAllPlayers->execute();
                    $stmtAllPlayers->bind_result($allPlayersPlayerId, $allPlayersFirstName, $allPlayersLastName);

                    echo('<table><tr><th></th></tr>');
                    while ($stmtAllPlayers->fetch())
                    {
                        $allPlayersFullName = $allPlayersFirstName . ' ' . $allPlayersLastName;
                        echo('<tr><th><button type="submit" class="btn btn-outline-dark" name="player_id" value=' . $allPlayersPlayerId .'>' . $allPlayersFullName .'</button></th></tr>');
                    }
                    echo('</table>');
                    $stmtAllPlayers->close(); //Closing prepared statements
                ?>
            </form>
    </div>
    <div class = "col">
        <h2>Notable Players</h1>
        <!--When submitted, redirect to individual_player.php-->
        <form action="individual_player.php" method="get">
            <?php
                //Querying the notable players
                $sql = "SELECT player_id, first_name, last_name 
                        FROM player 
                        WHERE player_id > 50 AND player_id < 59";

                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($player_id, $first_name, $last_name);

                echo('<table><tr data-toggle="collapse" data-target="#accordion" class="clickable"><th></th></tr>');
                while ($stmt->fetch())
                {
                    $fullPlayerName = $first_name . " " . $last_name ;
                    //Outputting the names of the notable players
                    echo('<tr><th><button type="submit" class="btn btn-outline-dark" name="player_id" value=' . $player_id .'>' . $fullPlayerName .'</button></th></tr>');
                }
                echo ('</table>');
                $stmt->close(); //Closing prepared statement
                $mysqli->close(); //Closing connection with database
            ?>
            <br>
            
        </form>
        <h2><a href="playerStats.php"><button class="btn btn-outline-dark">Stats we really enjoyed!</button></a></h2>
    </div>
    
    
    
</div>
</body>
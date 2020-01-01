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
    <a href="teams.php"><button class="btn btn-outline-dark">Back to Teams</button></a>

<center>
    <!--When submitted, redirect to new_player_success.php-->
    <form action = "delete_player_success.php" method="post"> 
        <?php
            //Opening connection with the database
            error_reporting(E_ALL ^ E_NOTICE);
            include('my_connect.php');
            $mysqli = get_mysqli_conn();
            echo('<center><h3>Choose a player to remove</h3></center>');
        ?>
        <select placeholder = "Player Name" name="player_id" method = "post" required>
        <option value="0" disabled selected>Player Name</option>
        <?php
            //Query to get information on player
            $sql = "SELECT first_name, last_name, player_id FROM player WHERE team_id = ?";
            $stmt = $mysqli->prepare($sql);
            $teamId = $_GET['team_id'];
            var_dump($teamId);
            $stmt->bind_param('i', $teamId);
            $stmt->execute();
            $stmt->bind_result($first_name, $last_name, $player_id); //Binding results to variables
            while ($stmt->fetch()){
                echo('<option value ='.$player_id.' >' . $first_name . " ". $last_name . '</option>');
            }
            $stmt->close(); //Closing prepared statement
            $mysqli->close(); //Closing database connection
        ?></select><br><br>

        <input type = "submit" class="btn btn-outline-dark" value= "submit">

    </form>
</center>
</body>



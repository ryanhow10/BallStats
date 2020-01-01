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
    <!--Button to navigate back to games page-->
    <a href="games.php"><button class="btn btn-outline-dark">Back to Games</button></a><br>
<center>
<!--When submitted, redirect to new_game_success-->
<form action = "new_game_success.php" method="post"> 
    Please input the required information below <br>
    
    <?php
    //Opening new connection with database
        error_reporting(E_ALL ^ E_NOTICE);
        include('my_connect.php');
        $mysqli = get_mysqli_conn();
    ?>
    <select name="homeTeamId" method = "post">
    <option value="0" disabled selected>Home Team</option>
    <?php
        $sql = "SELECT team_city, team_name, team_id FROM team ";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($home_team_city, $home_team_name, $home_teamId); //Bind results to variables
        //Fetch results
        while ($stmt->fetch()){
            echo('<option value ='.$home_teamId.' >' . $home_team_city . " ". $home_team_name . '</option>');
        }
    ?></select><br>

    <select name="awayTeamId" method = "post">
    <option value="0" disabled selected>Away Team</option>
    <?php
        $sql1 = "SELECT team_city, team_name, team_id FROM team ";
        $stmt1 = $mysqli->prepare($sql1);
        $stmt1->execute();
        $stmt1->bind_result($away_team_city, $away_team_name, $away_teamId); //Bind results to variables
        //Fetch results
        while ($stmt1->fetch()){
            echo('<option value ='.$away_teamId.'>' . $away_team_city . " ". $away_team_name . '</option>');
        }
        $stmt->close(); //Closing prepared statement
        $stmt1->close(); //Closing prepared statement
        $mysqli->close(); //Closing database connection
    ?></select><br>

    <input type = "number" placeholder="Home Team Score" name = "homeTeamScore" method="post" min="0"><br>
    <input type = "number" placeholder = "Away Team Score" name = "awayTeamScore" method="post" min="0"><br>
    <input type = "date" name = "date" method = "post"><br>
    

    <button class="btn btn-outline-dark" type = "submit" value= "submit">Submit</button>

</form>
</center>
</body>



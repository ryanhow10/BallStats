<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>


<body>
    <!--Button to navigate back to homepage-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <!--Button to navigate back to coaches-->
    <a href="coaches.php"><button class="btn btn-outline-dark">Back to Coaches</button></a><br>
    <img src= "default.png" alt="picture is supposed to go here" height="200">

    <?php
    //Opening connection with database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <!--When submitted, redirect to individual_team.php-->
    <form action = "individual_team.php" method="get">
    <?php
    //Query to get data on a user specified coach
    $headCoach = 
                "SELECT coach_id, years_as_head
                FROM head_coach
                WHERE coach_id = ?";
    $stmtHeadCoach = $mysqli->prepare($headCoach);
    $coach_id = $_GET['coach_id']; //Getting user input
    $stmtHeadCoach->bind_param('i', $coach_id); //Binding user input
    $stmtHeadCoach->bind_result($headCoachId, $years_as_head); //Binding results to variables
    $stmtHeadCoach->execute();
    $isHeadCoach = 0;

    while ($stmtHeadCoach->fetch()) { 
        if($headCoachId > 0){ //If there is a tuple, then head coach
            $isHeadCoach = 1;
        }
    }
 
    //Query to find how many players a coach earns more than on his team
    $earnMore = "SELECT COUNT(player_id)
                FROM coach INNER JOIN player ON(coach.team_id = player.team_id)
                WHERE coach.salary > player.salary AND coach_id = ?";
    $stmtEarnMore = $mysqli->prepare($earnMore);
    $coach_id = $_GET['coach_id']; //Getting coach id
    $stmtEarnMore->bind_param('i', $coach_id); //Binding coach id to the query
    $stmtEarnMore->bind_result($moreThanX); //Binding result to a variable
    $stmtEarnMore->execute();
    while ($stmtEarnMore->fetch()) {
    }

    //Query to get info on a specific coach
    $sql = "SELECT team_name, team_city, coach_first_name, coach_last_name, years_on_team, salary, team_id
            FROM coach NATURAL JOIN team 
            WHERE coach_id = ?";
    $stmt = $mysqli->prepare($sql);
    $coach_id = $_GET['coach_id']; //Getting coach id
    $stmt->bind_param('i', $coach_id); //Binding coach id to query
    $stmt->bind_result($team_name, $team_city, $coach_first_name, $coach_last_name, $years_on_team, $salary, $team_id); //Binding results to variables
    $stmt->execute();

    //Fetching results
    while ($stmt->fetch()) {
        if($isHeadCoach != 1){ //If not a head coach
            $years_as_head = "Not a head coach";
        }
        $fullTeamName = $team_city . ' ' . $team_name;
        $coachFullName = $coach_first_name . " " . $coach_last_name;
        echo ('<h1>'.$coachFullName.'</h1>');
        //Displaying results elegantly
        echo('<table class = "table"><tr><th>Team</th><th>First Name</th><th>Last Name</th><th>Years on Team</th><th>Salary</th><th>Years as Head Coach</th><th>Number of Team\'s Players that Coach Earns More Than</th></tr>');
        echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="team_id" value="' . $team_id . '">' . $fullTeamName .'</button></th><th>'. $coach_first_name .'</th><th>'. $coach_last_name .'</th><th>'. $years_on_team .'</th><th>'. '$' . $salary .'</th><th>' . $years_as_head .'</th><th>' . $moreThanX .'</th></tr></table>');
    }

    $stmtHeadCoach->close(); //Closing prepared statement
    $stmtEarnMore->close(); //Closing prepared statement
    $stmt->close(); //Closing prepared statement
    $mysqli->close(); //Closing connection with database
    ?>
</form>
</body>
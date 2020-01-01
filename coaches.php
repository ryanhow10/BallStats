<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
    <title>Coaches</title>
</head>

<body>   
    <!--Button to navigate back to the home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a>
    <h1>Coaches</h1>

    <?php
    //Opening connection with the database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <form action="individual_coach.php" method="get">
    <?php
    //Query to select coach and team information
    $sql = "SELECT coach_id, coach_first_name, coach_last_name, team_city, team_name, team_id 
            FROM coach NATURAL JOIN team";

    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($coach_id, $coach_first_name, $coach_last_name, $team_city, $team_name, $team_id); //Binding results to variables

    //Displaying results in table form
    echo('<table class = "table"><tr><th>Team</th><th>Name</th></tr>');
    //Fetching results
    while ($stmt->fetch())
    {
        $coachFullName = $coach_first_name . ' ' . $coach_last_name; //Concatenating first and last name 
        $teamFullName = $team_city . ' ' . $team_name; //Concatenating team city and name to form full team name
        echo('<tr><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $team_id . '">' . $teamFullName . '</a></th><th><button class="btn btn-outline-dark"  type="submit" name="coach_id" value="'. $coach_id .'">' . $coachFullName . '</button></th></tr>'); //Dipsplaying results in links and buttons
    }
    echo('<br>');
    echo('</table>');

    //Query to find the coaches who have been head coach for as long as they've been on the team
    $onlyHead = "SELECT coach_id, coach_first_name, coach_last_name, team_city, team_name, years_on_team, team_id
                FROM coach NATURAL JOIN head_coach NATURAL JOIN team
                WHERE years_on_team = years_as_head
                ORDER BY years_on_team DESC";

    $stmtOnlyHead = $mysqli->prepare($onlyHead);
    $stmtOnlyHead->execute();
    $stmtOnlyHead->bind_result($onlyHeadCoachId, $onlyHeadFirstName, $onlyHeadLastName, $onlyHeadTeamCity, $onlyHeadTeamName, $onlyHeadYearsOnTeam, $onlyHeadTeamId); //Binding results to variables

    echo('<h2>Coaches who have only been Head Coach on their Current Team</h2>');
    //Displaying results in table form
    echo('<table class = "table"><tr><th>Coach</th><th>Team</th><th>Years as Head Coach/On Team</th></tr>');
    //Fetching results
    while ($stmtOnlyHead->fetch())
    {
        $onlyHeadFullName = $onlyHeadFirstName . ' ' . $onlyHeadLastName; //Concatenating first name and last name 
        $onlyHeadTeamName = $onlyHeadTeamCity . ' ' . $onlyHeadTeamName; //Concatenating team city and name
        echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="coach_id" value="'. $onlyHeadCoachId .'">' . $onlyHeadFullName . '</button></th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $onlyHeadTeamId . '">' . $onlyHeadTeamName . '</a></th><th>' .$onlyHeadYearsOnTeam .'</th></tr>'); //Displaying results as links and buttons
    }
    echo('<br>');
    echo('</table>');
    //Closing prepared statements
    $stmt->close();
    $stmtOnlyHead->close();
    $mysqli->close(); //Closing database
    ?>
    </form>
</body>


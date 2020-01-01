<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
    <?php
        //Opening connection with the database
        error_reporting(E_ALL ^ E_NOTICE);
        include('my_connect.php');
        $mysqli = get_mysqli_conn();
    ?>
    <!--Button to navigate back to the home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <!--Button to navigate back to the players page-->
    <a href="players.php"><button class="btn btn-outline-dark">Back to Players</button></a>
    <?php
        //Assigning variables to posted values
        $image = 'default.png';
        $teamId = $_POST['teamId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $agentFirstName = $_POST['agentFirstName'];
        $agentLastName = $_POST['agentLastName'];
        $jerseyNumber = $_POST['jerseyNumber'];
        $age = $_POST['age'];
        $salary = $_POST['salary'];
        $position = $_POST['position'];
        $draftYear = $_POST['draftYear'];
        $draftPick = $_POST['draftPick'];
        $hometownCity = $_POST['hometownCity'];
        $hometownCountry = $_POST['hometownCountry'];
        $standingReach = $_POST['standingReach'];
        $height = $_POST['height'];
        $wingspan = $_POST['wingspan'];
        $standingVertical = $_POST['standingVertical'];
        $verticalLeap = $_POST['verticalLeap'];
        $laneAgility = $_POST['laneAgility'];
        $sprint = $_POST['sprint'];
        $college = $_POST['college'];

    //Query to insert data into database
    $sqlAgent = "INSERT INTO agent(agent_id, agent_first_name, agent_last_name) VALUES (NULL, ?, ?)";
    $stmt = $mysqli->prepare($sqlAgent);
    $stmt->bind_param('ss', $agentFirstName, $agentLastName); //Binding values into query
    $stmt->execute();
    
    $getHighestAgent = "SELECT MAX(agent_id) FROM agent"; //Getting highest agent id
    $stmt1 = $mysqli->prepare($getHighestAgent);
    $stmt1->execute();
    $stmt1->bind_result($agent_id);
    while ($stmt1->fetch()){
    }
    
    //Query to insert values into player table
    $sqlForNewPlayer = "INSERT INTO player(image_path, team_id, player_id, first_name, last_name, jersey_number, age, salary, position, draft_year, draft_pick, 
    hometown_city, hometown_state, standing_reach, height, wingspan, standing_vertical, vertical_leap,
    lane_agility, sprint, college, agent_id) VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt2 = $mysqli->prepare($sqlForNewPlayer);
    //Binding variables to query
    $stmt2->bind_param('sissiiiiiisssiiiiiisi', $image, $teamId, $firstName, $lastName, $jerseyNumber, $age, $salary, $position, $draftYear, $draftPick, $hometownCity, $hometownCountry, $standingReach, $height, $wingspan, $standingVert, $verticalLeap, $laneAgility, $sprint, $college, $agent_id);
    $stmt2->execute();

    echo ('<center>');
    echo('<h3>' . $firstName . ' ' . $lastName . ' has been successfully added to the database!</h3>');
    echo ('</center>');

    $stmt->close(); //Closing prepared statement
    $stmt1->close(); //Closing prepared statement
    $mysqli->close(); //Closing connection with database
    
?>
</body>
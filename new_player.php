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
    <a href="players.php"><button class="btn btn-outline-dark">Back to Players</button></a>

<center>
    <!--When submitted, redirect to new_player_success.php-->
    <form action = "new_player_success.php" method="post"> 
        Please input the required information below <br>
                <br>
                <input type = "text" placeholder ="First Name" name = "firstName" method="post" required><br>
                <input type = "text" placeholder="Last Name" name = "lastName" method="post" required><br>
        
        <?php
            //Opening connection with the database
            error_reporting(E_ALL ^ E_NOTICE);
            include('my_connect.php');
            $mysqli = get_mysqli_conn();
        ?>
        <select placeholder = "Team Name" name="teamId" method = "post" required>
        <option value="0" disabled selected>Player's Team</option>
        <?php
            //Query to get information on team
            $sql = "SELECT team_city, team_name, team_id FROM team ";
            $stmt = $mysqli->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($team_city, $team_name, $teamId); //Binding results to variables
            while ($stmt->fetch()){
                echo('<option value ='.$teamId.' >' . $team_city . " ". $team_name . '</option>');
            }
        ?></select><br>

        <input type = "text" placeholder="Agent First Name" name = "agentFirstName" method="post" required><br>
        <input type = "text" placeholder = "Agent Last Name" name = "agentLastName" method="post" required><br>
        <input type = "number" min="0" placeholder = "Jersey Number" name = "jerseyNumber" method="post"><br>
        <input type = "number" min ="0" placeholder = "Age"name = "age" method="post"><br>
        <input type = "number" min="0" placeholder="Salary" name = "salary" method="post"><br>
        <select name = "position" method = "post">
            <option value="0" disabled selected>Player's Position</option>
            <option value = 1> Guard</option>
            <option value = 2> Forward </option>
            <option value = 3> Center </option>  
        </select><br>
        
        <input type = "number" min = "1946"placeholder="Draft Year" name = "draftYear" method="post"><br>
       
        <input type = "number" placeholder ="Draft Pick" name = "draftPick" method="post" min="1" max="60" ><br>
       
        <input type = "text" placeholder ="Hometown City" name = "hometownCity" method="post"><br>
        
        <input type = "text" placeholder ="Hometown City or Country "name = "hometownCountry" method="post"><br>
        
        <input type = "number" placeholder="Standing Reach" name = "standingReach" method="post"><br>
        <input type = "number" placeholder = "Height" name = "height" method="post"><br>
        <input type = "number" placeholder = "Wingspan"name = "wingspan"  method="post"><br>
        <input type = "number" placeholder = "Standing Vertical" name = "standingVertical" method="post"><br>
        <input type = "number" min = "0" placeholder = "Vertical Leap" name = "verticalLeap" method="post"><br>
        <input type = "number" min = "0" step = "0.01" placeholder="Lane Agility" name = "laneAgility" method="post"><br>
        <input type = "number" min = "0" step = "0.01" placeholder="Sprint" name = "sprint"  method="post"><br>
        
        <input type = "college" placeholder ="College" name = "college"  method="post"><br>


        <input type = "submit" class="btn btn-outline-dark" value= "submit">

    </form>
</center>
</body>



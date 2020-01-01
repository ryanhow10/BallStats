<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>


<body>
    <!--Button to navigative back to home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <!--Button to navigative back to medical staff page-->
    <a href="medical_staff.php"><button class="btn btn-outline-dark">Back to All Medical Staff</button></a><br>
    <img src= "default.png" alt="picture is supposed to go here" height="200">
    

    <?php
    //Opening connection with database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <!--When submitted, redirect to individual_team.php-->
    <form action="individual_team.php" action="get">
    <?php
    //Query to get info on a user specified medical staff
    $headDoctor = 
                "SELECT medical_staff_id, years_as_head
                FROM head_doctor
                WHERE medical_staff_id = ?";
    $stmtHeadDoctor = $mysqli->prepare($headDoctor);
    $medical_staff_id = $_GET['medical_staff_id']; //Getting user input
    $stmtHeadDoctor->bind_param('i', $medical_staff_id); //Binding user input to query
    $stmtHeadDoctor->bind_result($headDoctorId, $years_as_head); //Binding results to variables
    $stmtHeadDoctor->execute();
    $isHeadDoctor = 0;

    while ($stmtHeadDoctor->fetch()) {
        if($headDoctorId > 0){ //If tuples, medical staff is a head doctor
            $isHeadDoctor = 1;
        }
    }

    //Query to get info on medical_staff and their team
    $sql = "SELECT medical_staff_first_name, medical_staff_last_name, years_on_team, team_city, team_name, team_id
            FROM medical_staff NATURAL JOIN team 
            WHERE medical_staff_id = ?";
    $stmt = $mysqli->prepare($sql);
    $medical_staff_id = $_GET['medical_staff_id']; //Getting user input
    $stmt->bind_param('i', $medical_staff_id); //Binding user input to query
    $stmt->bind_result($medical_staff_first_name, $medical_staff_last_name, $years_on_team, $team_city, $team_name, $team_id); //Binding results to variables
    $stmt->execute();

    //Fetching results
    while ($stmt->fetch()) {
        echo ('<h1>'.$medical_staff_first_name. " ". $medical_staff_last_name . '</h1>');
        if($isHeadDoctor != 1){ //Checking if head doctor
            $years_as_head = "Not a head doctor";
        }
        $fullTeamName = $team_city . ' ' . $team_name;
        //Displaying results elegantly
        echo('<table class ="table"><tr><th>First Name</th><th>Last Name</th><th>Years on Team</th><th>Years as Head Doctor</th><th>Team</th></tr>');
        echo('<tr><th>'. $medical_staff_first_name .'</th><th>'. $medical_staff_last_name .'</th><th>'. $years_on_team .'</th><th>' . $years_as_head . '</th><th><button class="btn btn-outline-dark" type="submit" name="team_id" value="' . $team_id . '">' . $fullTeamName .'</button></th></tr></table>');
    }

    $stmtHeadDoctor->close(); //Closing prepared statement
    $stmt->close(); //Closing prepared statement
    $mysqli->close(); //Closing database connection
    ?>
    </form>

</body>
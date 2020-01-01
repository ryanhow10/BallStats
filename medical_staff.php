<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
    <title>Medical Staff</title>
</head>

<body>
    <!--Button to navigate back to home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br><br>
    
<!--If submitted, redirect to individual_medical_staff.php-->
<form action="individual_medical_staff.php" method="get">
<div class="row">
    <div class = "col">
        <h2>All Medical Staff</h2>
        <?php
        //Opening connection with database
            error_reporting(E_ALL ^ E_NOTICE);
            include('my_connect.php');
            $mysqli = get_mysqli_conn();
        
            //Query to get medical_staff infro
            $sql = "SELECT medical_staff_id, medical_staff_first_name, medical_staff_last_name
                    FROM medical_staff";

            $stmt = $mysqli->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($medical_staff_id, $medical_staff_first_name, $medical_staff_last_name); //Binding results to variables

            echo('<table class = "table"><tr><th>Staff Name</th></tr>');
            //Fetching results
            while ($stmt->fetch())
            {
                $medicalStaffFullName = $medical_staff_first_name . " " . $medical_staff_last_name;
                echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="medical_staff_id" value="' . $medical_staff_id . '">' .$medicalStaffFullName .'</th></tr>');
            }
            echo('<br>');
            echo('</table>');
            $stmt->close(); //Closing prepared statement
        ?>
    </div>
    <div class = "col">
        <?php
            //Query to medical staff who have only been head doctors for as long as they ahve been on the team
            $onlyHeadDoctor = "SELECT medical_staff_id, medical_staff_first_name, medical_staff_last_name, team_city, team_name, years_on_team, team_id
                FROM medical_staff NATURAL JOIN head_doctor NATURAL JOIN team
                WHERE years_on_team = years_as_head
                ORDER BY years_on_team DESC";

            $stmtOnlyHeadDoctor = $mysqli->prepare($onlyHeadDoctor);
            $stmtOnlyHeadDoctor->execute();
            $stmtOnlyHeadDoctor->bind_result($onlyHeadDoctorId, $onlyHeadDoctorFirstName, $onlyHeadDoctorLastName, $onlyHeadDoctorTeamCity, $onlyHeadDoctorTeamName, $onlyHeadDoctorYearsOnTeam, $onlyHeadDoctorTeamId); //Bind results to variables

            echo('<h2>Staff that have only been Head</h2>');
            echo('<table class = "table"><tr><th>Doctor</th><th>Team</th><th>Years as Head Doctor/On Team</th></tr>');
            //Fetching results
            while ($stmtOnlyHeadDoctor->fetch())
            {
                $onlyHeadDoctorFullName = $onlyHeadDoctorFirstName . ' ' . $onlyHeadDoctorLastName;
                $onlyHeadDoctorTeamName = $onlyHeadDoctorTeamCity . ' ' . $onlyHeadDoctorTeamName;
                echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="medical_staff_id" value="'. $onlyHeadDoctorId .'">' . $onlyHeadDoctorFullName . '</button></th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_team.php?team_id=' . $onlyHeadDoctorTeamId . '">' . $onlyHeadDoctorTeamName . '</a></th><th>' .$onlyHeadDoctorYearsOnTeam .'</th></tr>');
            }
            echo('<br>');
            echo('</table>');

            $stmtOnlyHeadDoctor->close(); //Closing prepared statement
            $mysqli->close(); //Closing database connection
            ?>
    </div>
</div>
</form>
</body>
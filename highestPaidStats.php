<head>
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
    <!--Button to navigate to home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <!--Button to navigate to player stats page-->
    <a href="playerStats.php"><button class="btn btn-outline-dark">Back to Player Stats</button></a>
	<h1>Highest Paid Stats</h1>
    <?php
    //Opening connection with the database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
    ?>

    <!--When submitted, redirect to individual_player.php-->
    <form action="individual_player.php" method="get">
        <?php
        //Query to find highest paid player by position
        $highestPaidByPosition =
            "SELECT player_id, p1.position, first_name, last_name, p1.salary FROM (SELECT position, MAX(salary) as salary
            FROM player
            GROUP BY position) as p1, player p2
            WHERE p1.salary = p2.salary
            ORDER BY p1.position ASC";
        $stmtHighestPaidByPosition = $mysqli->prepare($highestPaidByPosition);
        $stmtHighestPaidByPosition->execute();
        $stmtHighestPaidByPosition->bind_result($highestPaidByPositionPlayerId, $highestPaidPosition, $highestPaidByPositionFirstName, $highestPaidByPositionLastName, $highestPaidByPositionSalary); //Binding results to variables

        echo('<h3>Highest Paid Player by Position</h3>');
        //Displaying results in table form
        echo('<table class="table"><tr><th scope ="col">Position</th><th scope="col">Name</td><th scope= "col">Salary</th></tr>');
        //Fetching results
        while ($stmtHighestPaidByPosition->fetch())
        {
            $fullNameByPosition = $highestPaidByPositionFirstName . ' ' .$highestPaidByPositionLastName;
            switch($highestPaidPosition){ //Converting number positions to G,F and C
                case 1:
                    $position = "G";
                    break;
                case 2: 
                    $position = "F";
                    break;
                
                case 3:  
                    $position = "C";
                    break;
            }
            echo('<tr><th scope = "row">' . $highestPaidPosition .'</th><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$highestPaidByPositionPlayerId.'">'.$fullNameByPosition.'</button></th><th>' . '$' . $highestPaidByPositionSalary. '</th></tr>'); //Displaying stats
            
        }
        echo('<br>');
        echo('</table>');

        //Query to find highest paid from hometown
        $highestPaidFromHometown =
            "SELECT player_id, first_name, last_name, p1.hometown_city, p1.salary
             FROM (SELECT hometown_city, MAX(salary) as salary
                  FROM player
                  GROUP BY hometown_city) as p1, player p2
            WHERE p1.salary = p2.salary
            ORDER BY p1.salary DESC";
        $stmtHighestPaidHometown = $mysqli->prepare($highestPaidFromHometown);
        $stmtHighestPaidHometown->execute();
        $stmtHighestPaidHometown->bind_result($playerIdHometown, $firstNameHometown, $lastNameHometown, $hometown_city, $homeTownSalary); //Binding results to variables

        echo('<h3>Highest Paid Players by Hometown</h3>');
        //Displaying results in table form
        echo('<table class="table"><tr><th scope ="col">Name</th><th>Hometown City</td><th scope ="col" >Salary</th></tr>');
        //Fetching results
        while ($stmtHighestPaidHometown->fetch())
        {
            $fullNameByHometown = $firstNameHometown . ' ' .$lastNameHometown;
            
            echo('<tr><th scope = "row"><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$playerIdHometown.'">'.$fullNameByHometown.'</button></th><th>' . $hometown_city . '</th><th>' . '$' . $homeTownSalary. '</th></tr>'); //Displaying results in button form

        }
        echo('<br>');
        echo('</table>');

        //Query to find highest paid by college
        $highestPaidByCollege =
            "SELECT player_id, first_name, last_name, p1.college, p1.salary
            FROM (SELECT college, MAX(salary) as salary
                  FROM player
                  GROUP BY college) as p1, player p2
            WHERE p1.salary = p2.salary
            ORDER BY p1.salary DESC";
        $stmtHighestPaidByCollege = $mysqli->prepare($highestPaidByCollege);
        $stmtHighestPaidByCollege->execute();
        $stmtHighestPaidByCollege->bind_result($playerIdCollege, $highestPaidByCollegeFirstName, $highestPaidByCollegeLastName, $highestPaidByCollegeCollege, $highestPaidByCollegeSalary); //Bindings results to variables

        echo('<h3>Highest Paid Players by College</h3>');
        //Displaying results in table form
        echo('<table class = "table"><tr><th>Name</th><th>College</td><th>Salary</th></tr>');
        //Fetching results
        while ($stmtHighestPaidByCollege->fetch())
        {
            $fullNameByCollege = $highestPaidByCollegeFirstName . ' ' . $highestPaidByCollegeLastName;
            if($highestPaidByCollegeCollege == ''){ //If blank, that means player did not go to college and was drafted out of highschool
                $highestPaidByCollegeCollege = 'Drafted out of High School';
            }
            $fullNameByCollege = $highestPaidByCollegeFirstName . ' ' .$highestPaidByCollegeLastName;
            echo('<tr><th><button class="btn btn-outline-dark" type="submit" name="player_id" value="' .$playerIdCollege.'">'.$fullNameByCollege.'</button></th><th>'. $highestPaidByCollegeCollege .'</th><th>' . '$' . $highestPaidByCollegeSalary . '</th></tr>'); //Displaying results with buttons
            
        }
        echo('<br>');
        echo('</table>');
        $stmtHighestPaidByPosition->close(); //Closing prepared statement
        $stmtHighestPaidHometown->close(); //Closing prepared statement
        $stmtHighestPaidByCollege->close(); //Closing prepared statement
        $mysqli->close(); //Closing the connection with database
        ?>
</body>
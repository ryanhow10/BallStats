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
    <!--Button to navigative back to teams page-->
    <a href="teams.php"><button class="btn btn-outline-dark">Back to Teams</button></a>
    <h1>Salary Cap<h1>

    <?php
        //Opening connection with database
        error_reporting(E_ALL ^ E_NOTICE);
        include('my_connect.php');
        $mysqli = get_mysqli_conn();

        //Query to determine which teams are over the salary cap limit
        $sql = "SELECT team_name, SUM(salary)
                FROM player JOIN team ON(player.team_id = team.team_id)
                GROUP BY team_name
                HAVING SUM(salary) > ?";
        $stmtCapSpace = $mysqli->prepare($sql);
        $capLimit = $_POST['caplimit']; //Retrieving posted value from user
        $stmtCapSpace->bind_param('i', $capLimit); //Binding user value into query
        $stmtCapSpace->bind_result($capSpaceTeamName, $total_salary); //Binding query results into variables
        $stmtCapSpace->execute();

        echo('<h2>Teams who are Over the Salary Cap</h2>');
        //Displaying results in table form
        echo('<table class ="table"><tr><th>Team Name</th><th>Over By</th></tr>');
        //Feteching results
        while ($stmtCapSpace->fetch())
        {
            $over = $total_salary - $capLimit; //Calculating difference in total salary and salary cap limit
            echo('<tr><th>' . $capSpaceTeamName . '</th><th>$' . $over .'</th></tr>'); //Displaying results
        }
        echo('<br></tr></table>');
        $stmtCapSpace->close(); //Closing prepared statement
    ?>

    <?php
        //Query to determine which teams are under the salary cap limit
        $sql2 = "SELECT team_name, SUM(salary)
                FROM player JOIN team ON(player.team_id = team.team_id)
                GROUP BY team_name
                HAVING SUM(salary) < ?";
        $stmtCapSpace2 = $mysqli->prepare($sql2);
        $stmtCapSpace2->bind_param('i', $capLimit); //Binding user value into query
        $stmtCapSpace2->bind_result($capSpaceTeamName2, $total_salary2); //Binding results to variables
        $stmtCapSpace2->execute();

        echo('<h2>Teams who are Under the Salary Cap</h2>');
        //Diplsaying results in table form
        echo('<table class = "table"><tr><th>Team Name</th><th>Under By</th></tr>');
        //Fetching results
        while ($stmtCapSpace2->fetch())
        {
            $under = $capLimit - $total_salary2; //Calculating difference in salary cap limit and total salary
            echo('<tr><th>' . $capSpaceTeamName2 . '</th><th>$' . $under .'</th></tr>'); //Displaying results
        }
        echo('<br></tr></table>');
        $stmtCapSpace2->close(); //Closing prepared statement
        $mysqli->close(); //Closing database connection
    ?>
</body>

<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
    <?php
        //Opening connection with database
        error_reporting(E_ALL ^ E_NOTICE);
        include('my_connect.php');
        $mysqli = get_mysqli_conn();
    ?>
    <?php
        $homeTeamId = $_POST['homeTeamId']; //Assigning variables to posted values
        $awayTeamId = $_POST['awayTeamId'];
        $homeTeamScore = $_POST['homeTeamScore'];
        $awayTeamScore = $_POST['awayTeamScore'];
        $date = $_POST['date'];
       
        //Query to insert values into database
        $sql = "INSERT INTO plays (away_id, home_id, away_score, home_score, game_date)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('iiiis', $homeTeamId, $awayTeamId, $homeTeamScore, $awayTeamScore, $date);
        $stmt->execute();

        echo('<a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>');
        echo('<a href="games.php"><button class="btn btn-outline-dark">Back to Games</button></a><br>');
        echo('<center>');
        echo('<h3>Game has been successfully added to the database!</h3>');
        echo('</center>');

        $stmt->close(); //Closing prepared statement
        $mysqli->close(); //Closing database connection
        
    ?>
</body>
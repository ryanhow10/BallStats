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
        $player_id = $_POST['player_id'];

    //Query to update data in database
    $sql = "DELETE FROM player WHERE player_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $player_id); //Binding values into query
    $stmt->execute();
    echo ('<center>');
    echo('<h3>Deletion success! Player has been deleted.</h3>');
    echo ('</center>');
    $stmt->close(); //Closing prepared statement
    $mysqli->close(); //Closing connection with database
    
?>
</body>
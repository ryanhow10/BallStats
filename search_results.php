<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
    <!--Button to navigate back to home page-->
    <a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
    <center>
    
    <?php
        //Opening a connection with the database
        error_reporting(E_ALL ^ E_NOTICE);
        include('my_connect.php');
        $mysqli = get_mysqli_conn();
    ?>
    <?php
        $searchedPlayer = $_POST['searchedPlayer']; //Assigning variable to posted value
        $name_arr = explode(' ', $searchedPlayer); //Delimitting by space
        $first_name_for_search = $name_arr[0];
        $last_name_for_search = $name_arr[1];

        if(count($name_arr) < 2){ //Only check first name
            $sql = "SELECT player_id, first_name, last_name 
                FROM player WHERE first_name LIKE '%$first_name_for_search%' OR last_name LIKE '%$first_name_for_search%'";
        }else{ //Check first and last name
            $sql = "SELECT player_id, first_name, last_name 
                FROM player WHERE first_name LIKE '%$first_name_for_search%' OR last_name LIKE '%$last_name_for_search%'";
        }

        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($player_id, $first_name, $last_name);

        echo('<h2>Search results for ' . '\'' . $searchedPlayer . '\'</h2>');
        while ($stmt->fetch())
        {   
            $full_name = $first_name . " " . $last_name;
            echo('<a href = "https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_player.php?player_id='.$player_id.'"><button class="btn btn-outline-dark">'.$full_name.'</button></a><br>');  
        }
        $stmt->close(); //Closing prepared statement
        $mysqli->close(); //Closing database connection
        
    ?>
    </center>
</body>
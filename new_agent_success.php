<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
<!--Button to navigate back to home-->
<a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
<?php
    //Opening connection with database
    error_reporting(E_ALL ^ E_NOTICE);
    include('my_connect.php');
    $mysqli = get_mysqli_conn();
?>
<?php
    $agentFirstName = $_POST['agentFirstName']; //Assigning variables to posted values
    $agentLastName = $_POST['agentLastName'];

    //Inserting values into database
    $sqlAgent = "INSERT INTO agent(agent_id, agent_first_name, agent_last_name) VALUES (NULL, ?, ?)";
    $stmt = $mysqli->prepare($sqlAgent);
    $stmt->bind_param('ss', $agentFirstName, $agentLastName); //Binding inputs to query
    $stmt->execute();

    echo('<center>');
    echo('<h2>'.$agentFirstName . ' ' . $agentLastName . ' has been successfully added to the database!</h2>');
    echo('</center>');

    $stmt->close(); //Closing prepared statement
    $mysqli->close(); //Closing database connection
?>
</body>
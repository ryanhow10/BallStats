<head>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="css/landing-page.css" rel="stylesheet">
  <title>Agents</title>
</head>

<body>
  <!--Button to return back to home page-->
  <a href="index.php"><button class = "btn btn-outline-dark">Back to Home</button></a><br> 
  <h1>Agents</h1>
  <!--Button to add new agent-->
  <h2><a href="new_agent.php"><button class = "btn btn-outline-dark">Don't see your favourite agent? Add agent here!</button></a></h1><br>

  <div class="row">
  <div class="col">
  <!--When submitted, page will redirect to individual_agent.php-->
  <form action="individual_agent.php" method="get">
  <!--Including sql connection to connect to database with configuration information-->
    <?php
      error_reporting(E_ALL ^ E_NOTICE);
      include('my_connect.php');
      $mysqli = get_mysqli_conn();
    ?>

    <?php
      //List all agents
      $sql = "SELECT agent_id, agent_first_name, agent_last_name
              FROM agent";

      $stmt = $mysqli->prepare($sql); 
      $stmt->execute();
      $stmt->bind_result($agent_id, $agent_first_name, $agent_last_name); //Assign variables to results
      echo ('<h2>All Agents</h2>');

      //Displaying results in table form
      echo('<table class = "table"><tr><th>Name</th></tr>');
      //Fetching results
      while ($stmt->fetch())
      {
        $agentFullName = $agent_first_name . ' ' . $agent_last_name; //Concatenating first and last name to form full name
        echo('<tr><th><button class = "btn btn-outline-dark" type="submit" name="agent_id" value="' . $agent_id .'">' . $agentFullName . '</th></tr>'); //Displaying agents as a button
      }
        echo('<br>');
        echo('</table>');
        $stmt->close(); //Closing prepared statement
      ?>
  </div>
  <div class="col">
    <?php
      //Query to list the top 10 most successful agents
      $successfulAgents = "SELECT agent_id, player_id, agent_first_name, agent_last_name, first_name, last_name, salary
                            FROM agent NATURAL JOIN player
                            ORDER BY salary DESC
                            LIMIT 10";
      $stmtSuccessfulAgents = $mysqli->prepare($successfulAgents);
      $stmtSuccessfulAgents->execute();
      $stmtSuccessfulAgents->bind_result($successful_agent_id, $player_id, $successful_first_name, $successful_last_name, $first_name, $last_name, $salary); //Binding query results into variables

      echo('<h2>Top 10 Most Successful Agents</h2>');
      //Displaying results in table format
      echo('<table class = "table"><tr><th>Agent Name</th><th>Manages</th><th>Player Salary</th></tr>'); 
      //Fetching results
      while ($stmtSuccessfulAgents->fetch())
        {
          $successfulFullName = $successful_first_name . ' ' . $successful_last_name; //Concatenating first and last name to form full name
          $playerFullName = $first_name . ' ' . $last_name; //Concatenating first and last name to form full name
          echo('<tr><th><button class = "btn btn-outline-dark" type="submit" name="agent_id" value="' . $successful_agent_id .'">' . $successfulFullName . '</th><th><a href="https://mansci-db.uwaterloo.ca/~rykhowte/new_website/individual_player.php?player_id=' .$player_id .'">' .$playerFullName .'</a></th><th>$' . $salary .'</th></tr>'); //Displaying results in button and links 
        }
      echo('<br>');
      echo('</table>');
      $successfulAgents->close(); //Closing prepared statement
      $mysqli->close(); //Closing database connection
    ?>

  </div>
  </div>
</form>
</body>

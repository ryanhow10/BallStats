<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/landing-page.css" rel="stylesheet">
</head>

<body>
<a href="index.php"><button class="btn btn-outline-dark">Back to Home</button></a><br>
<a href="agents.php"><button class="btn btn-outline-dark">Back to Agents</button></a><br>
<center>
  <!--Form for user to fill in to add another agent to database. When submitted, redirect to new_agent_success.php-->
	<form action = "new_agent_success.php" method="post"> 
    Please input the required information below <br>
   
    <input type = "text" placeholder ="First Name" name = "agentFirstName" method="post"><br>
    
    <input type = "text" placeholder = "Last Name"name = "agentLastName" method="post"><br><br>

    <button type = "submit" class="btn btn-outline-dark" value= "submit">Submit</button> 
	</form>
</center>

</body>

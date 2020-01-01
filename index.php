<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Ball Stats</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="css/landing-page.css" rel="stylesheet">

</head>

<body>

  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1>ball stats</h1>
          <h3 class="mb-5">the world's first elegant basketball statistics website</h1>
          <a href='players.php'><button class="btn btn-outline-light">players</button></a>
          <a href='teams.php'><button class="btn btn-outline-light">teams</button></a>
          <a href='coaches.php'><button class="btn btn-outline-light">coaches</button></a>
          <a href='agents.php'><button class="btn btn-outline-light">agents</button></a>
          <a href='medical_staff.php'><button class="btn btn-outline-light">medical staff</button></a>
          <a href='games.php'><button class="btn btn-outline-light">games</button></a>
          <br>
          <form action = "search_results.php" method="post"> 
           <br>
            <input type = "player" class="form-control form-control-lg" placeholder="Search for a player here..." name = "searchedPlayer" method="post"> <input class="btn btn-outline-light" type = "submit" value="submit">
          </form>
        </div>
      </div>
    </div>
  </header>

 
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

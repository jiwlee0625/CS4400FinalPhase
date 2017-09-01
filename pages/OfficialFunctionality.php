<?php

session_start(); // Starting Session


//================= Validate Data ============================
// define variables and set to empty values
//https://phase3-jjung75.c9users.io:8081/phpmyadmin

//Set variables
$servername = "127.0.0.1";
$username = "jjung75";
$password = "";
$dbname = "c9";
$port = 3306;

// Create connection
$con=mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (mysqli_connect_errno()) {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>


<!-- Made by Vicky -->
<!DOCTYPE html>
<html lang = "en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>City Official - Choose Functionality</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


<body>
    <div class = "container">
    <h1 style = "text-align: center"> Choose Functionality </h1> <br>
    <form method="post" class="form-horizontal" role="form" action="../php/OfficialFunctionality.php">
        <!-- I'm assuming the php related to this html is called "OfficialFunctionality.php" -->


        <div class="form-group">
            <a href="OfficialPOI.php"> Filter/Search POI </a>
            <!-- I'm assuming that it will be called "OfficialPOI.php" -->
        </div><br>

        <div class="form-group">
            <a href="OfficialReport.php"> POI Report </a>
            <!-- I'm assuming that it will be called "OfficialReport.php" -->
        </div><br>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <a href="login.php" class="btn btn-lg btn-success btn-block"> Log out </a>
            </div>
        </div>

    </form>
    </div>
</body>
</html>

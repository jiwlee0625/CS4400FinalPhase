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

/*
            $dropdownresult = mysqli_query($con, "SELECT City, State FROM CITYSTATE");
            while ($cityrow=mysql_fetch_array($dropdownresult)) {
            $cityTitle=$cityrow["City"];
                echo "<option>
                    $cityTitle
                </option>";
            
            }
*/

if ( isset($_POST['btn-signup']) ) {

    $location = trim($_POST['location']);
    $location = htmlspecialchars($location);
    
    $city = trim($_POST['city']);
    $city = htmlspecialchars($city);
    
    $state = trim($_POST['state']);
    $state = htmlspecialchars($state);
    
    $zipcode = trim($_POST['zipcode']);
    

    //location validation
    if (empty($location)) {
        $error = true;
        $locationError = "Please enter a location";
    } else {
        $location_filter = mysqli_query($con, "SELECT LocationName FROM POI WHERE LocationName = '$location'");
        if ($location_filter-> num_rows != 0) {
            $error = true;
            $locationError = "That location already exists"; 
        }
    } 
    
    //city/state/zipcode validation
    
    if (empty($city)) {
        $error = true;
        $cityError = "Please select a city";
    }
    
    if (empty($state)) {
        $error = true;
        $stateError = "Please select a state";
    }
    
    if (empty($zipcode)) {
        $error = true;
        $zipcodeError = "Please enter a zipcode";
    }
    
    $result = mysqli_query($con, "SELECT City FROM CITYSTATE WHERE State='$state' AND City = '$city'");
        if ($result->num_rows == 0) { //if city does not exist in selected state
            $error = true;
            $stateError = "City does not exist in selected state.";
        }
    
    //final
    if ( !$error) {
        $location = mysqli_real_escape_string($con, $location);
        $city = mysqli_real_escape_string($con, $city);
        $state = mysqli_real_escape_string($con, $state);
        $zipcode = mysqli_real_escape_string($con, $zipcode);
        
        $res = mysqli_query($con, "INSERT INTO `c9`.`POI` (`LocationName`, `City`, `State`, `Zipcode`, `Flag`, `DateFlagged`) VALUES ('$location', '$city', '$state', '$zipcode', FALSE, NULL)");
        
        if($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered.";
            unset($location);
            unset($city);
            unset($state);
            unset($zipcode);
        }
        else {
            $errTyp = "danger";
            $errMSG = "something went wrong";
        }
    }

    
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

    <title>City Scientist - Add a New POI Location</title>

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
    <div class="container">
    <h1 style = "text-align: center"> Add a New Location </h1> <br>
    <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"><b> POI Location Name: </b></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="location" placeholder = "Enter location of POI" Required><br><br>
                <div class="col-sm-10 col-sm-offset-2"> </div>
                   <?php echo "<span class='text-danger'>$locationError</span>";?>
            </div>
        </div>

        <div class="form-group">
            <label for="city" class="col-sm-2 control-label"><b> City: </b></label>
            <div class="col-sm-10">
                <select class="form-control" name="city" id="city"><br><br>
                    <?php
                    $dropdownresult = mysqli_query($con, "SELECT DISTINCT City FROM CITYSTATE");
                    while ($cityrow=mysqli_fetch_array($dropdownresult)) {
                    $cityTitle=$cityrow['City'];
                        echo "<option>
                            $cityTitle
                        </option>";
                    }
                    ?>
                </select>
                <div class="col-sm-10 col-sm-offset-2"> </div>
                   <?php echo "<span class='text-danger'>$cityError</span>";?>
            </div><br><br>
        </div>

        <div class="form-group">
            <label for="state" class="col-sm-2 control-label"><b> State: </b></label>
            <div class="col-sm-10">
                <select class="form-control" name="state" id="state"><br><br>
                    <?php
                    $dropdownresult = mysqli_query($con, "SELECT DISTINCT State FROM CITYSTATE");
                    while ($staterow=mysqli_fetch_array($dropdownresult)) {
                    $stateTitle=$staterow['State'];
                        echo "<option>
                            $stateTitle
                        </option>";
                    }
                    ?>
                </select>
                <div class="col-sm-10 col-sm-offset-2"> </div>
                   <?php echo "<span class='text-danger'>$stateError</span>";?>
            </div><br><br>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"><b> Zipcode: </b></label>
            <div class="col-sm-10">
                <input type="text" pattern="[0-9]{5}" class="form-control" name="zipcode" placeholder = "Enter 5 digit zipcode" Required><br><br>
                <div class="col-sm-10 col-sm-offset-2"> </div>
                   <?php echo "<span class='text-danger'>$zipcodeError</span>";?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <a href="ScientistFunctionality.php" class="btn btn-lg btn-success btn-block"> Back </a>
                <!-- I'm assuming that the scientist will be brought back to ScientistData.php page when it goes back.-->
            </div><br>
            <div class="col-sm-10 col-sm-offset-2">
                <a href="ScientistData.php" class="btn btn-lg btn-success btn-block"> Add a Data Point </a>
                <!-- I'm assuming that the scientist will be brought back to ScientistData.php page when it goes back.-->
            </div><br>
            <div class="col-sm-10 col-sm-offset-2">
                <input id="submit" id="btn-signup" name="btn-signup" type="submit" value="Submit" class="btn btn-lg btn-success btn-block"></a>
                <!-- I'm not sure where the scientist is headed to after it submits a new location. -->
            </div>
        </div>
        <?php if ( isset($errMSG) ) 
	    { 
	    ?>
        <div class="form-group">
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
            </div>
        </div>
        <?php
        }
        ?>
    </form>
    </div>
</body>
</html>

<? php ob_flush() ?>
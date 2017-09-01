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

if ( isset($_POST['btn-signup']) ) {
    
    $location = trim($_POST['location']);
    $location = htmlspecialchars($location);
    
    $datetime = trim($_POST['datetime']);
    $datetime = htmlspecialchars($datetime);
    
    $dataType = trim($_POST['dataType']);
    $dataType = htmlspecialchars($dataType);
    
    $dataValue = trim($_POST['dataValue']);
    
    //validation
    
    if (empty($datetime)) {
        $error = true;
        $datetimeError = "Please enter a value for date and time";
    }

    if (empty($dataValue)) {
        $error = true;
        $dataValueError = "Please enter a data value";
    }
    
    $duplicate_filter = mysqli_query($con, "SELECT Location, Date_Time, Data_Type, DataValue FROM 'c9'.'DATAPOINT' WHERE Location = '$location' and Date_Time = '$datetime' and Data_Type");
    if ($duplicate_filter-> num_rows != 0) {
            $error = true;
            $datetimeError = "That data already exists"; 
    }
    
    //final
    if ( !$error) {
        $location = mysqli_real_escape_string($con, $location);
        $datetime = mysqli_real_escape_string($con, $datetime);
        $dataType = mysqli_real_escape_string($con, $dataType);
        $dataValue = mysqli_real_escape_string($con, $dataValue);
        
        $res = mysqli_query($con, "INSERT INTO `c9`.`DATAPOINT` (`Location`, `Date_Time`, `Data_Type`, `DataValue`) VALUES ('$location', '$datetime', '$dataType', '$dataValue')");
        
        if($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered.";
            unset($location);
            unset($datetime);
            unset($dataType);
            unset($dataValue);
        }
        else {
            $errTyp = "danger";
            if ($duplicate_filter-> num_rows != 0) {
                $errMSG = "That data already exists"; 
            } else {
                $errMSG = "something went wrong";
            }
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

    <title> City Scientist - Add a New Data Point </title>
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
        <h1 style = "text-align: center"> Add a New Data Point </h1> <br>
        <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        


            <div class="form group">
                <label for="name" class="col-sm-2 control-label"> <b> POI Location Name: </b> </label>

                <div class= "col-sm-0">
                    <select class='form-control' id="location" name='location'>
                        <?php
                        $dropdownresult = mysqli_query($con, "SELECT LocationName FROM POI");
                        while ($locationrow=mysqli_fetch_array($dropdownresult)) {
                        $locationTitle=$locationrow['LocationName'];
                            echo "<option>
                                $locationTitle
                            </option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm-10 col-sm-offset-2"> </div> <br><br>
            </div>

            <div class="form group">
                <label><b> Time/Date of Data Reading:
                    <input type = "datetime-local" name = "datetime" id='datetime'> </b><label>
                    <div class="col-sm-10 col-sm-offset-2"> </div>
                        <?php echo "<span class='text-danger'>$datetimeError</span>";?>
            </div> <br><br>


            <div class="form group">
                <label for="Datatype" class="col-sm-2 control-label"> <b> Data Type: </b> </label>

                <div class= "col-sm-0">
                    <select id="dataType" name='dataType' class="form-control">
                        <?php
                        $dropdownresult = mysqli_query($con, "SELECT * FROM DATATYPE");
                        while ($typerow=mysqli_fetch_array($dropdownresult)) {
                        $typeTitle=$typerow['Data_Type'];
                            echo "<option>
                                $typeTitle
                            </option>";
                        }
                        ?>
                    </select>

                    <div class="col-sm-10 col-sm-offset-2"> </div> <br><br>
                </div>
            </div>


            <div class="form group">
                <label for="value" class="col-sm-2 control-label"><b>Data Value: </b></label>

                <div class="col-sm-10">
                    <input type="number" min="0" step="1" id='dataValue' name="dataValue" placeholder = "Enter the data value" Required><br><br>
                    <div class="col-sm-10 col-sm-offset-2"> </div>
                        <?php echo "<span class='text-danger'>$dataValueError</span>";?>
                </div><br>
            </div>

            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <a href="ScientistFunctionality.php" class="btn btn-lg btn-success btn-block"> Back </a>
                </div><br>
                <div class="col-sm-10 col-sm-offset-2">
                    <a href="ScientistLocation.php" class="btn btn-lg btn-success btn-block"> Add POI Location </a>
                    
                </div>
                <br>

                <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" id="btn-signup" name="btn-signup" type="submit" value="Submit" class="btn btn-lg btn-success btn-block">
                    
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
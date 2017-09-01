<?php

session_start(); // Starting Session
if (isset($_GET['var'])) {
    $locationFromPOISEARCH = $_GET['var'];
    $_SESSION["location"] = $locationFromPOISEARCH;
    printf("%s", $_GET["var"]);
}
//================= Validate Data ============================
// define variables and set to empty values
//https://phase3-jjung75.c9users.io/phpmyadmin

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

    <title> City Official - POI detail </title>

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

    <style>
        table, th, td {
            border: 1px solid black
        }
        th, td {
            padding: 15px;
        }
    </style>
</head>



<body>
    <div class = "container">
    <h1 style = "text-align: center"> POI Detail </h1> <br>
    <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <!-- I'm assuming the php related to this html is called "OfficialDetail.php" -->
        <div class="form group">
            <label for="Datatype" class="col-sm-2 control-label"> <b> Data Type: </b> </label>

            <div class= "col-sm-0">
                    <select id="datatype" name='datatype' class="form-control"><br><br>
                        <option> </option>
                        <?php
                        $dropdownresult = mysqli_query($con, "SELECT Data_Type FROM DATATYPE");
                        while ($datarow=mysqli_fetch_array($dropdownresult)) {
                        $dataTitle=$datarow['Data_Type'];
                            echo "<option>
                                $dataTitle
                            </option>";
                        }
                        ?>
                    </select>
                    <div class="col-sm-10 col-sm-offset-2"> </div>
                </div>
        </div>

        <div class="form group">
            <label><b>
                <p><b> <input id = "dataValueLowerBound" type="number" min="0" step="1" name="dataValue1" placeholder = "Enter the data value"> to <input type="number" id = "dataValueUpperBound" min="0" step="1" name="dataValue2" placeholder = "Enter the data value"> </b></p>
            </b></label>
        </div>

        <label><b> Time & Date </b><label>
            <div class="input-group col-sm-10">
                <input type="date" class="form-control" name="date1" placeholder="mm/dd/yyyy"/>
                <span class="input-group-addon">-</span>
                <input type="date" class="form-control" name="date2" placeholder="mm/dd/yyyy"/>
            </div>

        <div id="container">
            <button id="applyButton" name="applyButton" type="submit" value="Submit"> Apply Filter </button>
            <!-- NEED TO DO SOMETHING -->
            <button id="resetButton" name="resetButton" type="submit" value="Submit"> Reset Filter </button>
            <!-- NEED TO DO SOMETHING -->
        </div>

        <hr>
        
        <div class="form-group">
                <?php

                session_start(); // Starting Session
                
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
                if (isset($_POST['flagButton'])) {
                    $location = $_SESSION["location"];
                    $flagged = 0;
                    
                    $flaggedResult = mysqli_query($con, "SELECT LocationName FROM POI WHERE LocationName = '$location' AND Flag = 1");
                    if ($flaggedResult-> num_rows != 0) {
                        $flagged = 1;
                    }
                    $query = NULL;
                    if ($flagged == 0) { //flag
                        $date = date('Y-m-d H:i:s');
                        $query = "UPDATE POI SET Flag=1, DateFlagged='$date' WHERE LocationName = '$location'";
                    } else { //unflag
                        $query = "UPDATE POI SET Flag=0, DateFlagged=NULL WHERE LocationName = '$location'";
                    }
                    $res = mysqli_query($con, $query);
                    
                    if($res) {
                        $errTyp = "success";
                        if ($flagged == 0) {
                            $errMSG = "Successfully flagged.";
                        } else {
                            $errMSG = "Successfully unflagged.";
                        }
                    } else {
                        $errTyp = "danger";
                        if ($duplicate_filter-> num_rows != 0) {
                            $errMSG = "That data already exists"; 
                        } else {
                            $errMSG = "something went wrong";
                        }
                    }
                }
                if( isset($_POST['resetButton']) ) {
                    $dataType = trim($_POST['datatype']);
                    $dataType = strip_tags($dataType);
                    $dataType = htmlspecialchars($dataType);

                    $dataVal1 = trim($_POST['dataValue1']);
                    $dataVal1 = strip_tags($dataVal1);
                    $dataVal1 = htmlspecialchars($dataVal1);
                    
                    $dataVal2 = trim($_POST['dataValue2']);
                    $dataVal2 = strip_tags($dataVal2);
                    $dataVal2 = htmlspecialchars($dataVal2);
                    
                    $date1 = date($_POST['date1']);
                    $date2 = date($_POST['date2']);
                    
                    $dataType = mysqli_real_escape_string($con, $dataType);
                    $dataVal1 = mysqli_real_escape_string($con, $dataVal1);
                    $dataVal2 = mysqli_real_escape_string($con, $dataVal2);
                    $date1 = mysqli_real_escape_string($con, $date1);
                    $date2 = mysqli_real_escape_string($con, $date2);
                    
                    unset($dataType);
                    unset($dataVal1);
                    unset($dataVal2);
                    unset($date1);
                    unset($date2);

                }
                if( isset($_POST['applyButton']) ) {
                    $location = $_SESSION["location"];
                    printf("%s", $location);
                    $dataType = trim($_POST['datatype']);
                    $dataType = strip_tags($dataType);
                    $dataType = htmlspecialchars($dataType);

                    $dataVal1 = trim($_POST['dataValue1']);
                    $dataVal1 = strip_tags($dataVal1);
                    $dataVal1 = htmlspecialchars($dataVal1);
                    
                    $dataVal2 = trim($_POST['dataValue2']);
                    $dataVal2 = strip_tags($dataVal2);
                    $dataVal2 = htmlspecialchars($dataVal2);
                    
                    $date1 = date($_POST['date1']);
                    $date2 = date($_POST['date2']);
                    
                    //final
                    
                    if( !$error) {
                        $location = mysqli_real_escape_string($con, $location);
                        $dataType = mysqli_real_escape_string($con, $dataType);
                        $dataVal1 = mysqli_real_escape_string($con, $dataVal1);
                        $dataVal2 = mysqli_real_escape_string($con, $dataVal2);
                        if ($date1 != NULL and $date2 != NULL) {
                            $date1 = mysqli_real_escape_string($con, $date1);
                            $date2 = mysqli_real_escape_string($con, $date2);
                        }
                        
                        $EMPTYWHERE = 1;
                        $where = NULL;
                        
                        if(!empty($location)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE Location = '$location'";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and Location = '$location'";
                            }
                        }
                        if(!empty($dataType)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE Data_Type = '$dataType'";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and Data_Type = '$dataType'";
                            }
                        }
                        
                        if(!empty($dataVal1) or !empty($dataVal2)) {
                            if (!empty($dataVal1) and !empty($dataVal2)) {
                                if ($EMPTYWHERE == 1) {
                                    $where = "WHERE (DataValue BETWEEN '$dataVal1' and '$dataVal2')";
                                    $EMPTYWHERE = 0;
                                } else {
                                    $where .= " and (DataValue BETWEEN '$dataVal1' and '$dataVal2')";
                                }
                            } else if (!empty($dataVal1) and empty($dataVal2)) { //if lower bound is specified and not upper bound
                                if ($EMPTYWHERE == 1) {
                                    $where = "WHERE (DataValue >= '$dataVal1')";
                                    $EMPTYWHERE = 0;
                                } else {
                                    $where .= " and (DataValue >= '$dataVal1')";
                                }
                                
                            } else { //if upper bound is specified and not lower bound
                                if ($EMPTYWHERE == 1) {
                                    $where = "WHERE (DataValue <= '$dataVal2')";
                                    $EMPTYWHERE = 0;
                                } else {
                                    $where .= " and (DataValue <= '$dataVal2')";
                                }
                            }
                        }
                        
                        
                        if(!empty($date1) and !empty($date2)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE (Date_Time BETWEEN '$date1' and '$date2')";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and (Date_Time BETWEEN '$date1' and '$date2')";
                            }
                        }
                        
                        if($EMPTYWHERE == 1) {
                            $where = "WHERE Accepted = 1";
                        }
                        else {
                            $where .= "AND Accepted = 1";
                        }
                        
                        
                        $query = "SELECT * FROM DATAPOINT ";
                        $query .= $where;
                        $result = mysqli_query($con, $query);
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($con));
                            exit();
                        }

                        echo "<table id='mytable'>
                        <tr name='header'>
                        <th> Data Type </th>
                        <th> Data Value </th>
                        <th> Time and Date </th>
                        </tr>";
                        
                        while($row = mysqli_fetch_array($result))
                        {
                        echo "<tr>";
                        echo "<td>" . $row['Data_Type'] . "</td>";
                        echo "<td>" . $row['DataValue'] . "</td>";
                        echo "<td>" . $row['Date_Time'] . "</td>";
                        echo "</tr>";
                        }
                        echo "</table>";
                        
                    }
                }
                
                ?>
            </div>
        
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <a href="OfficialPOI.php" class="btn btn-lg btn-success btn-block"> Back </a>
            </div> <br><br>
            
            <div class="col-sm-10 col-sm-offset-2">
                <button id="flagButton" name="flagButton" type="submit" value="Submit"> Flag/Unflag </button>
                <!--<a href="OfficialDetail.php" class="btn btn-lg btn-success btn-block"> Flag/Unflag </a>-->
            </div> <br>
            <!-- I don't know what should when the flag button is pressed.-->
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

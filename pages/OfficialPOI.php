<?php

session_start(); // Starting Session


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

    <title> City Official - Filter/Search POI </title>

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
    <div class="container">
        <h1 style = "text-align: center"> View POIs </h1> <br>
        <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <!-- I'm assuming that the php file that's associated with this file is called "OfficialPOI.php" -->

            <div class="form group">
                <label for="name" class="col-sm-2 control-label"> <b> POI Location Name: </b> </label>
                <div class= "col-sm-0">
                    <select id="location" name="location" class="form-control"><br><br>
                        <option> </option>
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
                    <div class="col-sm-10 col-sm-offset-2"> </div>
                </div>
            </div>

            <div class="form-group">
                <label for="city" class="col-sm-2 control-label"><b> City: </b></label>
                <div class="col-sm-10">
                    <select class="form-control" name="city" id="city"><br><br>
                        <option> </option>
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
                </div>
            </div>

            <div class="form-group">
                <label for="state" class="col-sm-2 control-label"><b> State: </b></label>
                <div class="col-sm-10">
                    <select class="form-control" name="state" id="state"><br><br>
                        <option> </option>
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
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b> Zipcode: </b></label>
                <div class="col-sm-10">
                    <input type="text" pattern="[0-9]{5}" class="form-control" name="zipcode" placeholder = "Enter 5 digit zipcode"><br>
                    <div class="col-sm-10 col-sm-offset-2"> </div>
                </div>
            </div>


            <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b> Flagged? </b></label>
                <div class="col-sm-10">
                    <input type="checkbox" id = "flagged" name="flagged">
                    <div class="col-sm-10 col-sm-offset-2"> </div>
                </div>
            </div>
 
   
            <label><b> Date Flagged</b><label>
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
                if( isset($_POST['resetButton']) ) {
                    $location = trim($_POST['location']);
                    $location = strip_tags($location);
                    $location = htmlspecialchars($location);

                    $city = trim($_POST['city']);
                    $city = htmlspecialchars($city);
                    
                    $state = trim($_POST['state']);
                    $state = htmlspecialchars($state);
                    
                    $zipcode = trim($_POST['zipcode']);
                    
                    $flagged = trim($_POST['flagged']);
                    
                    $date1 = trim($_GET['date1']);
                    $date2 = trim($_GET['date2']);
                    
                    $location = mysqli_real_escape_string($con, $location);
                    $city = mysqli_real_escape_string($con, $city);
                    $state = mysqli_real_escape_string($con, $state);
                    $zipcode = mysqli_real_escape_string($con, $zipcode);
                    $flagged = mysqli_real_escape_string($con, $flagged);
                    $date1 = mysqli_real_escape_string($con, $date1);
                    $date2 = mysqli_real_escape_string($con, $date2);
                    unset($location);
                    unset($city);
                    unset($state);
                    unset($zipcode);
                    unset($flagged);
                    unset($date1);
                    unset($date2);
                }
                if( isset($_POST['applyButton']) ) {
                    
                    $location = trim($_POST['location']);
                    $location = strip_tags($location);
                    $location = htmlspecialchars($location);

                    $city = trim($_POST['city']);
                    $city = htmlspecialchars($city);
                    
                    $state = trim($_POST['state']);
                    $state = htmlspecialchars($state);
                    
                    $zipcode = trim($_POST['zipcode']);
                    
                    $date1 = date($_POST['date1']);
                    $date2 = date($_POST['date2']);
                    printf("%s", $date1);
                    
                    if (isset($_POST['flagged'])) {
                        $flagged = 1;
                    } else {
                        $flagged = 0;
                    }
                    
                    //final
                    
                    if( !$error) {
                        $location = mysqli_real_escape_string($con, $location);
                        $city = mysqli_real_escape_string($con, $city);
                        $state = mysqli_real_escape_string($con, $state);
                        $zipcode = mysqli_real_escape_string($con, $zipcode);
                        $flagged = mysqli_real_escape_string($con, $flagged);
                        if ($date1 != NULL and $date2 != NULL) {
                            $date1 = mysqli_real_escape_string($con, $date1);
                            $date2 = mysqli_real_escape_string($con, $date2);
                        }
                        
                        $EMPTYWHERE = 1;
                        $where = NULL;
                        if ($flagged == 1) { //if flagged is set
                            $where = "WHERE Flag = '$flagged'";
                            $EMPTYWHERE = 0;
                        }
                        if(!empty($location)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE LocationName = '$location'";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and LocationName = '$location'";
                            }
                        }
                        
                        if(!empty($city)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE City = '$city'";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and City = '$city'";
                            }
                        }
                        
                        if(!empty($state)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE State = '$state'";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and State = '$state'";
                            }
                        }
                        
                        if(!empty($zipcode)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE Zipcode = '$zipcode'";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and Zipcode = '$zipcode'";
                            }
                        }
                        
                        
                        if(!empty($date1) and !empty($date2)) {
                            if ($EMPTYWHERE == 1) {
                                $where = "WHERE (DateFlagged BETWEEN '$date1' and '$date2')";
                                $EMPTYWHERE = 0;
                            } else {
                                $where .= " and (DateFlagged BETWEEN '$date1' and '$date2')";
                            }
                        }
                        $query = "SELECT * FROM POI ";
                        $query .= $where;
                        //printf(%s" $where);
                        //"SELECT * FROM POI '$where'";
                        $result = mysqli_query($con, $query);
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($con));
                            exit();
                        }

                        echo "<table id='mytable'>
                        <tr name='header'>
                        <th> Location Name </th>
                        <th> City </th>
                        <th> State </th>
                        <th> Zipcode </th>
                        <th> Flagged? </th>
                        <th> Date Flagged </th>
                        <th></th>
                        </tr>";
                        
                        while($row = mysqli_fetch_array($result))
                        {
                        echo "<tr>";
                        echo "<td>" . $row['LocationName'] . "</td>";
                        echo "<td>" . $row['City'] . "</td>";
                        echo "<td>" . $row['State'] . "</td>";
                        echo "<td>" . $row['Zipcode'] . "</td>";
                        echo "<td>" . ($row['Flag'] ? 'yes' : 'no') . "</td>";
                        echo "<td>" . $row['DateFlagged'] . "</td>";
                        
                        echo "<td>"; //link to poi details
                        
                        /* echo '<form id = "details" method="get" action="OfficialDetail.php">';
                        echo '<input type="hidden" name="location" value="' . $row['LocationName'] . '">';
                        echo "</form>";
                        echo '<button type="submit" form="details" value="Submit">View Details</button>';*/
                        
                        echo "<a href='OfficialDetail.php?var=" . $row['LocationName'] . "'>";
                        echo '<button type="button">Details</button>';
                        echo '</a>';
                        echo "</td>";
                        
                        echo "</tr>";
                        }
                        echo "</table>";
                        
                    }
                }
                
                ?>
            </div>


            <div class="col-sm-10 col-sm-offset-2">
                <a href="OfficialFunctionality.php" class="btn btn-lg btn-success btn-block"> Back </a>
            </div> <br>
        </form>
    </div>
</body>
</html>

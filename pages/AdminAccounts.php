<?php

//================= Validate Data ============================
// define variables and set to empty values
//https://ph3jiwon-jjung75.c9users.io/phpmyadmin

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
//select all data from DATAPOINT
$query = "SELECT * FROM CITYOFFICIAL NATURAL JOIN USER WHERE Approved IS NULL";

//NO Sorting
/*
if ($_GET['sort'] == 'maxuser') {
        $query .= " ORDER BY `Username`";
}
if ($_GET['sort'] == 'minuser') {
        $query .= " ORDER BY `Username` DESC";
}
if ($_GET['sort'] == 'maxtitle') {
        $query .= " ORDER BY `Title`";
}
if ($_GET['sort'] == 'mintitle') {
        $query .= " ORDER BY `Title` DESC";
}
if ($_GET['sort'] == 'maxcity') {
        $query .= " ORDER BY `City`";
}
if ($_GET['sort'] == 'mincity') {
        $query .= " ORDER BY `City` DESC";
}
if ($_GET['sort'] == 'maxstate') {
        $query .= " ORDER BY `State`";
}
if ($_GET['sort'] == 'minstate') {
        $query .= " ORDER BY `State` DESC";
}
*/

$result = mysqli_query($con, $query);

$cquery = "SELECT * FROM CITYOFFICIAL WHERE Approved IS NULL";
$cresult = mysqli_query($con, $cquery);
$set_bool = FALSE;
$array = [];

//If reject button pushed
if ( isset($_POST['reject']) ) {
    printf("isset reject; ");
    while ($ch_row = $cresult->fetch_assoc()) {
        //if checkbox is selected
        $user = $ch_row['Username'];
        if ( isset($_POST[$user])) {
            $re_query = "UPDATE CITYOFFICIAL SET Approved= '0' WHERE Username ='$user'";
            array_push($array, $user);
            $set_bool = mysqli_query($con, $re_query);
            printf("%s", $set_bool);
        }
    }
    if ($set_bool === FALSE) {
        $errMSG = "No Checkbox is selected!";
    }
    if ($set_bool === TRUE) {
        $arrstr = implode(" , ", $array);
        $errMSG = "Rejected users: {$arrstr}" ;
    }
    header("Refresh:0");
}
//If accept button pushed
if ( isset($_POST['accept']) ) {
    while ($ch_row = $cresult->fetch_assoc()) {
        //if checkbox is selected
        $user = $ch_row['Username'];
        if ( isset($_POST[$user])) {
            $re_query = "UPDATE CITYOFFICIAL SET Approved= '1' WHERE Username ='$user'";
            array_push($array, $user);
            $set_bool = mysqli_query($con, $re_query);
        }
    }
    if ($set_bool === FALSE) {
        $errMSG = "No Checkbox is selected!";
    }
    if ($set_bool === TRUE) {
        $arrstr = implode(" , ", $array);
        $errMSG = "Accepted users: {$arrstr}" ;
    }
    header("Refresh:0");
}

if ( isset($_POST['refresh'])) {
    header("Refresh:0");
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

    <title> Admin - Pending City Official Accounts </title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
   
    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="http://code.jquery.com/jquery-latest.min.js">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    

<body>
    <div class="container">
    <h1 style="text-align:center;"> Pending Data Points </h1>
    <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <table style="width:100%" class="table table-striped table-bordered table-hover" id="dataTables">
                <thead>
                    <tr id="tr1">
                        <th> Select </th>
                        <!--
                        <th><a href='AdminData.php?sort=maxloc'>POI Location</a></br><a href ='AdminData.php?sort=minloc'>desc</a></th>
                        <th><a href='AdminData.php?sort=maxtype'>Data Type</a></br><a href ='AdminData.php?sort=mintype'>desc</a></th>
                        <th><a href='AdminData.php?sort=maxval'>Data Value</a></br><a href ='AdminData.php?sort=minval'>desc</a></th>
                        <th><a href='AdminData.php?sort=maxtime'>Time & Date of Data Reading</a></br><a href ='AdminData.php?sort=mintime'>desc</a></th>
                        -->
                        <th>Username</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        while ($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td> <input type=\"checkbox\" value=\"chkbox1\" id=\"chk1\" name=\"".$row['Username']."\"></td>";
                            echo "<td>".$row['Username']."</td>";
                            echo "<td>".$row['Email']."</td>";
                            echo "<td>".$row['City']."</td>";
                            echo "<td>".$row['State']."</td>";
                            echo "<td>".$row['Title']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
                

            </table> <br> <br>
        </div>
        
        <!--where the message shows up !-->
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
       
        <div id="container">
            <button id="button1"> <a href="AdminFunctionality.html"> Back </a></button>
            
            <input id="submit" name="reject" type="Submit" value="Reject" class="btn btn-primary">
            
            <input id="submit" name="accept" type="Submit" value="Accept" class="btn btn-primary">
            <!--
            
            <button id ="button"><a onClick="function1('0','reject');">Reject</a></button>
            
            <button id ="button"><a onClick="function1('1','accept');">Accept</a></button>
            -->
            <input id="button" name="refresh" type="submit" value="Refresh" class="btn btn-primary">

        </div>
    </form>
    </div>
    
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference 
    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true
        });
    });
    </script>
    <script>
    function function1(id, mode) 
    {
        $.ajax({
            url:'AdminData.php',
            data:{mode:mode,id:id},
            dataType:'json',
            type: "POST",
            success:function(data){
                alert(data.success);
            }
        });
    }
    </script>-->
    
</body>
</html>

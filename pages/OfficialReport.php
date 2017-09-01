<?php

/*session_start(); // Starting Session


//================= Validate Data ============================
// define variables and set to empty values
//https://phase3-jjung75.c9users.io:8081/phpmyadmin

//Set variables
$servername = "127.0.0.1";
$username = "jpadhiar3";
$password = "";
$dbname = "c9";
$port = 3306;

// Create connection
$con=mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (mysqli_connect_errno()) {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT LocationName, City, State, (SELECT MIN(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Mold') AS 'Mold Min', (SELECT AVG(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Mold') AS 'Mold Avg', (SELECT MAX(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Mold') AS 'Mold Max', (SELECT MIN(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Air Quality') AS 'AQ Min', (SELECT AVG(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Air Quality') AS 'AQ Avg', (SELECT MAX(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Air Quality') AS 'AQ Max', (SELECT COUNT(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName) AS '# of data points', Flag FROM POI");

echo "<table id='mytable'>
<tr name='header'>
<th> Location Name </th>
<th> City </th>
<th> State </th>
<th> Mold Min </th>
<th> Mold Avg </th>
<th> Mold Max </th>
<th> AQ Min </th>
<th> AQ Avg </th>
<th> AQ Max </th>
<th> Data Points </th>
<th> Flag </th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['LocationName'] . "</td>";
echo "<td>" . $row['City'] . "</td>";
echo "<td>" . $row['State'] . "</td>";
echo "<td>" . $row['Mold Min'] . "</td>";
echo "<td>" . $row['Mold Avg'] . "</td>";
echo "<td>" . $row['Mold Max'] . "</td>";
echo "<td>" . $row['AQ Min'] . "</td>";
echo "<td>" . $row['AQ Avg'] . "</td>";
echo "<td>" . $row['AQ Max'] . "</td>";
echo "<td>" . $row['# of data points'] . "</td>";
echo "<td>" . $row['Flag'] . "</td>";
echo "</tr>";
}
echo "</table>";
*/

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

    <title> City Official - POI Report </title>

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
    <h1 style="text-align:center;"> POI Report </h1>
    <form method="post" class="form-horizontal" role="form" action="../php/OfficialReport.php">

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
            
            
            $query = "SELECT LocationName, City, State, (SELECT MIN(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Mold') AS 'Mold Min', (SELECT AVG(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Mold') AS 'Mold Avg', (SELECT MAX(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Mold') AS 'Mold Max', (SELECT MIN(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Air Quality') AS 'AQ Min', (SELECT AVG(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Air Quality') AS 'AQ Avg', (SELECT MAX(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName AND Data_Type LIKE 'Air Quality') AS 'AQ Max', (SELECT COUNT(DataValue) FROM DATAPOINT WHERE DATAPOINT.Location = POI.LocationName) AS '# of data points', Flag FROM POI";
            
            if ($_GET['sort'] == 'moldmin') {
                $query .= " ORDER BY `Mold Min`";
            }
            
            if ($_GET['sort'] == 'moldavg') {
                $query .= " ORDER BY `Mold Avg`";
            }
            
            if ($_GET['sort'] == 'moldmax') {
                $query .= " ORDER BY `Mold Max`";
            }
            
            if ($_GET['sort'] == 'amin') {
                $query .= " ORDER BY `AQ Min`";
            }
            
            if ($_GET['sort'] == 'aavg') {
                $query .= " ORDER BY `AQ Avg`";
            }
            
            if ($_GET['sort'] == 'amax') {
                $query .= " ORDER BY `AQ Max`";
            }
            
            if ($_GET['sort'] == 'data') {
                $query .= " ORDER BY `# of Data Points`";
            }
            
            if ($_GET['sort'] == 'flag') {
                $query .= " ORDER BY `Flag`";
            }
            
            if ($_GET['sorting'] == 'moldmin') {
                $query .= " ORDER BY `Mold Min` DESC";
            }
            
            if ($_GET['sorting'] == 'moldavg') {
                $query .= " ORDER BY `Mold Avg` DESC";
            }
            
            if ($_GET['sorting'] == 'moldmax') {
                $query .= " ORDER BY `Mold Max` DESC";
            }
            
            if ($_GET['sorting'] == 'amin') {
                $query .= " ORDER BY `AQ Min` DESC";
            }
            
            if ($_GET['sorting'] == 'aavg') {
                $query .= " ORDER BY `AQ Avg` DESC";
            }
            
            if ($_GET['sorting'] == 'amax') {
                $query .= " ORDER BY `AQ Max` DESC";
            }
            
            if ($_GET['sorting'] == 'data') {
                $query .= " ORDER BY `# of Data Points` DESC";
            }
            
            if ($_GET['sorting'] == 'flag') {
                $query .= " ORDER BY `Flag` DESC";
            }
            
            $result = mysqli_query($con, $query);
            
            echo "<table id='mytable'>
            <tr name='header'>
            <th> Location Name </th>
            <th> City </th>
            <th> State </th>
            <th><a href='OfficialReport.php?sort=moldmin'> Mold Min </a> <a href='OfficialReport.php?sorting=moldmin'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=moldavg'> Mold Avg </a> <a href='OfficialReport.php?sorting=moldavg'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=moldmax'> Mold Max </a> <a href='OfficialReport.php?sorting=moldmax'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=amin'> AQ Min </a> <a href='OfficialReport.php?sorting=amin'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=aavg'> AQ Avg </a> <a href='OfficialReport.php?sorting=aavg'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=amax'> AQ Max </a> <a href='OfficialReport.php?sorting=amax'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=data'> Data Points </a> <a href='OfficialReport.php?sorting=data'> <h5>desc</h5> </a></th>
            <th><a href='OfficialReport.php?sort=flag'> Flagged? </a> <a href='OfficialReport.php?sorting=flag'> <h5>desc</h5> </a></th>
            </tr>";
            
            while($row = mysqli_fetch_array($result))
            {
            echo "<tr>";
            echo "<td>" . $row['LocationName'] . "</td>";
            echo "<td>" . $row['City'] . "</td>";
            echo "<td>" . $row['State'] . "</td>";
            echo "<td>" . $row['Mold Min'] . "</td>";
            echo "<td>" . $row['Mold Avg'] . "</td>";
            echo "<td>" . $row['Mold Max'] . "</td>";
            echo "<td>" . $row['AQ Min'] . "</td>";
            echo "<td>" . $row['AQ Avg'] . "</td>";
            echo "<td>" . $row['AQ Max'] . "</td>";
            echo "<td>" . $row['# of data points'] . "</td>";
            echo "<td>" . ($row['Flag'] ? 'yes' : 'no') . "</td>";
            echo "</tr>";
            }
            echo "</table>";
            
            
            ?>
            
        </div>

        <div class="form-group">
            <a href="OfficialFunctionality.php"> Back </a>
            <!-- I'm assuming that it will go back to OfficialFunctionality.php page-->
        </div><br>
        
        
    </form>
    </div>
    
    
</body>
</html>

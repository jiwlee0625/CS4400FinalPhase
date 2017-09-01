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
if ( isset($_POST['btn-signin']) ) {

    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    $check = mysqli_query($con, "SELECT Username, Password FROM USER WHERE Password = '$pass' AND Username = '$name'");
    
    if (mysqli_num_rows($check) == 0) {
        $error = true;
        $errMSG = "Username or password is not right";
    } else {
        session_start();
        $_SESSION['u-name'] = $name;
        
        //proper way to select variable from database and store into php
        $sql = "SELECT Usertype FROM USER WHERE Username = '$name'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        //row is now a set of rows by the select query
        $usertype = $row['Usertype'];
       
       if ($usertype == 'ADMIN') {
            printf("redirecting to ADMIN");
            header('Location: https://finalphase-jjung75.c9users.io/pages/AdminFunctionality.php');
            exit;
        }
        //throw error if city official account is not accepted yet 
        if ($usertype == 'CITYOFFICIAL') {
            $errquery = "SELECT Approved FROM CITYOFFICIAL WHERE Username = '$name'";
            $erresult = mysqli_query($con, $errquery);
            $ch_row = $erresult->fetch_assoc();
            
            if ($ch_row['Approved'] == 1) {
                header('Location: https://finalphase-jjung75.c9users.io/pages/OfficialFunctionality.php');
                exit;
            }
            else {
                $error = true;
                $errMSG = "That CITYOFFICAL account has not been accepted!";
            }
            
        }
        if ($usertype == 'CITYSCIENTIST') {
            header('Location: https://finalphase-jjung75.c9users.io/pages/ScientistFunctionality.php');
            exit;
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

    <title> Login </title>

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
        <h1 style = "text-align:center">Login</h1>
        <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <!-- I'm assuming that the php file connected with this html is called "Login.php" -->

        <div class="form-group">
            <label for="username" class="col-sm-2 control-label"><b>Username</b></label>
            <div class="col-sm-10">
                <input type = "text" class="form-control" name="name" placeholder= "Enter Username" Required>

                <div class="col-sm-10 col-sm-offset-2"> </div> <br> <br>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-sm-2 control-label"><b>Password</b></label>
            <div class="col-sm-10">
                <input type = "password" class="form-control" id="pass" name="pass" placeholder = "Enter Password" Required>
                <div class="col-sm-10 col-sm-offset-2"></div> <br> <br>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input id="submit" name="btn-signin" type="Submit" value="Login" class="btn btn-primary" action="../php/...">
                <!-- Need to put in the appropriate page that the user is taken to. -->
            </div> <br> <br>

            <div class="col-sm-10 col-sm-offset-2">
                <a href="register.php" class="btn btn-lg btn-success btn-block">Register</a>
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
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
    
    //clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    $confirmpassword = trim($_POST['confirm-pass']);
    $confirmpassword = strip_tags($confirmpassword);
    $confirmpassword = htmlspecialchars($confirmpassword);
    
    $usertype = trim($_POST['user-type']);
    $usertype = strip_tags($usertype);
    $usertype = htmlspecialchars($usertype);
    
    //declaration of variables (THIS IS NEEDED DO NOT DELETE)
    $title = NULL;
    $state = NULL;
    $city = NULL;
    
    
    //$usergroup = 1;
    //if ($_POST['user-type'] == 'CITYSCIENTIST') {
    //    $usergroup = 2;
    //} if ($_POST['user-type'] == 'CITYOFFICIAL') {
    //    $usergroup = 3;
    //}
    
    
    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter a username.";
    } else if (strlen($name) < 3) {
        $error = true;
        $nameError = "Username must have atleat 3 characters.";
    } else {
        $name_filter = mysqli_query($con, "SELECT Username FROM USER WHERE Username='$name'");
        if ($name_filter->num_rows !=0) {
            $nameError = "Username already exists!";
            $error = true;
        }
    }
    //email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email.";
    }
    //check if email exists or not
    else {
        $result = mysqli_query($con, "SELECT Email FROM USER WHERE Email='$email'");
        if ($result->num_rows !=0) {
            $error = true;
            $emailError = "That Email is already in use.";
        }
    }
    
    //password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter a password.";
    }
    else if (strlen($pass) < 4) {
        $error = true;
        $passError = "Password must have at least 4 characters.";
    }
    else if (strcmp($pass, $confirmpassword) !== 0){
        $error = true;
        $passError = "Password and confirm passoword doesn't match!";
    }
    
    //when cityofficial is chosen
    if ($usertype == 'CITYOFFICIAL') {
        $title = trim($_POST['title']);
        $title = strip_tags($title);
        $title = htmlspecialchars($title);
        //if title is empty
        if (empty($title)) {
            $error = true;
            $titleError = "Please enter your title.";
        }
        
        $state = trim($_POST['state']);
        $state = strip_tags($state);
        $state = htmlspecialchars($state);
        
        $city = trim($_POST['city']);
        $city = strip_tags($city);
        $city = htmlspecialchars($city);
        
        $result = mysqli_query($con, "SELECT City FROM CITYSTATE WHERE State='$state' AND City = '$city'");
        if ($result->num_rows == 0) { //if city does not exist in selected state
            $error = true;
            $cityStateError = "City does not exist in selected state.";
        }
    }
    
    
    //final
    $name2 = $name;
    if ( !$error) {
        $name = mysqli_real_escape_string($con, $name);
        $email = mysqli_real_escape_string($con, $email);
        $pass = mysqli_real_escape_string($con, $pass);
        //for now try it with ADMIN as default - will change
        
        $res = mysqli_query($con, "INSERT into USER (Email, Username, Password, Usertype) VALUES ('$email', '$name', '$pass', '$usertype')");
        
        if ($res) {
            if ($usertype == 'CITYOFFICIAL') {//if we are adding a city official
                $title = mysqli_real_escape_string($con, $title);
                $city = mysqli_real_escape_string($con, $city);
                $state = mysqli_real_escape_string($con, $state);
                
                $resCITYOFFICIAL = mysqli_query($con, "INSERT into CITYOFFICIAL (Username, Title, City, State) VALUES ('$name', '$title', '$city', '$state')");
                
                if ($resCITYOFFICIAL) {
                    $errTyp = "success";
                    $errMSG = "Successfully registered.";
                    unset($name);
                    unset($email);
                    unset($pass);
                    unset($confirmpassword);
                    unset($city);
                    unset($state);
                    unset($title);
                } else { //something went wrong with adding into cityofficial
                    $errTyp = "danger";
                    $errMSG = "something went wrong";
                    
                    //to make it consistent, we will delete the one we already added in the general user database.
                    $resDelete = mysqli_query($con, "DELETE FROM USER WHERE Username='$name2')");
                }
            } else {
                $errTyp = "success";
                $errMSG = "Successfully registered.";
                unset($name);
                unset($email);
                unset($pass);
                unset($confirmpassword);
            }
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

    <title>New User Registration</title>

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
    <h1 style = "text-align: center"> New User Registration </h1>
    <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label"><b>Username</b></label>
                <div class="col-sm-10">
                    <input type = "text" class="form-control" id="name" name="name" placeholder= "Enter Username" Required>
                    <div class="col-sm-10 col-sm-offset-2">
			           <?php echo "<span class='text-danger'>$nameError</span>";?>
                    </div>
                    <br> <br>
                    <!-- input type = text defines a one-line text input field. -->
                </div>
            </div>
            
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label"><b> Email Address </b></label>
                <div class="col-sm-10">
                    <input type = "email" class="form-control" name = "email" placeholder="Enter Email" Required>
                    <div class="col-sm-10 col-sm-offset-2">
			            <?php echo "<span class='text-danger'>$emailError</span>";?>
                    </div>
                    <br> <br>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label"><b>Password</b></label>
                <div class="col-sm-10">
                    <input type = "password" class="form-control" id = "pass" name = "pass" placeholder = "Enter Password" Required>
                    <div class="col-sm-10 col-sm-offset-2">
			            <?php echo "<span class='text-danger'>$passError</span>";?>
                    </div>
                    <br> <br>
                    <!-- input type = password defines a password field -->
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm-password" class="col-sm-2 control-label"><b>Confirm Password</b></label>
                <div class="col-sm-10">
                    <input type = "password" class="form-control" id ="confirm-pass" name = "confirm-pass" placeholder = "Confirm Password" Required> <br> <br>
                
                </div>
            </div>
            
            <div class="form-group">
            <label class="col-sm-3 control-label"><b> User Type </b></label>
            <!--<label for="user-type" class="col-sm-3 control-label">User Type</label>-->
                <div class="col-sm-10">
                    <div class="col-sm-9">
                        <select name="user-type" id="user-type" class="form-control">
                            <option value = "CITYSCIENTIST">City Scientist</option>
                            <option value = "CITYOFFICIAL">City Official</option>
                        </select>
                    </div>
                </div>
            </div>
                
            <hr>
            <span> Fill out this form if you choose city officials </span>

            <div class="jumbotron">
            <div class="form-group"> <br>
                <label class= "col-sm-3 control-label"><b> City: </b></label>
                    <div class="col-sm-9">
                        <div class="col-sm-10 col-sm-offset-2">
			                <?php echo "<span class='text-danger'>$cityStateError</span>";?>
			            </div>
                        <select name="city" id="city" class="form-control">
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
                    </div> <br>
                <label class= "col-sm-3 control-label"><b> State: </b></label>
                    <div class="col-sm-9">
                        <select name="state" id="state" class="form-control">
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
                    </div> <br>
                <label class= "col-sm-3 control-label"><b> Title: </b></label>
                    <div class="col-sm-9">
                        <input type="text" id="title" name = "title" placeholder="Mayor" class="form-control">
                        <div class="col-sm-10 col-sm-offset-2">
			                <?php echo "<span class='text-danger'>$titleError</span>";?>
			            </div>
                    </div> <br>
            </div>
            <div class="form-group">
		        <div class="col-sm-10 col-sm-offset-2">
			        <input id="submit" id="btn-signup" name="btn-signup" type="submit" value="Submit" class="btn btn-primary">
		        </div>
	        </div> <br>
	        
	        <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <a href="login.php" class="btn btn-lg btn-success btn-block">Back to Login</a>
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
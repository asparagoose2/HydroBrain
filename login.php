<!DOCTYPE html>
<html lang="en">

<?php 
session_start();
$dbhost = "182.50.133.173";
$dbuser = "studDB21a";
$dbpass = "stud21DB1!";
$dbname = "studDB21a";

$URL = "http://localhost/";

$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(mysqli_connect_errno()) {
    die("DB connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}

if(!empty($_POST["email"])) {
    // echo "FORM SENT";
    $query  = "SELECT * FROM tb_users_212 WHERE email='".$_POST["email"]."' and password='". $_POST["pass"]."'";
    // echo $query;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    
    if (is_array($row)) {
        // echo "authontication success!";
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_first_name"] = $row["first_name"];
        $_SESSION["user_last_name"] = $row["last_name"];
        $_SESSION["system_status"] = "Online";
        header("Location:".$URL."dynamicList.php");
    } else {
        $message = "authentication failed!";
    }
}




?>



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="css/login.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login</title>
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="images/green_logo.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form action="#" method="POST">
                <input type="email" id="login" class="fadeIn second" name="email" placeholder="email">
                <input type="password" id="password" class="fadeIn third" name="pass" placeholder="password">
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>

            <!-- Remind Passowrd -->
            <!-- <a class="underlineHover" href="#">Forgot Password?</a> -->
            <?php if(isset($message)) {
                echo ' 
                <div id="formFooter">
                    <span>Invalid username or password!</span>
                    </div>
                    ';
                }
                ?>

        </div>
    </div>

</body>

</html>
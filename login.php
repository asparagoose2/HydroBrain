<!DOCTYPE html>
<html lang="en">

<?php 
include "config.php";
include "db.php";

session_start();


if(!empty($_POST["email"])) {
    $query  = "SELECT * FROM tb_users_212 WHERE email='".$_POST["email"]."' and password='". $_POST["pass"]."'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    
    if (is_array($row)) {
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["user_first_name"] = $row["first_name"];
        $_SESSION["user_last_name"] = $row["last_name"];
        $_SESSION["location"] = $row["location"];
        $_SESSION["user_img"] = $row["profile_pic"];
        $_SESSION["system_status"] = "Online";
        $_SESSION["time_zone"] = $_POST["timeZone"];
        header("Location:".$URL."/index.php");
    } else {
        $message = "authentication failed!";
    }
}

?>

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="css/login.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login · HydroBrain</title>
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
            <?php echo '<form action="login.php" method="POST">'; ?>
                <input type="email" id="login" class="fadeIn second" name="email" placeholder="email">
                <input type="password" id="password" class="fadeIn third" name="pass" placeholder="password">
                <input type="submit" class="fadeIn fourth" value="Log In">
                <input type="hidden" name="timeZone" value='Asia/Jerusalem'>
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
    <script>
        
    </script>
</body>

</html>

<?php
    mysqli_close($connection);
?>
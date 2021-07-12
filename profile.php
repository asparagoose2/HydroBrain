<!DOCTYPE html>
<html lang="en">
<?php 
    include "db.php";
    include "config.php";
    session_start();
    if(!$_SESSION){
        header("Location: ".$URL."/login.php");
    }
    if(isset($_GET["update"])) {
        $query = 'update tb_users_212 set first_name="'.$_POST["fName"].'", last_name="'.$_POST["lName"].'", email="'.$_POST["email"].'", location="'.$_POST["location"].'" where user_id='.$_SESSION["user_id"];
        $result = mysqli_query($connection, $query);
        if(mysqli_affected_rows($connection) >0 ) {
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["user_first_name"] = $_POST["fName"];
            $_SESSION["user_last_name"] = $_POST["lName"];
            $_SESSION["location"] = $_POST["location"];
            $update_satus = array("status" => "success", "msg" => "Changes Saved!" );
        } else {
            $update_satus = array("status" => "danger", "msg" => "Oh oh... Changes Not Saved!" );
        }
    }
    
?>
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>HydroBrain</title>
</head>

<body>
    <section class="wrapper">
    <header>
            <div class="burgerMenu">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.php">Home</a>
                    <a href="dynamicList.php">Plants</a>
                    <a href="allPlants.php">Community</a>
                    <a href="#">Settings</a>
                    <section class="userNameB"> 
                    <?php echo '<a href="profile.php"><img src="images/'.$_SESSION["user_img"].'"> &nbsp; '. $_SESSION["user_first_name"] .' </a>' ?>
                    <a href="logout.php">Log Out</a> 
                    </section>
                </div>

                <span style="font-size:30px;cursor:pointer; color: white;" onclick="openNav()">&#9776;</span>

            </div>
            <a href="index.php" id="logo"></a>
            <nav>
                <a href="index.php"><svg><use xlink:href="images/navIcons.svg#home"></svg><br> Home</a>
                <a href="dynamicList.php"> <svg><use xlink:href="images/navIcons.svg#plants"></svg><br> My Plants</a>
                <a href="allPlants.php"> <svg><use xlink:href="images/navIcons.svg#community"></svg><br> Community</a>
                <a href="#"><svg><use xlink:href="images/navIcons.svg#settings"></svg><br> Settings</a>
            </nav>
            <section class="userName">
                <section class="systemStatus">
                    <?php echo
                    '<section class="circle'.($_SESSION["system_status"]?"":" offline").
                    '"></section> &nbsp; System '.($_SESSION["system_status"]?"Online":" Offline").'</section>' ?>

                <section>
                <div class="dropdown">
                    <a class="user" type="button" data-bs-toggle="dropdown" href="#"><?php echo '<img src="images/'.$_SESSION["user_img"].'"> &nbsp;'.$_SESSION["user_first_name"].'</a>'; ?>
                    <div class="dropdown-menu" style="margin-top: 10px;" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" style="color: #dc3545;" href="logout.php">Log Out</a>
                    </div>
                </div>
            </section>
    </header>
        <div class="container profile">
            <div class="main-body">
                
            <?php if(isset($update_satus)) {
                echo '<div class="alert alert-dismissible show alert-'.$update_satus["status"].'" role="alert">'.$update_satus["msg"].
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button></div>';
            } ?>
        
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3 align-items-stretch">
                        <div class="card">
                            <div class="card-body h-300">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <?php echo '<img src="images/'.$_SESSION["user_img"].'" alt="Admin" 
                                        class="rounded-circle" width="150">'; ?>
                                    <div class="mt-3">
                                        <?php echo '<h4>'.ucfirst($_SESSION["user_first_name"])." ".ucfirst($_SESSION["user_last_name"]).'</h4>'; ?>
                                        <?php echo '<p class="text-secondary mb-1">'.ucwords($_SESSION["location"]).'</p>'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php if(isset($_GET["edit"])) {
                        echo ' 
                        <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body h-300">
                                <form action="profile.php?update" method="POST">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">First Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"> <input type="text" class="form-control"
                                                value="'.$_SESSION["user_first_name"].'" name="fName" required >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Last Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"> <input type="text" class="form-control"
                                                value="'.$_SESSION["user_last_name"].'" name="lName" required >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"> <input type="email" class="form-control"
                                                value="'.$_SESSION["email"].'" name="email" required >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Location</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"> <input type="text" class="form-control"
                                                value="'.$_SESSION["location"].'" name="location" required >
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary"> <input type="submit"
                                                class="btn btn-primary px-4" value="Save Changes"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>';
                    } else {
                        echo '
                        <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body h-300">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">'.
                                    ucfirst($_SESSION["user_first_name"]).'
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Last Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">'.
                                    ucfirst($_SESSION["user_last_name"]).'
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">'.
                                    ucfirst($_SESSION["email"]).'
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Location</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">'.
                                    ucfirst($_SESSION["location"]).'
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-12 d-flex justify-content-around ">
                                        <a class="btn btn-dark" href="profile.php?edit">Edit
                                            Profile</a>
                                        <a class="btn btn-info btn-danger" href="#">Delete
                                            Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        ';
                    } ?>
                    
                </div>

            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php
    mysqli_close($connection);
?>
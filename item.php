<?php 
    include "db.php";
    session_start();
    if(!$_SESSION){
        header("Location: http://localhost/login.php");
    }
    if(isset($_POST["action"])) {
        if($_POST["action"]=="update") {
            $query = 'update tb_plants_212 set plant_name="'.$_POST["nickname"].'", cell="'.$_POST["newCell"].'" where plant_id='.$_POST["plantId"];
        
        if(!mysqli_query($connection, $query)) {
            print_r("error");
        }
        $update = "Plant updated successfuly!";
        $query  = "select * from tb_plants_212 inner join tb_plant_type_212 using(type_id) where plant_id=".$_POST["plantId"];
        $result = mysqli_query($connection, $query);
        $plant = mysqli_fetch_array($result, MYSQLI_BOTH);
        //$redirect = '<meta http-equiv="refresh" content="3;url=item.php?plantCell='.$plant["cell"].'" >';


        } else if ($_POST["action"]=="insert") {
            $query = 'insert into tb_plants_212 (user_id,type_id,plant_name,cell,status) 
            values ('
            .$_SESSION["user_id"].','
            .$_POST["plantType"].','
            .'"'.$_POST["plantName"].'",'
            .$_POST["newCell"].','
            .'"'.$_POST["status"].'")';
            if(!mysqli_query($connection, $query)) {
                print_r("error");
            }
            $update = "Plant added successfuly!";
            $query  = "select * from tb_plants_212 inner join tb_plant_type_212 using(type_id) where cell=".$_POST["newCell"].' and user_id='.$_SESSION["user_id"];
            $result = mysqli_query($connection, $query);
            $plant = mysqli_fetch_array($result, MYSQLI_BOTH);
        } else if ($_POST["action"]=="delete") {
            $query = 'delete from tb_likes_212 where plant_id='.$_POST["plant_id"];
            mysqli_query($connection, $query);
            $query = 'delete from tb_plants_212 where plant_id='.$_POST["plant_id"];
            if(!mysqli_query($connection, $query)) {
                print_r("error");
            }
        }
    } else {
        $query  = "select * from tb_plants_212 inner join tb_plant_type_212 using(type_id) where cell=".$_GET["plantCell"].' and user_id='.$_SESSION["user_id"];
        $result = mysqli_query($connection, $query);
        $plant = mysqli_fetch_array($result, MYSQLI_BOTH);
    }
    if(!$plant) {
        header("Location:".$URL."dynamicList.php");
    }

    $query  = "select first_name, count(*) num_of_likes from tb_likes_212 l inner join tb_users_212 u on l.user_id = u.user_id group by plant_id having plant_id=".$plant["plant_id"];
    $result = mysqli_query($connection, $query);
    $likes = mysqli_fetch_array($result, MYSQLI_BOTH);
    
    $query  = "select first_name, last_name from tb_likes_212 l inner join tb_users_212 u on l.user_id = u.user_id where plant_id=".$plant["plant_id"];
    $likers = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo isset($redirect)?$redirect:"" ?>
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Plant · HydroBrain</title>
</head>
<body>
    <section class="wrapper">
    <header>
            <div class="burgerMenu">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.php">Home</a>
                    <a class="selectedB" href="dynamicList.php">Plants</a>
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
                <a class="selected" href="dynamicList.php"> <svg><use xlink:href="images/navIcons.svg#plants"></svg><br> My Plants</a>
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
                    <a class="user" type="button" data-toggle="dropdown" href="#"><?php echo '<img src="images/'.$_SESSION["user_img"].'"> &nbsp;'.$_SESSION["user_first_name"].'</a>'; ?>
                    <div class="dropdown-menu" style="margin-top: 10px;" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" style="color: #dc3545;" href="logout.php">Log Out</a>
                    </div>
                </div>
            </section>
        </header>
        
        <section class="sideContent column no-padding">
            <section class="sidebarTitle">
                <a href="dynamicList.php"> <img src="images/leftArrow.svg" alt="back"></a>
                <?php echo '<img class="plantIcon" src="images/'.$plant["type_name"].'.svg" alt="back">' ?>
                <h1 ><?php echo ucfirst($plant["plant_name"]?$plant["plant_name"]:$plant["type_name"]) ?></h1>
                <a id="sideBarBtn"><img src="images/x.svg" alt=""></a>
            </section>
            <section class="breadcrumbsSection">
                <ol class="breadcrumbs">
                    <li class="breadcrumbsItem"><a href="list.html">plants</a></li>
                    <li class="breadcrumbsItem"><?php echo ucfirst($plant["plant_name"]?$plant["plant_name"]:$plant["type_name"]) ?></li>
                </ol>
            </section>
            <section class="object">
                <section class="objectImage">
                    <img src="images/Ripe-eggplant.jpg" alt="live photo">
                </section>
                <section class="objectContent">
                    <span><label>Plant Type:</label><br><?php echo ucfirst($plant["type_name"])  ?></span>
                    <span><label>Nickname:</label><br><?php echo ucfirst($plant["plant_name"]?$plant["plant_name"]:$plant["type_name"]) ?></span>
                    <span><label>Location:</label><br>Cell #<?php echo $plant["cell"] ?></span>
                    <span><label>Value:</label><br><?php echo $plant["value"] ?> $/kg</span>
                    <span><label>Planted on:</label><br><?php echo date("d/m/Y",strtotime($plant["planting_time"])) ?></span>
                    <span><label>Age:</label><br><?php echo floor((time()-strtotime($plant["planting_time"]))/(60*60*24))." days old" ?></span>
                    <span><label>Status:</label><br><?php echo ucfirst($plant["status"]) ?></span> 
                    <span><label>Liked by:  <br> </label> 
                    <!-- Calculate Number Of Likes -->
                    <?php  
                    if(!$likes) {
                        echo "No one.. 😔" ;
                     } else {
                        $row = mysqli_fetch_assoc($likers);
                        if($likes["num_of_likes"]<2) { // if only one like, just write user's first name
                         
                            echo $row["first_name"]; 
                        } else { // more than 1 like, write user's forst name and write how many more like there are
                            
                            echo $row["first_name"]." and ".'
                            <div style="display: inline-block;" class="dropdown">
                            <a type="button" data-toggle="dropdown" href="#">'.$likes["num_of_likes"]-1 . " more </a>  ";
                        }
                    } 
                    ?>
                    <!-- Make a dropdown to list all the other likers names -->
                    <div class="dropdown-menu" style="margin-top: 10px; max-height: 200px;overflow-y: auto;">
                    <?php while($row = mysqli_fetch_assoc($likers)) {

                            echo '<a class="dropdown-item" href="#">'.$row["first_name"]." ".$row["last_name"].'</a>';
                        }
                    ?> 
                    </div>
                </div></span>
                    
                </section>
                <div class="alert alert-success w-75 <?php echo isset($update)?"":"hide" ?>" role="alert">
                    <?php echo $update? $update : "" ?>
                </div>
                <section class="objectButtons">
                <?php echo '<a href="editItem.php?plantCell='.$plant["cell"].'" class="btn btn-dark btn-lg">Edit</a>'; ?> 
                    <form action="item.php" method="post"">
                    <?php echo '<input type="hidden" name="plant_id" value="'.$plant["plant_id"].'">'; ?>
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" id="harvestBtn" class="btn btn-success btn-lg" <?php echo $plant["status"] == "ready"?"":"disabled" ?> >Harvest</button>
                    </form>
                </section>
            </section>
        </section>
        <main>
        <section class="mapContainer column">
            <section class="map">
                <div class="loader">
                    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
            </section>
        </section>
        </main>
        <div class="clear"></div>
    </section>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<!-- <header></header>
<aside></aside>
<main>

    
</main> -->
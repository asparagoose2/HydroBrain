<?php 
    include "db.php";
    session_start();
    if(!$_SESSION){
        header("Location: http://localhost/login.php");
    }
    $query  = "select * from tb_plants_212 inner join tb_plant_type_212 using(type_id) where cell=".$_GET["plantCell"].' and user_id='.$_SESSION["user_id"];
    $result = mysqli_query($connection, $query);
    $plant = mysqli_fetch_array($result, MYSQLI_BOTH);
    if(!$plant) {
        header("Location:".$URL."dynamicList.php");
    }
    $query  = "select cell from tb_plants_212 where user_id='" . $_SESSION["user_id"]."'";
    $result = mysqli_query($connection, $query);
    $emptyCells = range(1,50);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result))
        {
            if($row["cell"] != $plant["cell"]) {
                unset($emptyCells[$row["cell"]-1]);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edit · HydroBrain</title>
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
                    <li class="breadcrumbsItem"><a href="dynamicList.php">plants</a></li>
                    <li class="breadcrumbsItem"><?php echo ucfirst($plant["plant_name"]?$plant["plant_name"]:$plant["type_name"]) ?></li>
                </ol>
            </section>
            <section class="object">
                <section class="objectImage">
                    <img src="images/Ripe-eggplant.jpg" alt="live photo">
                </section>
                <section >
                    <form class="objectContent" action="item.php" method="post">
                    <span><label>Plant Type:</label><br><?php echo ucfirst($plant["type_name"])  ?></span>
                    <span><label>Nickname:</label><br>
                    <?php 
                        echo '<input id="cellSelect" class="form-control" name="nickname" type="text" placeholder="'.$plant["plant_name"].'" value="'.$plant["plant_name"].'" >'
                    ?>
                    </span>
                    <span><label>Location:</label><br>
                    <select class="form-control" name="newCell" value="5">
                    <?php foreach($emptyCells as $cell) {
                        echo '<option value="'.$cell.'"'.($cell == $plant["cell"]?" selected ":"").">".$cell."</option>";
                    }
                    ?>
                    </select>
                    </span>
                    <span><label>Value:</label><br><?php echo $plant["value"] ?> $/kg</span>
                    <span><label>Planted on:</label><br><?php echo date("d/m/Y",strtotime($plant["planting_time"])) ?></span>
                    <span><label>Age:</label><br><?php echo floor((time()-strtotime($plant["planting_time"]))/(60*60*24))." days old" ?></span>
                    <span><label>Status:</label><br><?php echo ucfirst($plant["status"]) ?></span> 
                </section>
                <!-- <div class="alert alert-success w-75 hide" role="alert">
                    Plant removed successfuly!
                </div> -->
                <section class="objectButtons">
                <?php echo '<a href="item.php?plantCell=' . $plant["cell"] . '" class="btn btn-danger btn-lg">Cancel</a>' ?>
                        <?php echo '<input type="hidden" name="plantId" value="'.$plant["plant_id"].'">' ?>
                        <input type="hidden" name="action" value="update">
                        <?php echo '<input type="hidden" name="plantCell" value="'.$plant["cell"].'">' ?>
                        <button type="submit" id="harvestBtn" class="btn btn-success btn-lg">Save</button>
                    </section>
                </form>
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
<?php
    mysqli_close($connection);
?>
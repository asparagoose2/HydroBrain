<?php 
    include "db.php";  
    session_start();
    header("Set-Cookie: SameSite=Lax;");
    if(!$_SESSION){
        header("Location:".$URL."login.php");
    }
    $query  = "SELECT * FROM tb_tasks_212 WHERE user_id='".$_SESSION["user_id"]."'";
    $result = mysqli_query($connection, $query);
    $tasks = mysqli_fetch_all($result, MYSQLI_BOTH);

     
    $query  = "select *, (select count(*) from tb_plants_212 where user_id ='".$_SESSION["user_id"]."') as total_plants, (select count(*) from tb_plants_212 where user_id ='".$_SESSION["user_id"]."' and tb_plants_212.status = 1) as ready_plants from tb_gardens_212 g";
    $result = mysqli_query($connection, $query);
    $stats = mysqli_fetch_array($result, MYSQLI_BOTH);
    
    date_default_timezone_set($_SESSION["time_zone"]);
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
    <title>HydroBrain</title>
</head>
<body>
    <section class="wrapper">
    <header>
            <div class="burgerMenu">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a class="selectedB" href="index.php">Home</a>
                    <a href="dynamicList.php">My Plants</a>
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
                <a class="selected" href="index.php"><svg><use xlink:href="images/navIcons.svg#home"></svg><br> Home</a>
                <a  href="dynamicList.php"> <svg><use xlink:href="images/navIcons.svg#plants"></svg><br> My Plants</a>
                <a  href="allPlants.php"> <svg><use xlink:href="images/navIcons.svg#community"></svg><br> Community</a>
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
        <section class="homeWrapper">
            <section class="homePage">
                <span class="welcomeSection">
                    <?php 
                      echo  "<h1>Good ".
                            (date("H") < 12 ? "Morning":(date("H")>17?"Evening":"Afternoon"))
                            .", ".$_SESSION["user_first_name"]."!</h1>
                            <h3>".date("l, F jS, Y")."</h3>"
                        ?>
                </span>
                <section class="tasks">
                    <?php echo "<h2>YOU'VE GOT ".(count($tasks)?count($tasks):"NO")." TASKS TODAY</h2>" ?> 
                    <section class="tasksList scroll">
                        <?php
                            foreach($tasks as &$task) {
                                echo '<a href="#">'.
                                '<h1>'.strtoupper($task["title"]).'</h1>'.
                                '<p>'.$task["info"].'</p>';
                            }
                        ?>                    
                    </section>
                </section>
                <section class="weather">
                    <a class="weatherwidget-io" href="https://forecast7.com/en/n0d0237d91/kenya/" data-font="Roboto" data-icons="Climacons Animated" data-mode="Current" data-days="5" data-theme="pure" data-highcolor="#000000" data-lowcolor="#878686" >Kenya</a>
                    <a class="weatherwidget-io" href="https://forecast7.com/en/n0d0237d91/kenya/" data-font="Roboto" data-icons="Climacons Animated" data-mode="Forecast" data-days="5" data-theme="pure" data-highcolor="#000000" data-lowcolor="#878686" >Kenya</a>        </section>
                </section>
            <section class="homeStats">
                    <section class="homeCard">
                        <h3>plants ready</h3>
                        <?php echo '<h4 class="stat">'.$stats["ready_plants"]."<span>/".$stats["total_plants"]."</span></h4>" ?>
                    </section>
                    <section class="homeCard">
                        <h3>issues</h3>
                        <?php echo '<h4 class="stat">'.$stats["issues"]."</h4>" ?>
                    </section>
                    <section class="homeCard">
                        <h3>health</h3>
                        <?php echo '<h4 class="stat">'.$stats["health"]."%</h4>" ?>
                    </section>
                    <section class="homeCard">
                        <h3>water values</h3>
                        <section class="waterVal">
                            <h5>Temperature:</h5>
                            <?php echo "<h5>".$stats["temp"]."°C</h5>" ?>
                            <h5>pH Level:</h5>
                            <?php echo "<h5>".$stats["ph_value"]."</h5>" ?>
                            <h5>Conductivuty:</h5>
                            <?php echo "<h5>".$stats["ec_value"]."</h5>" ?>
                        </section>
                    </section>
                    <section class="homeCard liveView">
                        <!-- <h3> &nbsp;</h3> -->
                    </section>
                <section class="homeCard gaugeSec">
                    <h3>reservoir</h3>
                    <div>
                        <div id="phGauge" class="gauge-container"></div>
                        <div id="fertilizerGauge" class="gauge-container"></div>
                        <div id="waterGauge" class="gauge-container"></div>
                        <span class="gaugeLable">pH</span>
                        <span class="gaugeLable">Fertilizer</span>
                        <span class="gaugeLable">Water</span>
                    </div>
                </section>
        </section>
    <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
            var phLevel = <?php echo $stats["ph_level"]  ?>;
            var fertiLevel = <?php echo $stats["fertilizer_level"]  ?>;
            var waterLevel = <?php echo $stats["water_level"]  ?>;
    </script>
    <script src="js/gauge.js"></script>
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

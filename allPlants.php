<?php
include "config.php";
include "db.php";
include "config.php";

session_start();
if(!$_SESSION){
    header("Location: ".$URL."/login.php");
}

$query_plants = "SELECT *
from tb_users_212 
       inner join tb_plants_212 
           on tb_users_212.user_id = tb_plants_212.user_id
       inner join tb_plant_type_212
           on tb_plant_type_212.type_id = tb_plants_212.type_id " . (isset($_GET['sort'])? "order by ".$_GET['sort']:"");

           $result = mysqli_query($connection,$query_plants);
           $plants = array();

           if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($plants,$row);
            }
        }
           if (!$plants) {
            die("DB query faild");
        }

if(isset($_GET['filter'])){

    if($_GET['filter']=='sick'){
        $query_filter = "SELECT *
    from tb_users_212 
        inner join tb_plants_212 
            on tb_users_212.user_id = tb_plants_212.user_id
        inner join tb_plant_type_212
            on tb_plant_type_212.type_id = tb_plants_212.type_id where status='sick'";
            $result = mysqli_query($connection,$query_filter);
            $plants = array();
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($plants,$row);
                }
            }
} 
        
else if($_GET['filter']=='ready'){
        $query_filter = "SELECT *
    from tb_users_212 
        inner join tb_plants_212 
            on tb_users_212.user_id = tb_plants_212.user_id
        inner join tb_plant_type_212
            on tb_plant_type_212.type_id = tb_plants_212.type_id where status='ready'";
            $result = mysqli_query($connection,$query_filter);
            $plants = array();
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($plants,$row);
                }
            }
           
        }  
        
       }      
      
       $query_plants = "SELECT *
       from tb_users_212 
              inner join tb_plants_212 
                  on tb_users_212.user_id = tb_plants_212.user_id
              inner join tb_plant_type_212
                  on tb_plant_type_212.type_id = tb_plants_212.type_id ";



        $query= "SELECT plant_id from tb_likes_212 where user_id=".$_SESSION["user_id"];

        $result = mysqli_query($connection,$query);
        $likes = array();
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($likes,$row["plant_id"]);
            }
        }
        if(isset($_GET["searchKey"])){
        $search=$_GET["searchKey"];
        $query="SELECT *
        from tb_users_212 
               inner join tb_plants_212 
                   on tb_users_212.user_id = tb_plants_212.user_id
               inner join tb_plant_type_212
                   on tb_plant_type_212.type_id = tb_plants_212.type_id
                   where (status like '%".$search."%' or plant_name like '%".$search."%' or first_name like '%".$search."%' or last_name like '%".$search."%')";
            $result = mysqli_query($connection,$query);
            $plants = array();
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($plants,$row);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Community · HydroBrain</title>
</head>
<body>
    <section class="wrapper">
    <header>
            <div class="burgerMenu">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.php">Home</a>
                    <a href="dynamicList.php">Plants</a>
                    <a class="selectedB" href="allPlants.php">Community</a>
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
                <a class="selected" href="allPlants.php"> <svg><use xlink:href="images/navIcons.svg#community"></svg><br> Community</a>
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
        <section class="listMenu">
        <form action="allPlants.php">
            <section class="searchBar" > 
                <input type="text" class="form-control w-75" name="searchKey" placeholder="Search" id="search" <?php if(isset($_GET["searchKey"])){echo (isset($_GET["searchKey"][0]))?'value="'.$_GET["searchKey"].'"':"";} ?> >
    </form>
                    <section class="sorticons">
                        <div class="dropdown show">
                         <a href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <img src="images/funnel.svg" class="seachBarIcons" alt="filter">
                         </a>
                         <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href='allPlants.php?filter=sick'>sick</a>
                            <a class="dropdown-item" href='allPlants.php?filter=ready'>Ready to Harvest</a>
                         </div>
                        </div>
                        <div class="dropdown show">
                             <a href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <img src="images/sortArrow.svg" class="seachBarIcons" alt="sort">
                             </a>
                         <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                         <a class="dropdown-item" href='allPlants.php?sort=planting_time'>Age</a>
                         <a class="dropdown-item" href='allPlants.php?sort=type_name'>Type</a>
                         <a class="dropdown-item" href='allPlants.php?sort=first_name'>User</a>
                         </div>
                       </div>
                </section>
            </section>
            <div class="clear"></div>
            <?php
            echo '<ul class="plantsList ">';
            foreach($plants as &$plant ) {  
                echo     '<li class="plantListItem allPlantList"><a  href="#a">';
                echo     '<span class="name"> <img src="images/'.$plant["type_name"].'.svg"' .'alt="beet">';
                echo     ucfirst($plant["plant_name"]). '</span>';
                echo     '<span class="info">'.ucfirst($plant["status"]).'&nbsp &nbsp &nbsp</span><span class="info">'.$timestamp1 =(floor(((strtotime(date("Y-m-d H:i:s")))- (strtotime($plant["planting_time"]))) / 60 / 60 / 24)).' days ago'.'</span>';
                echo     '<span class="info">'.$plant["value"].'&nbsp $/Kg </span>';
                echo     '<span class="growerName">'.$plant["first_name"].'&nbsp'.$plant["last_name"].'</span></a>';       
                echo     '<button  onclick="likeOnClick(this)" id='.$plant["plant_id"].' class="likeButton like'.(in_array($plant["plant_id"],$likes)?" liked":"").'"> <i class="fa fa-thumbs-up"></i></button></li>';
            }
                echo    '</ul>';
           
            ?>
        </section>
    </section>
    <script src="js/likes.js"></script>
    <script src="js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<?php
    mysqli_close($connection);
?>
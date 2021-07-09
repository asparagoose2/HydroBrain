
<?php
include "config.php";

$dbhost = "182.50.133.173";
$dbuser = "studDB21a";
$dbpass = "stud21DB1!";
$dbname = "studDB21a";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//testing connection success
if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . 
 		mysqli_connect_errno() . ")");
}


?>


<!-- $plant = array(
    "type" => "beet",
    "age"=> "9 days",
    "user" =>"Agwella"
); -->


<?php
$query_plants = "SELECT tb_users_212.first_name, tb_users_212.last_name, tb_plants_212.planting_time, tb_plants_212.plant_name, tb_plant_type_212.type_name 
from tb_users_212 
       inner join tb_plants_212 
           on tb_users_212.user_id = tb_plants_212.user_id
       inner join tb_plant_type_212
           on tb_plant_type_212.type_id = tb_plants_212.type_id ";
//  $query_plants = "SELECT * FROM tb_plants_212";

 $result = mysqli_query($connection,$query_plants);
 $plants = mysqli_fetch_all($result,MYSQLI_BOTH);



    if (!$plants) {
        die("DB query faild");
    }
?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>PLANTS</title>
</head>
<body>
    <section class="wrapper">
        <header> 
            <div class="burgerMenu">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.html">Home</a>
                    <a class="selectedB" href="list.html">Plants</a>
                    <a href="#">Setting</a>
                    <section class= "userNameB">
                    <a href="#"><img src="images/Agvella.svg"> &nbsp; Agvella</a>
                     </section>  
                  </div>
                  
                  <span style="font-size:30px;cursor:pointer; color: white;" onclick="openNav()">&#9776;</span>
                  
                  </div> 
            <a href="index.html" id="logo"></a>
            <nav>
                <a href="index.html"><img src="images/home.svg"><br> Home</a>
                <a class="selected" href="list.html"> <img src="images/plants.svg"><br> Plants</a>
                <a  href="#"><img src="images/settings.svg"><br> Setting</a>
            </nav>
            <section class="userName">
            <section class="systemStatus">
                <section class="circle"></section> &nbsp; System Online
            </section>
            
            <section ><a class="user" href="#"><img src="images/Agvella.svg"> &nbsp; Agvella</a></section>
            </section>  
        </header>
        <section class="listMenu ">
            <section class="searchBar searchAllPlants" >
                <input type="text" class="form-control w-50" name="searchKey" placeholder="Search" id="search">
                <div class="sortIcons">
                  <div class="dropdown show">
                    <a href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/sortArrow.svg" class="seachBarIcons sort" alt="filter">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item" href='list.html?filter="sick"'>sick</a>
                      <a class="dropdown-item" href='list.html?filter="ready"'>Ready to Harvest</a>
                    </div>
                  </div>
                <div class="dropdown show">
                    <a href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/funnel.svg" class="seachBarIcons" alt="sort">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item" href='list.html?sort="age"'>Age</a>
                      <a class="dropdown-item" href='list.html?sort="type"'>Type</a>
                      <a class="dropdown-item" href='list.html?sort="health'>Health</a>
                    </div>
                  </div>
                </div> 
            </section>
            <div class="clear"></div>
            <?php
            echo '<section class="listSection scroll">';
            echo '<ul class="plantsList">';
            foreach($plants as &$plant ) {  
                echo     '<li class="plantListItem allPlantList"><a  href="item.html?itemID=7">';
                echo     '<img src="images/'.$plant["type_name"].'.svg"' .'alt="beet">';
                echo     '<span class="plantListName">'.$plant["plant_name"]. '</span>';
                echo     '<span class="plantListInfo">'.$plant["planting_time"]. '</span>';
                echo     '<span class="growerName">'.$plant["first_name"].'&nbsp'.$plant["last_name"].'</span></a>';       
                echo     '<button class="likeButton like"> <i class="fa fa-thumbs-up"></i></button></li>';
            }
                echo    '</ul>';
                echo '</section>';
           
            ?>
        </section>
    </section>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
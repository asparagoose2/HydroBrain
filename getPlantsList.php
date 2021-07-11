<?php
include "db.php";  

session_start();

if(!$_SESSION["user_id"]){
    header("HTTP/1.1 401 Unauthorized");
}

$query  = 'select * from tb_plants_212 inner join tb_plant_type_212 using(type_id) where user_id='.$_SESSION["user_id"];

$result = mysqli_query($connection, $query);

$plants = array();

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        array_push($plants,$row);
    }
}

$plantJSON = json_encode($plants);

echo $plantJSON;


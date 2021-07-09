<?php
include "db.php";  
session_start();
if(!$_SESSION){
    header("HTTP/1.1 401 Unauthorized");
}

$query  = 'select * from tb_plants_212 inner join tb_plant_type_212 using(type_id) where user_id='.$_SESSION["user_id"];

$result = mysqli_query($connection, $query);
$plants = mysqli_fetch_all($result, MYSQLI_BOTH);

$plantJSON = json_encode($plants);

echo $plantJSON;


<?php
include "db.php";  

$query  = 'insert into tb_plants_212 (user_id, type_id, plant_name, planting_Time, cell, value, status) values('.
$_POST["user_id"].', '.
$_POST["plant_type"].', "'.
$_POST["plant_name"].'", "'.
$_POST["planting_time"].'", '.
$_POST["cell"].', '.
$_POST["value"].', "'.
$_POST["status"].'")';

$result = mysqli_query($connection, $query);
// $plants = mysqli_fetch_all($result, MYSQLI_BOTH);

// $plantJSON = json_encode($plants);

echo json_encode($result);


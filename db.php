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


/*
    query to select the garden with total num of plants:
    select *, (select count(*) from plants where user_id = g.user_id) as num_of_plants from garden g;
    
    this is with ready plants as well:
    select *, (select count(*) from plants where user_id = g.user_id) as num_of_plants, (select count(*) from plants where user_id = g.user_id and plants.status = 1) as ready from garden g;

*/
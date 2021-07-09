<?php

include "db.php";

$query  = "insert into tb_plant_type_212 (type_name) values (".$_GET["type"].")";
echo mysqli_query($connection, $query);
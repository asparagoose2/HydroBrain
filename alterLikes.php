<?php
include "db.php";  
session_start();
if(!$_SESSION){
    header("HTTP/1.1 401 Unauthorized");
}

if(!isset($_POST['plant_id'])) {
    header("HTTP/1.1 400 Bad request");
}

if($_POST['action']=='insert' ){

    $query='INSERT INTO  tb_likes_212 VALUES ('.$_SESSION["user_id"].','.$_POST['plant_id'].')';
} else if($_POST['action']=='delete' ){

    $query=  'DELETE FROM tb_likes_212 WHERE user_id='.$_SESSION["user_id"].' and plant_id='. $_POST['plant_id'];
} else {
    header("HTTP/1.1 406".$_POST["action"]);
}

mysqli_query($connection, $query);

mysqli_close($connection);
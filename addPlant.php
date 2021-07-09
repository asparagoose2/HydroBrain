<?php 
    include "db.php";
    session_start();
    if(!$_SESSION){
        header("Location: http://localhost/login.php");
    }
    $query  = "select * from tb_plant_type_212";
    $result = mysqli_query($connection, $query);
    $types = mysqli_fetch_all($result, MYSQLI_BOTH);
    if(!$types) {
        header("Location:".$URL."dynamicList.php");
    }
    $query  = "select cell from tb_plants_212 where user_id='" . $_SESSION["user_id"]."'";
    $result = mysqli_query($connection, $query);
    $emptyCells = range(1,50);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result))
        {
            unset($emptyCells[$row["cell"]-1]);
        }
    }
    $typeMap = array();
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ADD PLANT</title>
</head>

<body>
    <section class="wrapper">
    <header>
            <div class="burgerMenu">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.php">Home</a>
                    <a class="selectedB" href="dynamicList.php">Plants</a>
                    <a href="#">Setting</a>
                    <section class="userNameB">
                    <?php echo '<a href="#"><img src="images/'.$_SESSION["user_first_name"].'.svg'.'"> &nbsp; '. $_SESSION["user_first_name"] .' </a>' ?>
                    </section>
                </div>

                <span style="font-size:30px;cursor:pointer; color: white;" onclick="openNav()">&#9776;</span>

            </div>
            <a href="index.php" id="logo"></a>
            <nav>
                <a href="index.php"><img src="images/home.svg"><br> Home</a>
                <a class="selected" href="dynamicList.php"> <img src="images/plants.svg"><br> Plants</a>
                <a href="#"><img src="images/settings.svg"><br> Setting</a>
            </nav>
            <section class="userName">
                <section class="systemStatus">
                    <?php echo
                    '<section class="circle'.($_SESSION["system_status"]?"":" offline").
                    '"></section> &nbsp; System '.($_SESSION["system_status"]?"Online":" Offline").'</section>' ?>

                <section><?php echo '<a href="#" class="user"><img src="images/'.$_SESSION["user_first_name"].'.svg'.'"> &nbsp; '. $_SESSION["user_first_name"] .' </a>' ?></section>
            </section>
    </header>
        <section class="sideContent column no-padding">
            <section class="sidebarTitle">
                <a href="list.html"> <img src="images/leftArrow.svg" alt="back"></a>
                <img class="plantIcon" id="plantIcon" src="images/strawberry.svg" alt="back">
                <h1>Add Plant</h1>
                <a id="sideBarBtn"><img src="images/x.svg"></a>
            </section>
            <section class="breadcrumbsSection">
                <ol class="breadcrumbs">
                    <li class="breadcrumbsItem"><a href="list.html">plants</a></li>
                    <li class="breadcrumbsItem">Add Plant</li>
                </ol>
            </section>
            <section class="objectImage">
                <!-- <h5>This plant is recomended for you! 🎉</h5> -->
                <img class="objectImage" id="plantPhoto" src="images/Strawberries.png" alt="live photo"><br> <br>
                <p><b>Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Nulla quam velit, vulputate eu
                        pharetra nec, mattis ac neque. Duis vulputate
                        commodo lectus</b></p>
            </section>

            <form action="item.php" method="post" class="objectContent add">
            <input type="hidden" name="action" value="insert">
                <input type="hidden" name="status" value="new born">
                <span>Type:
                    <select id="type" class="form-select w-100" name="plantType">
                    <option disabled selected value> -- select a type -- </option>
                        <?php
                            foreach($types as $type){
                                echo '<option value="'.$type["type_id"].'">'.ucfirst($type["type_name"]).'</option>';
                                $typeMap[$type["type_id"]] = $type["type_name"];
                            }
                        ?>
                    </select></span>
                <span>Location:
                    <select class="form-select w-100" id="cell" name="newCell">
                    <?php foreach($emptyCells as $cell) {
                        echo '<option value="'.$cell.'"'.">".$cell."</option>";
                    }
                    ?>
                    </select></span>
                <span> Nickname:
                    <input type="text" name="plantName" class="form-control w-100" id="floatingInput" value="">
                </span>
                <span><label>Priority:</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priority" id="radioLow" value="0">
                        <label class="form-check-label" for="radioLow">
                            Low
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priority" id="radioAuto" value="1" checked>
                        <label class="form-check-label" for="radioAuto">
                            Auto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priority" value="2" id="radioHigh">
                        <label class="form-check-label" for="radioHigh">
                            High
                        </label>
                    </div>
                </span>
                <section class="objectButtons COL">
                    <div class="alert alert-success hide" role="alert">
                        Plant added successfuly!
                    </div>
                    <button type="submit" id="plantBtn" data-bs-dismiss="alert"
                        class="btn btn-success btn-lg w-100">Plant</button>
                </section>
            </form>

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
    <script src="js/main.js"></script>
    <script src="js/addPlant.js"></script>
    <script>
        var typeMap = <?php echo json_encode($typeMap) ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
<!-- <header></header>
<aside></aside>
<main>

    
</main> -->
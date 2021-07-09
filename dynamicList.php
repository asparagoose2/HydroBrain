<!DOCTYPE html>
<html lang="en">
<?php 
    session_start();
    if(!$_SESSION){
        header("Location: http://localhost/login.php");
    }
?>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>MAP</title>
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
        <section class="sideContent column">
            <section class="searchBar">
                <input type="text" class="form-control w-50" name="searchKey" placeholder="Search" id="search">
                <div class="dropdown show">
                    <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/funnel.svg" class="seachBarIcons" alt="filter">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" id="filterSick" href='#'>Sick</a>
                        <a class="dropdown-item" id="filterReady" href='#'>Ready to Harvest</a>
                    </div>
                </div>
                <div class="dropdown show">
                    <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/sortArrow.svg" class="seachBarIcons" alt="sort">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" id="sortAge" href='#'>Age</a>
                        <a class="dropdown-item" id="sortType" href='#'>Type</a>
                    </div>
                </div>
                <a class="plusBtn" href="addPlant.php"></a>
                <a id="sideBarBtn"><img id="xBtn" src="images/xBlack.svg"></a>
            </section>
            <div class="clear"></div>
            <section class="listSection scroll">
            <div class="loader">
                    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
            </section>
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
    <script src="js/scripts.js"></script>
    <script src="js/dynamicList.js"></script>
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
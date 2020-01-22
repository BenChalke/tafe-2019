<?php

require_once 'settings/init.php';

if(isset($_POST['theme-form'])){
    $_SESSION['theme'] = $_POST['theme'];
}

if(isset($_POST['logout-form'])) {
    Authentication::logout();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Sports Warehouse</title>
    <?php
    if(isset($_SESSION['theme'])) {

        if($_SESSION['theme'] === 'black') {
        ?>
            <link href="css/styles-black.css" rel="stylesheet" type="text/css">
        <?php
        } else if($_SESSION['theme'] === 'red') {
        ?>
            <link href="css/styles-red.css" rel="stylesheet" type="text/css">
        <?php
        } else if($_SESSION['theme'] === 'green') {
            ?>
                <link href="css/styles-green.css" rel="stylesheet" type="text/css">
            <?php
        } else if($_SESSION['theme'] === 'pink') {
            ?>
                <link href="css/styles-pink.css" rel="stylesheet" type="text/css">
            <?php
        } else {
        ?>
            <link href="css/styles-default.css" rel="stylesheet" type="text/css">
        <?php
        }
    } else {
        $_SESSION['theme'] = 'default';
        ?>
        <link href="css/styles-default.css" rel="stylesheet" type="text/css">
        <?php
    }
    ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <script defer src="js/all.min.js"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script defer src="js/scripts.js"></script>
</head>
<body>

<header>

    <div id="header-top">
        <div id="header-top-inner" class="flexbox container-medium">
            <div id="header-nav">
                <ul id="main-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About SW</a></li>
                    <li><a href="contact-us.php">Contact Us</a></li>
                    <li><a href="products.php">View Products</a></li>
                </ul>

                <div id="mobile-menu" class="flexbox">

                    <div id="mobile-menu-btn">
                        <p onclick="activateMobileMenu()" id="mobile-menu-btn-p"><span class="fas fa-bars"></span></p>
                        <p id="menu-label-text">Menu</p>
                    </div>
                </div>
            </div>
            <div id="login-div">
            <?php
                 if(isset($_SESSION["username"])) {
                    ?>
                    <p id="admin-btn"><a href="admin.php">Admin</a></p>
                    
                    <form id='logout-btn-form' method='POST'>
                        <input type='hidden' value='logged out' name='logout-form'>
                        <input id='logout-btn' type="submit" value="Logout">
                    </form>
                    <?php
                } else {
                    ?>
                    <p id="login-btn"><a href="login.php">Login</a></p>
                    <?php
                }
                ?>

                <p id="cart"><a href="shopping-cart.php">View Cart</a></p>

                <p id="items"><a href="#"><?php
                    if(isset($_SESSION['cart'])) {
                        $cart = $_SESSION['cart'];
                        echo $cart->count();
                    } else {
                        echo '0';
                    }
                ?> items</a></p>
            </div>
            <div id="mobile-menu-nav">
                <ul id="mobile-menu-links">
                    <li><a href="login.php"><p>Login</p></a></li>
                    <li><a href="index.php"><p>Home</p></a></li>
                    <li><a href="about.php"><p>About SW</p></a></li>
                    <li><a href="contact-us.php"><p>Contact Us</p></a></li>
                    <li><a href="products.php"><p>View Products</p></a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div id="header-logo-div" class="flexbox container-medium">
        <div id="header-logo">
            <a href="index.php"><img src="images/logo.png" alt="Sports Warehouse Logo" class="img-responsive"></a>
        </div>
        <div id="header-search">
            <form action="/products.php" id="search-form" method="get">
                <input type="text" name='search' placeholder="Search Products">
                <button type='submit' id="search-button"><span class="fas fa-search"></span></button>
            </form>
        </div>
    </div>

    <div id="header-product-nav" class="container-medium">

        <div id="header-product-nav-inner">
            <ul class="flexbox">
                
            <?php

                //Write SQL statement
                $sql = "select * from category";
                //Execute the SQL statement and place the result into the rows variable
                $stmt = $db->connect()->prepare($sql);

                $rows = $db->executeSQL($stmt);
                //Write a foreach statement to display results of the SQL statement
                foreach ($rows as $row)
                {
                    print("<li><a href='/products.php?category=" . $row['category-name'] . "'><p class='category-name'>" . $row['category-name'] . "<span class='arrow-right fas fa-chevron-right'></span></p></a></li>");
                }
            ?>
            </ul>
        </div>

    </div>

</header>

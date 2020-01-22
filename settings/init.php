<?php

require_once 'classes/db-access.php';
require 'settings/db.php';
require_once "classes/product.php";
require_once "classes/cart-item.php";
require_once "classes/shopping-cart.php";
require_once "classes/authentication.php";

session_start();

//Connect to the database
$db = new DBAccess($host, $dbname, $username, $password);
$pdo = $db->connect();
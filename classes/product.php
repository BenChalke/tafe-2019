<?php
//this class is part of the business layer it uses the DBAccess class
require_once("db-access.php");

class Product {
    //private properties
    private $_productName;
    private $_productID;
    private $_price;
    private $_db;

    //constructor sets up the database settings and creates a DBAccess object
    public function __construct() {
        //get database settings
        require "settings/db.php";
        
        try {
            //create database object
            $this->_db = new DBAccess($host, $dbname, $username, $password);
        } catch (PDOException $e) {
            die("Unable to connect to database, ". $e->message());
        }
    }

    //set and get methods
    //get product ID, there is no set as the primary key should not be changed
    public function getProductID() {
        return $this->_productID;
    }
    
    //get product name
    public function getProductName() {
        return $this->_productName;
    }
    
    //get the price
    public function getPrice() {
        return $this->_price;
    }
    
    //get a product from the database for the id supplied
    public function getProduct($id) {
        try {
            //connect to db
            $pdo = $this->_db->connect();

            //set up SQL and bind parameters
            $sql = "SELECT `item-id`, `item-name`, price FROM `item` WHERE `item-id` =
            :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            //execute SQL
            $rows = $this->_db->executeSQL($stmt);
            //get the first row as it is a primary key there will only be one row
            $row = $rows[0];
            //populate the private properties with the retreived values
            $this->_productID = $row["item-id"];
            $this->_productName = $row["item-name"];
            $this->_price = $row["price"];
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getProducts() {
        try {
            //connect to db
            $pdo = $this->_db->connect();
            //set up SQL
            $sql = "SELECT `item-id`, `item-name`, `price` FROM `item`";
            $stmt = $pdo->prepare($sql);
            //execute SQL
            $rows = $this->_db->executeSQL($stmt);
            
            return $rows;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
?>
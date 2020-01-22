<?php
//this class is part of the business layer it uses the DBAccess class
require_once("db-access.php");

class Authentication {
    //constants hold values that do not change
    const LoginPageURL = "login.php";
    const SuccessPageURL = "admin.php";

    private static $_db;

    public static function login($login_username = '', $login_password = '') {
        if(strlen($login_password) <= 0 || strlen($login_username) <= 0) {
            return false;
        }
        $hash = "";
        //get database settings
        include "settings/db.php";


        try {
            //create database object, as the class is static we need to use
            //the keyword self instead of this
            self::$_db = new DBAccess($host, $dbname, $username, $password);
        } catch (PDOException $e) {
            die("Unable to connect to database, ". $e->message());
        }

        //check if user exists in database
        try {
            //connect to db as the class is static we need to use
            //the keyword self instead of this
            $pdo = self::$_db->connect();
            //set up SQL and bind parameters
            $sql = "SELECT `password` FROM `admin` WHERE `username` = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":username", $login_username, PDO::PARAM_STR);
            
            //execute SQL as the class is static we need to use
            //the keyword self instead of this
            $hash = self::$_db->executeSQLReturnOneValue($stmt);
        } catch (PDOException $e) {
            throw $e;
        }

        if(password_verify($login_password, $hash)) {
            //success password and username match
            echo 'password verified';
            $_SESSION["username"] = $login_username;
            //redirect the user to the success page
            header("Location: admin.php");
            echo 'logged in';
            exit;
        } else {
            echo 'false';
            return false;
        }
    }

    //log user out
    public static function logout() {
        //remove username from the session
        unset($_SESSION["username"]);
        $_SESSION['theme'] = 'default';
        //redirect the user to the login page
        // header("Location: " . self::LoginPageURL);
        // exit;
    }

    //check if user is logged in
    public static function protect() {
        if(!isset($_SESSION["username"])) {
            //redirect the user to the login page
            header("Location: " . self::LoginPageURL);
            exit;
        }
    }

    //create a new user
    public static function createUser($signup_username, $signup_password) {
        //hash the password
        $hash = password_hash($signup_password, PASSWORD_DEFAULT);
        //get database settings
        include "settings/db.php";

        try {
            //create database object, as the class is static we need to use
            //the keyword self instead of this
            self::$_db = new DBAccess($host, $dbname, $username, $password);
        } catch (PDOException $e) {
            die("Unable to connect to database, ". $e->message());
        }

        //add user to database
        try {
            //connect to db as the class is static we need to use
            //the keyword self instead of this
            $pdo = self::$_db->connect();

            //set up SQL and bind parameters
            $sql = "INSERT INTO `admin`(`username`, `password`) VALUES(:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":username", $signup_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
            //execute SQL as the class is static we need to use
            //the keyword self instead of this
            $result = self::$_db->executeNonQuery($stmt);
            header("Location: login.php");
        } catch (PDOException $e) {
            throw $e;
        }
        return "New user added";
    }

    public static function updateUser($signup_username, $update_password) {
        //hash the password
        $hash = password_hash($update_password, PASSWORD_DEFAULT);
        //get database settings
        include "settings/db.php";

        try {
            //create database object, as the class is static we need to use
            //the keyword self instead of this
            self::$_db = new DBAccess($host, $dbname, $username, $password);
        } catch (PDOException $e) {
            die("Unable to connect to database, ". $e->message());
        }

        //add user to database
        try {
            //connect to db as the class is static we need to use
            //the keyword self instead of this
            $pdo = self::$_db->connect();
            echo 'this is working';

            //set up SQL and bind parameters
            $sql = "UPDATE `admin` SET `password` = :newPassword WHERE `username` = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":username", $signup_username);
            $stmt->bindParam(":newPassword", $hash);
            //execute SQL as the class is static we need to use
            //the keyword self instead of this
            $result = self::$_db->executeNonQuery($stmt);
            echo $result;
        } catch (PDOException $e) {
            throw $e;
        }
        return "Password Updated";
    }
}
?>
<?php
class DBAccess {
    private $_host;
    private $_username;
    private $_password;
    private $_pdo;
    
    //set up database connection details
    public function __construct($host, $dbname, $username, $password) {
        $this->_host = 'mysql:host=' . $host . ';dbname=' . $dbname . ';';
        $this->_username = $username;
        $this->_password = $password;
    }

    //connect to the database
    public function connect() {
        try {
            $this->_pdo = new PDO($this->_host, $this->_username, $this->_password);
            $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->_pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $this->_pdo;
    }

    //disconnect from database
    public function disconnect() {
        $this->_pdo = "";
    }

    //execute SQL query returning back rows
    public function executeSQL($stmt) {
        try {
            $stmt->execute();
            $rows = $stmt->fetchAll();
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
        return $rows;
    }

    //return a single value
    public function executeSQLReturnOneValue($stmt) {
        try {
            //execute the query
            $stmt->execute();
            $value = $stmt->fetchColumn();
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
        return $value;
    }

    public function executeSQLOneValueWithParams($sql, $id, $bind) {
        try {
            $stmt = $this->_pdo->prepare($sql);
            $stmt->bindParam($bind, $id);
            $stmt->execute();
            $rows = $stmt->fetch();
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

        return $rows;
    }

    public function executeSQLMultiValueWithParams($sql, $id, $bind) {
        try {
            $stmt = $this->_pdo->prepare($sql);
            $stmt->bindParam($bind, $id);
            $stmt->execute();
            $rows = $stmt->fetchAll();
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

        return $rows;
    }

    public function executeNonQuery($stmt, $pkid=false) {
        try {
            $value = $stmt->execute();
            //get the primary key ID generated by the DB
            // if ($pkid === true) {
            //     $value = $this->_pdo->lastInsertId();
            // }
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
        //return the primary key if one was generated otherwise returns true/false
        return $value;
    }

    // public function removeCategory() {

    //     if(isset($_POST['remove-category'])) {
    
    //         $id = $_POST['remove-category-id'];
            
    //         $sql = "DELETE FROM `category` WHERE `category-id` = :id";
            
    //         $stmt = $this->_pdo->prepare($sql);
    //         $stmt->bindParam(':id', $id);
    //         $stmt->execute();
        
    //         echo 'The category was deleted';
    //     }
    // }
}
?>
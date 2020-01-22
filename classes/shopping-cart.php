<?php
require_once "cart-item.php";
require_once "db-access.php";

class ShoppingCart {
    private $_cartItems = [];
    // private $_shoppingOrderId;

    public function count() {
        return count($this->_cartItems);
    }

    public function setShoppingOrderID($id) {
        $this->_shoppingOrderId = (int)$id;
    }

    public function getItems() {
        return $this->_cartItems;
    }

    //add item to cart
    public function addItem($cartItem) {
        $found = $this->inCart($cartItem);
        
        if($found != null) {
            //update quantity
            $this->updateItem($cartItem);
        } else {
            //insert new cart item
            $this->_cartItems[] = $cartItem;
        }
    }

    //update quantity
    public function updateItem($cartItem) {
        $index = $this->itemIndex($cartItem);
        //get current quantity
        $oldQty = $this->_cartItems[$index]->getQuantity();
        $additionalQty = $cartItem->getQuantity();
        //calculate new quantity
        $newQty = $oldQty + $additionalQty;
        //update cart item with new quatity
        $this->_cartItems[$index]->setQuantity($newQty);
    }

    //remove item
    public function removeItem($cartItem) {
        $index = $this->itemIndex($cartItem);

        if($index >= 0) {
            //remove array element
            unset($this->_cartItems[$index]);
            //reorganise values
            $this->_cartItems = array_values($this->_cartItems);
        }
    }

    //calculate total
    public function calculateTotal() {
        $total = 0.0;
        foreach ($this->_cartItems as $item) {
            $total += $item->getQuantity() * $item->getPrice();
        }

        return $total;
    }

    //save cart
    // public function saveCart($firstName, $lastName, $email, $phone, $streetName, $state, $suburb, $postcode, $cardName, $cardNumber, $cardExpiry) {

    //     require_once "db-access.php";
    //     require 'settings/db.php';

    //     $db = new DBAccess($host, $dbname, $username, $password);
    //     $pdo = $db->connect();

    //     //set up SQL statement to insert order
    //     $sql = "INSERT INTO `transaction`(`first-name`, `last-name`, `street-name`, `suburb`, `state`, `postcode`, `phone`, `email`, `card-number`, `card-name`, `card-expiry`) VALUES(:firstName, :lastName, :streetName, :suburb, :state, :postcode, :phone, :email, :cardNumber, :cardName, :cardExpiry)";

    //     $stmt = $pdo->prepare($sql);

    //     $stmt->bindValue(":firstName" , $firstName);
    //     $stmt->bindValue(":lastName" , $lastName);
    //     $stmt->bindValue(":streetName" , $streetName);
    //     $stmt->bindValue(":suburb" , $suburb);
    //     $stmt->bindValue(":state" , $state);
    //     $stmt->bindValue(":postcode" , $postcode);
    //     $stmt->bindValue(":phone" , $phone);
    //     $stmt->bindValue(":email" , $email);
    //     $stmt->bindValue(":cardNumber" , $cardNumber);
    //     $stmt->bindValue(":cardName" , $cardName);
    //     $stmt->bindValue(":cardExpiry" , $cardExpiry);

    //     $result = $db->executeNonQuery($stmt, true);
    //     $result = $pdo->lastInsertId();

    //     //loop through shopping cart, insert items
    //     foreach ($this->_cartItems as $item){
    //         //set up insert statement
    //         echo 'adding';
    //         print_r($item);
    //         $sql = "INSERT INTO `cust_order`(`item-id`, `price`, `quantity`, `transation-id`)
    //         values(:itemId, :price, :quantity, :transactionId)";

    //         //for each item insert a row in OrderItem
    //         $stmt = $pdo->prepare($sql);

    //         $stmt->bindValue(":itemId" , $item[0]->getItemId());
    //         $stmt->bindValue(":price" , $item[0]->getPrice());
    //         $stmt->bindValue(":quantity" , $item[0]->getQuantity());
    //         $stmt->bindValue(":transationId" , $result);
    //         $db->executeNonQuery($stmt);
    //     }

    //     unset($_SESSION['cart']);

    //     return $result;
    // }

    private function inCart($cartItem) {
        $found = null;
        foreach($this->_cartItems as $item) {
            if ($item->getItemId() == $cartItem->getItemId()) {
                $found = $item;
            }
        }

        return $found;
    }

    private function itemIndex($cartItem) {
        $index = -1;
        for($i=0; $i<$this->count(); $i++) {
            if($cartItem->getItemId() == $this->_cartItems[$i]->getItemId()) {
                $index = $i;
            }
        }
        return $index;
    }

    //display array testing purposes
    public function displayArray() {
        print_r($this->_cartItems);
    }
}
?>
<?php 
require_once 'header.php';

?>
<div id='checkout-page' class='container-medium'>

    <div id='checkout-title'>
        <h1>Checkout</h1>
    </div>

<?php


if(isset($_POST['checkout-form'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $streetName = $_POST['streetName'];
    $state = $_POST['state'];
    $suburb = $_POST['suburb'];
    $postcode = $_POST['postcode'];
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNumber'];
    $cardExpiry = $_POST['cardExpiry'];
    
    $sql = "INSERT INTO `transaction`(`first-name`, `last-name`, `street-name`, `suburb`, `state`, `postcode`, `phone`, `email`, `card-number`, `card-name`, `card-expiry`) VALUES(:firstName, :lastName, :streetName, :suburb, :state, :postcode, :phone, :email, :cardNumber, :cardName, :cardExpiry)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":firstName" , $firstName);
    $stmt->bindValue(":lastName" , $lastName);
    $stmt->bindValue(":streetName" , $streetName);
    $stmt->bindValue(":suburb" , $suburb);
    $stmt->bindValue(":state" , $state);
    $stmt->bindValue(":postcode" , $postcode);
    $stmt->bindValue(":phone" , $phone);
    $stmt->bindValue(":email" , $email);
    $stmt->bindValue(":cardNumber" , $cardNumber);
    $stmt->bindValue(":cardName" , $cardName);
    $stmt->bindValue(":cardExpiry" , $cardExpiry);

    //execute SQL query
    $result = $db->executeNonQuery($stmt, true);
    $result = $pdo->lastInsertId();

    $cartObject = $_SESSION['cart'];
                    
    $items = $cartObject->getItems();

    // print_r($items);
    // print('<br><br><br>');
    // print('<br><br><br>');

    //loop through shopping cart, insert items
    foreach ($items as $item){
        //set up insert statement
        // echo 'adding';
        $array = ((array) $item);

        $values = array_values($array);
        // print_r($values);

        $sql = "INSERT INTO `cust_order`(`item-id`, `price`, `quantity`, `transaction-id`)
        values(:itemId, :price, :quantity, :transactionId)";

        //for each item insert a row in OrderItem
        $stmt = $pdo->prepare($sql);

        $itemFinalPrice = $values[2] * $values[1];

        // echo 'this is the final price' . $itemFinalPrice;

        $stmt->bindValue(":itemId" , $values[3]);
        $stmt->bindValue(":price" , $itemFinalPrice);
        $stmt->bindValue(":quantity" , $values[1]);
        $stmt->bindValue(":transactionId" , $result);
        $db->executeNonQuery($stmt);
    }
    // echo $result;

    unset($_SESSION['cart']);

?>

<div>
    <p>Thank you for your purchase!</p>
    <p>Your order number is: Order <?= $result ?></p>
</div>

<?php


} else {

?>



    <div id='checkout-page-inner'>
        
        <form name='checkoutForm' id='checkoutForm'  action="checkout.php" class='flexbox' method='POST'>
      
            <div id='payment-address' class='flexbox'>

                <h3>Billing Address</h3>

                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="firstName">
                
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="lastName">

                <label for="email">Email</label>
                <input type="text" id="email" name="email">

                <label for="phone">Mobile Number</label>
                <input type="text" id="phone" name="phone" placeholder='04********'>
                
                <label for="streetName">Street Name</label>
                <input type="text" id="street-name" name="streetName">

                <label for="suburb">Suburb</label>
                <input type="text" id="suburb" name="suburb">
                
                <label for="state">State</label>
                <input type="text" id="state" name="state">
                
                <label for="postcode">Post Code</label>
                <input type="text" id="postcode" name="postcode">
            </div>

            <div id='payment-card'>

                <h3>Payment</h3>

                <label for="card-name">Name on Card</label>
                <input type="text" id="card-name" name="cardName">

                <label for="card-number">Card number</label>
                <input type="text" id="card-number" name="cardNumber">

                <label for="card-expiry">Card Expriy</label>
                <input type="text" id="card-expiry" name="cardExpiry">

            </div>

            <div id='checkout-error-message'>
                <p id='error-message'></p>
            </div>

            <div id='checkout-btn-div'>
                <input type='hidden' value='checked out' name='checkout-form'>
                <input id='checkout-btn' type="submit" value="Continue to checkout" class="btn">
            </div>
        </form>

    </div>
<?php

}

?>

</div>

<?php
require_once 'footer.php';
?>
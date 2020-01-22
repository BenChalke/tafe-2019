<?php 
require_once 'header.php';
?>

<div id="shopping-cart" class="container-medium">

    <div id='cart-title'>

        <h1>Your Cart</h1>

    </div>

    <div id='shopping-cart-inner' class='flexbox'>

        <div id='shopping-cart-items'>

                <?php
                // print 'display array';
                // $_SESSION['cart']->displayArray();
                // print 'end display array<br>';

                if($_SESSION['cart']) {


                    $cartObject = $_SESSION['cart'];
                    
                    $items = $cartObject->getItems();

                    // print_r($items);

                    foreach($items as $item):
                        $array = ((array) $item);

                        $values = array_values($array);

                        // print_r($values);

                        $itemName = $values[0]; 
                        $itemQuantity = $values[1]; 
                        $itemPrice = $values[2]; 
                        $itemId = $values[3];
                        
                        $sql = "SELECT * FROM `item` WHERE `item-id` = :id";

                        $rows = $db->executeSQLMultiValueWithParams($sql, $itemId, ":id");

                        foreach($rows as $row):
                            ?>

                            <div class='product-info flexbox'>
                                <div id='item-img'>
                                    <img src='images/<?= $row['photo'] ?>' alt='<?= $row['photo'] ?>' class='img-responsive'>
                                </div>

                                <div id='item-name-div'>
                                    <p class='item-name'><?= $row['item-name'] ?></p>
                                </div>

                                <div id='sale-prices'>
                                    <p class='sale-price'>$<?= $row['sale-price'] ?></p>
                                </div>

                                <form id='change-quantity-form' action='' method='post'>
                                    <input name='updated-quantity' type='number' value='<?= $itemQuantity ?>' name='quantity'>
                                    <input type='hidden' value='<?= $row['item-id']; ?>' name='item-id'>
                                    <button id='change-quantity' type='submit' name='change-quantity'>Update</button>
                                </form>
                                <form id='remove-item-form' action='' method='post'>
                                    <input type='hidden' value='<?= $row['item-id']; ?>' name='item-id'>
                                    <button id='remove-item' type='submit' name='remove-item'>Remove</button>
                                </form>
                            </div>

                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <p id='no-items'>You have no ideas in your cart</p>
                <?php } ?>
        </div>
        <div id='shopping-cart-summary'>
            <h3>Summary</h3>

            <p id='cart-total'>Cart Total<br> <span id='total-price'>$<?= $_SESSION['cart']->calculateTotal(); ?></span></p>

            <a href='checkout.php'><p id='checkout-btn'>Proceed to Checkout</p></a>
        </div>
    </div>
</div>

<?php 
require_once 'footer.php';
?>
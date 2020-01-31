<?php

require_once 'settings/includes.php';

if(isset($_POST['add-to-cart'])) {
    

    $product = new Product();

    $product->getProduct($_POST['item-id']);
    
    $item = new CartItem($product->getProductName(), $_POST['quantity'], $product->getPrice(), $product->getProductID());

    if(!isset($_SESSION['cart'])) {
        $cart = new ShoppingCart();
    } else {
        $cart = $_SESSION['cart'];
    }

    $cart->addItem($item);

    // $cart->displayArray();

    $_SESSION['cart'] = $cart;
}

require_once 'header.php';

if(isset($_GET['product'])) {    

    $product = $_GET["product"];

    $sql = "SELECT * FROM `item` WHERE `item-id` = :id";

    $row = $db->executeSQLOneValueWithParams($sql, $product, ":id");
?>
<div id='products-page' class='container-medium'>
    <div id='single-product'>

        <div id='back-button'>
            <a href='/products.php'><p>< Back</p></a>
        </div>

        <div id='single-product-title'>
            <h1><?= $row['item-name'] ?></h1>
        </div>
        
        <div id='single-product-inner' class='flexbox'>

            <div id='product-img'>
                <img src="images/<?= $row['photo'] ?>" alt="<?= $row['item-name'] ?>" class='img-responsive'>
            </div>

            <div id='product-info'>
                <div id='product-info-inner'>
                <?php
                    if($row['price'] === $row['sale-price']) {
                        print("<p class='product-price'>$" . $row['price'] . "</p>");
                    } else {
                        print("<div id='sale-prices'>");
                            print("<p class='strike-through-price'>$" . $row['price'] . "</p>");
                            print("<p class='sale-price'>$" . $row['sale-price'] . "</p>");
                        print("</div>");
                    }
                ?>
                    <p id='product-description'><?= $row['description'] ?></p>

                    <form action='' method='post'>
                    <input type='number' value='1' name='quantity'>
                    <input type='hidden' value='<?= $row['item-id']; ?>' name='item-id'>
                    <button id='add-to-cart' type='submit' name='add-to-cart'>Add to Cart</button>
                    </form>

                    <!-- <a href=' $cart->addItem($item);' id='add-to-cart'><p>Add To Cart</p></a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}  else {
?>
<div id='products-page' class='container-medium'>

    <div id='products-title'>
        <h1>Explore Our Products</h1>
    </div>

    <div id='products-display' class='flexbox'>

        <div id='products-categories'>
            <h2>Categories</h2>

            <ul>
                <?php
                    //Write SQL statement
                    $sql = "select * from category";
                    //Execute the SQL statement and place the result into the rows variable
                    $stmt = $db->connect()->prepare($sql);
                    $rows = $db->executeSQL($stmt);
                    //Write a foreach statement to display results of the SQL statement
                    if(!isset($_GET['category']) && !isset($_GET['search'])) {
                        $allActive = 'activeCategory';
                        $saleActive = '';
                    } else if(isset($_GET['category']) && $_GET['category'] === 'sale') {   
                        $allActive = '';
                        $saleActive = 'activeCategory';
                    } else {
                        $allActive = '';
                        $saleActive = '';
                    }
                    print("<li class='" . $allActive . "'><a href='products.php'><p>All Products</p></a></li>");
                                     
                    print("<li class='" . $saleActive . "'><a href='products.php?category=sale'><p>Sale</p></a></li>");

                    foreach ($rows as $row)
                    {
                        if(isset($_GET['category']) && $_GET['category'] === $row['category-name']) {
                            $activeClass = 'activeCategory';
                        } else {
                            $activeClass = '';
                        }

                        print("<li class='" . $activeClass . "'><a href='?category=" . $row['category-name'] . "'><p>" . $row['category-name'] . "</p></a></li>");
                    }
                ?>
            </ul>
        </div>
        
        <div id='products-display-inner' class="flexbox">
            <?php
                if(isset($_GET['category']) && $_GET['category'] !== 'sale') {
                    $category = $_GET["category"];
                    $sql = "SELECT * from `item`, `category` WHERE `category`.`category-id` = `item`.`category-id` AND `category-name` = :id";
                    $rows = $db->executeSQLMultiValueWithParams($sql, $category, ":id");
                } else if(isset($_GET['category']) && $_GET['category'] === 'sale') {
                    $sql = "SELECT * FROM `item` WHERE `price` <> `sale-price`";
                    $stmt = $db->connect()->prepare($sql);
                    $rows = $db->executeSQL($stmt);
                } else if(isset($_GET['search'])) {
                    $search = $_GET["search"];
                    $sql = "SELECT * from `item` WHERE `item-name` LIKE '%" . $search ."%'";
                    $rows = $db->executeSQLMultiValueWithParams($sql, $search, ":id");
                } else {
                    $sql = "select * from item";
                    $stmt = $db->connect()->prepare($sql);
                    $rows = $db->executeSQL($stmt);
                }

                if(empty($rows)) {
                    print("<p id='no-products'>Sorry, there are no products to show.</p>");
                }

                //Write a foreach statement to display results of the SQL statement
                foreach ($rows as $row) {
                    print("<a href='/products.php?product=" . $row['item-id'] . "'>");
                        print("<div class='product-info'>");
                            print('<img src="images/' . $row['photo'] . '" alt="' . $row['item-name'] . '" class="img-responsive">');
                            if($row['price'] === $row['sale-price']) {
                                print("<p class='price'>$" . $row['price'] . "</p>");
                            } else {
                                print("<div id='sale-prices'>");
                                    print("<p class='strike-through-price'>$" . $row['price'] . "</p>");
                                    print("<p class='sale-price'>$" . $row['sale-price'] . "</p>");
                                print("</div>");
                            }
                            print("<p class='item-name'>" . $row['item-name'] . "</p>");
                        print("</div>");
                    print("</a>");
                }
            ?>
        </div>
    </div>
</div>

<?php
} 

include 'footer.php';
?>
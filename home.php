<div id="home-hero" class="container-medium">
    <div class="home-slider">
        <div class="slide">
            <img src="images/home-hero1.jpg" alt="Soccerball" class="img-responsive">

            <div class="shop-now-overlay">
                <p>View our brand<br>new range of</p>

                <h2>Sports<br>balls</h2>

                <a href="products.php"><p class="shop-now-btn">Shop now</p></a>
            </div>
        </div>
        <div class="slide">
            <img src="images/home-hero2.jpg" alt="Soccerball" class="img-responsive">

            <div class="shop-now-overlay">
                <p>View our brand<br>new range of</p>

                <h2>Under<br>Armour</h2>

                <a href="products.php"><p class="shop-now-btn">Shop now</p></a>
            </div>
        </div>
        <div class="slide">
            <img src="images/home-hero3.jpg" alt="Soccerball" class="img-responsive">

            <div class="shop-now-overlay">
                <p>View our brand<br>new range of</p>

                <h2>Running<br>tops</h2>

                <a href="products.php"><p class="shop-now-btn">Shop now</p></a>
            </div>
        </div>
    </div>

</div>

<div id="featured-products" class="container-medium">

    <div id="featured-products-banner">
        <h3>Featured Products</h3>
    </div>

    <div id="products" class="flexbox">
        <?php

        //Write SQL statement
        $sql = "SELECT * FROM item WHERE featured = 1 LIMIT 5";
        //Execute the SQL statement and place the result into the rows variable
        $stmt = $db->connect()->prepare($sql);
        $rows = $db->executeSQL($stmt);
        //Write a foreach statement to display results of the SQL statement
        ?>

        <?php foreach ($rows as $row): ?>
            <?php
                $price = $row['price'];
                $salePrice = $row['sale-price'];
                $onSale = $salePrice !== $price;
            ?>
            <a href='/products.php?product=<?= $row['item-id'] ?>'>
                <div class='product-info'>
                    <img src="images/<?= $row['photo']?>" alt="<?= $row['item-name']?>" class='img-responsive'>
                    <?php if($onSale): ?>
                        <div id='sale-prices'>
                            <p class='strike-through-price'>$<?= $row['price']?></p>
                            <p class='sale-price'>$<?= $row['sale-price']?></p>
                        </div>
                        <?php else: ?>
                            <p class='price'>$<?= $row['price'] ?></p>
                    <?php endif ?>
                    <p class='item-name'><?= $row['item-name']?></p>
                </div>
            </a>
        <?php endforeach ?>
    </div>
</div>

<div id="partnerships" class="container-medium">

    <div id="partnership-title-banner">
        <h3>Our brands and partnerships</h3>
    </div>

    <div id="partnerships-content" class="flexbox">

        <div id="partnerships-text">
            <p>These are some of our top brands and partnerships. <br><span>The best of the best is here.</span>
            </p>
        </div>

        <div id="partner-logos" class="flexbox">
            <div class="logos">
                <img src="images/logo_nike.png" class="img-responsive" alt="Nike">
            </div>
            <div class="logos">
                <img src="images/logo_adidas.png" class="img-responsive" alt="Adidas">
            </div>
            <div class="logos">
                <img src="images/logo_skins.png" class="img-responsive" alt="Skins">
            </div>
            <div class="logos">
                <img src="images/logo_asics.png" class="img-responsive" alt="Asics">
            </div>
            <div class="logos">
                <img src="images/logo_newbalance.png" class="img-responsive" alt="New Balance">
            </div>
            <div class="logos">
                <img src="images/logo_wilson.png" class="img-responsive" alt="Wilson">
            </div>
        </div>
    </div>

</div>

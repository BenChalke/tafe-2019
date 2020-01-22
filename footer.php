<footer>

    <div id="footer-inner" class="flexbox container-medium">

        <div id="site-navigation" class="footer-item">

            <div id="site-navigation-inner">

                <h3>Site Navigation</h3>

                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About SW</a></li>
                    <li><a href="contact-us.php">Contact Us</a></li>
                    <li><a href="products.php">View Products</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>

            </div>

        </div>

        <div id="product-categories" class="footer-item">

            <h3>Product Categories</h3>

            <ul>
                <?php

                    //Write SQL statement
                    $sql = "select * from category";
                    //Execute the SQL statement and place the result into the rows variable
                    $stmt = $db->connect()->prepare($sql);
                    $rows = $db->executeSQL($stmt);
                    //Write a foreach statement to display results of the SQL statement
                    foreach ($rows as $row)
                    {
                        print("<li><a href='/products.php?category=" . $row['category-name'] . "'>" . $row['category-name'] . "</a></li>");
                    }
                ?>
            </ul>

        </div>

        <div id="footer-social" class="footer-item">

            <div id="footer-social-inner">

                <h3>Contact Sports Warehouse</h3>

                <div id="social-media" class="flexbox">

                    <div id="facebook" class="social-media-item">
                        <a href="#"><p class="social-logo"><span class="fab fa-facebook-f"></span></p></a>
                        <p>Facebook</p>
                    </div>

                    <div id="twitter" class="social-media-item">
                        <a href="#"><p class="social-logo"><span class="fab fa-twitter"></span></p></a>
                        <p>Twitter</p>
                    </div>

                    <div id="other" class="social-media-item">
                        <a href="#"><p class="social-logo"><span class="fas fa-paper-plane"></span></p></a>
                        <p>Other</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="copyright">
        <p>&copy; Copyright 2019 Sports Warehouse. All rights reserved. Website made by BennyChalke.</p>
    </div>

</footer>

</body>
</html>
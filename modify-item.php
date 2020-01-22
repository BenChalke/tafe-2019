<?php

require_once('settings/init.php');

Authentication::protect();

if(isset($_POST['remove-item'])):
    
    $id = $_POST['remove-item-id'];
    
    $sql = "DELETE FROM `item` WHERE `item-id` = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $row = $db->executeNonQuery($stmt);

    echo 'The item was deleted';
endif;

require_once 'admin-header.php';

$sql = "SELECT * FROM `item`";

$stmt = $pdo->prepare($sql);
$rows = $db->executeSQL($stmt);
?>

<div id='item-info' class='container-medium'>

    <div id='modify-item-title'>
        <h1>Modify Items</h1>
    </div>

    <a href='admin.php'>
        <p id='back-btn'>< Back</p>
    </a>

    <div id='item-info-inner' class='flexbox'>

    <?php
    foreach($rows as $row):
    ?>

        <div class='product-info flexbox'>
            <div id='item-img'>
                <img src="images/<?= $row['photo'] ?>" alt="<?= $row['photo'] ?>" class='img-responsive'>
            </div>

            <div id='item-name-div'>
                <p class='item-name'><?= $row['item-name'] ?></p>
            </div>

            <div id='sale-prices'>
                <p class='sale-price'>$<?= $row['sale-price'] ?></p>
            </div>

            <form class='update-item-form' action='update-item.php' method='POST'>
                <input type='hidden' value='<?= $row['item-id']; ?>' name='item-id'>
                <button id='update-item' type='submit' name='update-item'>Update</button>
            </form>
            <form class='remove-item-form' action='' method='POST'>
                <input type='hidden' value='<?= $row['item-id']; ?>' name='remove-item-id'>
                <button id='remove-item' type='submit' name='remove-item'>Remove</button>
            </form>

        </div>

    <?php endforeach; ?>
    
    </div>
</div>

<?php

require_once 'footer.php';
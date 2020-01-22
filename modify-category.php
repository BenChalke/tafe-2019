<?php

require_once('settings/init.php');

Authentication::protect();

if(isset($_POST['remove-category'])):
    
    $id = $_POST['remove-category-id'];
    
    $sql = "DELETE FROM `category` WHERE `category-id` = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $row = $db->executeNonQuery($stmt);

    echo 'The category was deleted';
endif;

require_once 'admin-header.php';

$sql = "SELECT * FROM `category`";

$stmt = $pdo->prepare($sql);
$rows = $db->executeSQL($stmt);

foreach($rows as $row):
?>

<div class='category-info flexbox'>
    <div id='category-name'>
        <p><?= $row['category-name']; ?></p>
    </div>

    <form class='update-category-form' action='update-category.php' method='POST'>
        <input type='hidden' value='<?= $row['category-id']; ?>' name='category-id'>
        <button id='update-category' type='submit' name='update-category'>Update</button>
    </form>
    <form class='remove-category-form' action='' method='POST'>
        <input type='hidden' value='<?= $row['category-id']; ?>' name='remove-category-id'>
        <button id='remove-category' type='submit' name='remove-category'>Remove</button>
    </form>
</div>

<?php endforeach;

require_once 'footer.php';
<?php

require_once('settings/init.php');

Authentication::protect();

if(isset($_POST['update-category-name'])):
    
    $id = $_POST['category-id'];
    $updatedName = $_POST['updated-category-name'];
    
    $sql = "UPDATE `category` SET `category-name` = :updatedName WHERE `category-id` = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':updatedName', $updatedName);
    $row = $db->executeNonQuery($stmt);
    
    header('Location: modify-category.php');
    exit;
endif;

require_once 'admin-header.php';

if(isset($_POST['update-category'])):

    print_r($_POST);

    $id = $_POST['category-id'];

    $sql = "SELECT * FROM `category` WHERE `category-id` = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $row = $db->executeSQL($stmt);

    print_r($row);
    ?>

    <div class='category-info flexbox'>

        <form id='update-category-name-form' action='' method='POST'>
            <input type='text' value='<?= $row[0]['category-name']; ?>' name='updated-category-name'>
            <input type='hidden' value='<?= $row[0]['category-id']; ?>' name='category-id'>
            <button id='update-category-name' type='submit' name='update-category-name'>Update</button>
        </form>
    </div>

<?php

endif;


require_once 'footer.php';
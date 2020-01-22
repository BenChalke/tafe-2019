<?php

require_once('settings/init.php');

Authentication::protect();

if(isset($_POST['update-item-form'])):
    
    $id = $_POST['item-id'];
    $updatedName = $_POST['updated-item-name'];
    $updatedPrice = $_POST['updated-price'];
    $updatedSalePrice = $_POST['updated-sale-price'];
    $updatedDescription = $_POST['updated-description'];
    $updatedFeatured = $_POST['updated-featured'];
    $updatedQuantity = $_POST['updated-quantity'];
    $updatedCategory = $_POST['updated-category'];
    
    $sql = "UPDATE `item` SET `item-name` = :updatedName, `price` = :updatedPrice, `sale-price` = :updatedSalePrice, `description` = :updatedDescription, `featured` = :updatedFeatured, `quantity` = :updatedQuantity, `category-id` = :updatedCategory WHERE `item-id` = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':updatedName', $updatedName);
    $stmt->bindParam(':updatedPrice', $updatedPrice);
    $stmt->bindParam(':updatedSalePrice', $updatedSalePrice);
    $stmt->bindParam(':updatedDescription', $updatedDescription);
    $stmt->bindParam(':updatedFeatured', $updatedFeatured);
    $stmt->bindParam(':updatedQuantity', $updatedQuantity);
    $stmt->bindParam(':updatedCategory', $updatedCategory);
    $row = $db->executeNonQuery($stmt);

    if(isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["name"] !== '') {

        $title = "Upload";
        $pageHeading = "Uploading a file";
        $message = "";
        $error = false;

        echo 'this is getting run';

        $id = $_POST['item-id'];

        //specify directory where image will be saved
        $targetDirectory = "images/";

        print_r($_FILES);

        //get the filename
        $fileName = basename($_FILES["fileToUpload"]["name"]);

        echo $fileName;

        //set the entire path
        $targetFile = $targetDirectory . $fileName;

        echo $targetFile;

        //only allow image files
        $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $error = true;
        }

        //check the file size php.ini has an upload_max_filesize, default set to 2M
        //if the file size exceeds the limit the error code is 1
        if ($_FILES["fileToUpload"]["error"] == 1) {
            $message = "Sorry, your file is too large. Max of 2M is allowed.";
            $error = true;
        }

        if($error == false) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                $message = "The file $fileName has been uploaded.";
            } else {
                $message = "Sorry, there was an error uploading your file. Error Code:" .
                $_FILES["fileToUpload"]["error"];
            }
        }
        
        $sql = "UPDATE `item` SET `photo` = :updatedPhoto WHERE `item-id` = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':updatedPhoto', $fileName);
        $row = $db->executeNonQuery($stmt);
    }

    header('Location: modify-item.php');
    exit;

endif;


// if(!isset($_POST['update-item'])):

//     header('Location: modify-item.php');
//     exit;

// endif;


require_once 'admin-header.php';

if(isset($_POST['update-item'])):

    print_r($_POST);

    $id = $_POST['item-id'];

    $sql = "SELECT * FROM `item` WHERE `item-id` = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $row = $db->executeSQL($stmt);

    // print_r($row);
    ?>

    <div class='item-info flexbox'>

        <form id='update-item-name-form' action='' method='POST' enctype="multipart/form-data">
        
            <label for="updated-item-name">Item Name:</label>
            <input type='text' name='updated-item-name' id='updated-item-name' value="<?= $row[0]['item-name'] ?>"></input>

            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload">

            <label for="updated-price">Price:</label>
            <input type='text' name='updated-price' id='updated-price' value="<?= $row[0]['price'] ?>"></input>

            <label for="updated-sale-price">Sale Price:</label>
            <input type='text' name='updated-sale-price' id='updated-sale-price' value="<?= $row[0]['sale-price'] ?>"></input>

            <label for="updated-description">Description:</label>
            <input type='text' name='updated-description' id='updated-description' value="<?= $row[0]['description'] ?>"></input>

            <label for="updated-featured">Featured</label>
            <input type='text' name='updated-featured' id='updated-featured' value="<?= $row[0]['featured'] ?>"></input>

            <label for="updated-quantity">Quantity:</label>
            <input type='text' name='updated-quantity' id='updated-quantity' value="<?= $row[0]['quantity'] ?>"></input>

            <label for="updated-category">Category:</label>
            <select name="updated-category" id="updated-category" selected='2'>
            <?php 
            //get categories to poulate drop down list
            $sql = "select `category-id`, `category-name` from category";
            $stmt = $pdo->prepare($sql);
            //execute SQL query
            $categoryRows = $db->executeSQL($stmt);

            foreach ($categoryRows as $catRow):
                $categoryId = $catRow["category-id"];
                $categoryName = $catRow["category-name"];
                
                if($categoryId === $row[0]['category-id']){
                ?>
                    <option selected='selected' value="<?= $categoryId ?>"><?= $categoryName ?></option>
                <?php
                } else {
                ?>
                     <option value="<?= $categoryId ?>"><?= $categoryName ?></option>
                <?php
                }
            ?>
           
            <?php endforeach; ?>
            </select>

            <input type='hidden' value='<?= $row[0]['item-id'] ?>' name='item-id'>
            <button id='update-item-form' type='submit' name='update-item-form'>Update</button>
        </form>
    </div>

<?php

endif;


require_once 'footer.php';
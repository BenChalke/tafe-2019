<?php
require_once 'admin-header.php';

Authentication::protect();
$title = "Upload";
$pageHeading = "Uploading a file";
$message = "";
$error = false;
if(isset($_POST['add-item-form'])) {

    echo 'item added';

    print_r($_POST);

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

    $sql = "INSERT INTO `item`(`item-name`, `photo`, `price`, `sale-price`, `description`, `featured`, `quantity`, `category-id`) VALUES(:itemName, :photo, :price, :salePrice, :itemDescription, :featured, :quantity, :categoryId)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":itemName" , $_POST["item-name"]);
    $stmt->bindValue(":photo" , $fileName);
    $stmt->bindValue(":price" , $_POST["price"]);
    $stmt->bindValue(":salePrice" , $_POST["sale-price"]);
    $stmt->bindValue(":itemDescription" , $_POST["description"]);
    $stmt->bindValue(":featured" , $_POST["featured"]);
    $stmt->bindValue(":quantity" , $_POST["quantity"]);
    $stmt->bindValue(":categoryId" , $_POST["category"]);

    $result = $db->executeNonQuery($stmt, false);
}

?>
<div id='add-item-page' class='container-medium'>

    <div id='add-item-form'>

    <a href='admin.php'><p id='back-btn'>< Back</p></a>
        <div id='add-item-title'>
            <h1>Add new item</h1>
        </div>

        <form name='additemForm' id='additemForm' action="add-item.php" method='POST' enctype="multipart/form-data">
            <div id='add-item-input'>
                <input type='text' name='item-name' id='item-name' placeholder='Item Name'>

                <!-- <input type='text' name='photo' id='photo' placeholder='Photo'> -->

                <label for="fileToUpload">Select image to upload:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">

                <input type='text' name='price' id='price' placeholder='Price'>

                <input type='text' name='sale-price' id='sale-price' placeholder='Sale Price'>

                <input type='text' name='description' id='description' placeholder='Description'>

                <input type='text' name='featured' id='featured' placeholder='Featured (1 = yes, 0 = no)'>

                <input type='text' name='quantity' id='quantity' placeholder='Quantity'>

                <p>
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                    <?php 
                    //get categories to poulate drop down list
                    $sql = "select `category-id`, `category-name` from category";
                    $stmt = $pdo->prepare($sql);
                    //execute SQL query
                    $categoryRows = $db->executeSQL($stmt);

                    foreach ($categoryRows as $row):
                        $categoryId = $row["category-id"];
                        $categoryName = $row["category-name"];
                    ?>
                    <option value="<?= $categoryId ?>"><?= $categoryName ?></option>
                    <?php endforeach; ?>
                    </select>
                </p>
            </div>
            <div id='add-item-submit'>
                <input type='hidden' value='' name='add-item-form'>
                <input id='add-item-btn' type="submit" value="Add item">
            </div>
        </form>

        <p><?php 
            if($error === true) {
                echo '<p>' . $message . '</p>';
            }
        ?></p>
    </div>
</div>


<?php

require_once 'footer.php';

?>
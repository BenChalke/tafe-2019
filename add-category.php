<?php
require_once 'admin-header.php';

Authentication::protect();

if(isset($_POST['add-category-form'])) {

    $newCategory = $_POST["add-category"];
    $sql = "INSERT INTO category(`category-name`) VALUES(:category)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":category" , $newCategory);
    $result = $stmt->execute();

    echo 'submitting';
    print_r($result);
}

?>
<div id='add-category-page' class='container-medium'>

    <div id='add-category-form'>

    <a href='admin.php'>
        <p id='back-btn'>< Back</p>
    </a>

        <div id='add-category-title'>
            <h1>Add new category</h1>
        </div>

        <form name='addCategoryForm' id='addCategoryForm' action="add-category.php" method='POST'>
            <div id='add-category-input'>
                <input type='text' name='add-category' id='add-category' placeholder='New Category'>
            </div>
            <div id='add-category-submit'>
                <input type='hidden' value='' name='add-category-form'>
                <input id='add-category-btn' type="submit" value="Add Category">
            </div>
        </form>
    </div>
</div>


<?php

require_once 'footer.php';

?>
<?php
require_once 'admin-header.php';

Authentication::protect();

?>

<div id='admin-page' class='container-medium'>

    <div id="admin-page-title">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>

    <div id='admin-links'>

        <a href='add-category.php'><p>Add category</p></a>
        <a href='modify-category.php'><p>Modify category</p></a>
        <a href='add-item.php'><p>Add item</p></a>
        <a href='modify-item.php'><p>Modify item</p></a>
        <a href='change-password.php'><p>Change Password</p></a>

    </div>

    <div id='choose-theme-div'>
        <p>Choose your theme:</p>
        <form name='themeForm' id='themeForm' action="admin.php" method='POST'>
            <select name="theme" id="theme">
                <option value='default'>Default</option>
                <option value='black'>Black</option>
                <option value='red'>Red</option>
                <option value='green'>Green</option>
                <option value='pink'>Pink</option>
            </select>

            <input type='hidden' value='' name='theme-form'>
            <input id='theme-btn' type="submit" value="Select Theme">
        </form>
    </div>
</div>

<?php
require_once 'footer.php';
?>
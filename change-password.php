<?php
require_once 'admin-header.php';

Authentication::protect();

if(isset($_POST['change-password-form'])) {

    $username = $_SESSION['username'];
    $password = $_POST['password'];

    $return = Authentication::updateUser($username, $password);
}

?>
<div id='admin-login-page' class='container-medium'>

    <div id='admin-login-form'>
        <div id='admin-login-title'>
            <h1>Admin Change Password</h1>
        </div>

        <form name='changePasswordForm' id='changePasswordForm' action="" method='POST'>
            <div id='password-input'>
                <input type='password' name='password' id='password' placeholder='New Password'>
            </div>
            <div id='admin-change-password-submit'>
                <input type='hidden' value='' name='change-password-form'>
                <input id='change-password-btn' type="submit" value="Change Password">
            </div>
        </form>
    </div>
</div>


<?php

require_once 'footer.php';

?>
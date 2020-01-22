<?php
require_once 'admin-header.php';

if(isset($_POST['signup-form'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $return = Authentication::createUser($username, $password);
}

?>
<div id='admin-login-page' class='container-medium'>

    <div id='admin-login-form'>
        <div id='admin-login-title'>
            <h1>Admin Signup</h1>
        </div>

        <form name='signupForm' id='signupForm' action="signup.php" method='POST'>
            <div id='username-input'>
                <input type='text' name='username' id='username' placeholder='Username'>
            </div>
            <div id='password-input'>
                <input type='password' name='password' id='password' placeholder='Password'>
            </div>
            <div id='admin-signup-submit'>
                <input type='hidden' value='' name='signup-form'>
                <input id='signup-btn' type="submit" value="Sign Up">
            </div>
        </form>
        <a href='login.php'><p id='signup-link'>Have an account? Click here</p></a>
        <!-- <a href='change-password.php'><p id='signup-link'>Forgot Password? Click here</p></a> -->
    </div>
</div>


<?php

require_once 'footer.php';

?>
<?php
require_once 'admin-header.php';

if(isset($_POST['login-form'])) {

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        $login_username = $_POST['username'];
        $login_password = $_POST['password'];

        $return = Authentication::login($login_username, $login_password);
    } else {
        $return = Authentication::login('', '');
    }
}

?>
<div id='admin-login-page' class='container-medium'>

    <div id='admin-login-form'>
        <div id='admin-login-title'>
            <h1>Admin Login</h1>
        </div>

        <form name='loginForm' id='loginForm' action="login.php" method='POST'>
            <div id='username-input'>
                <input type='text' name='username' id='username' placeholder='Username'>
            </div>
            <div id='password-input'>
                <input type='password' name='password' id='password' placeholder='Password'>
            </div>
            <?php
                if (isset($return) && $return === false) {
                    echo "<div class='error-message'><p>Your username or password was incorrect. Please try again.</p></div>";
                }
            ?>
            <div id='admin-login-submit'>
                <input type='hidden' value='' name='login-form'>
                <input id='login-btn' type="submit" value="Login">
            </div>
        </form>
        <a href='signup.php'><p id='signup-link'>Don't have an account? Click here</p></a>
        <!-- <a href='change-password.php'><p id='signup-link'>Forgot Password? Click here</p></a> -->
    </div>
</div>


<?php

require_once 'footer.php';

?>
<?php

$firstName = "";
$firstNameError = "";
$lastName = "";
$lastNameError = "";
$email = "";
$emailError = "";
$phone = "";
$question = "";

if (isset($_POST["submit"])) {
    $to = "benchalke@hotmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $subject = "Form submission";
    $firstName = clean($_POST["first-name"]);
    $lastName = clean($_POST["last-name"]);
    $email = clean($_POST["email"]);
    $phone = clean($_POST["phone"]);
    $question = clean($_POST["question"]);
    $message = $firstName . " " . $lastName . " wanted to ask the following question:" . "\n\n" . $_POST['question'];

    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);

    header("Location: thank-you.php?var=$firstName");

    echo "Mail Sent. Thank you " . $firstName . ", we will contact you shortly.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($firstName)) {
        $firstNameError = "This field is required";
    }

    if (empty($lastName)) {
        $lastNameError = "This field is required";
    }

    if (empty($email)) {
        $emailError = "This field is required";
    }

    if (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $email)) {
        $emailError = "Your email must be valid";
    }

} else {
    $firstName = "";
    $firstNameError = "";
    $lastName = "";
    $lastNameError = "";
    $email = "";
    $emailError = "";
    $phone = "";
    $question = "";
}

function clean($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

require_once 'header.php';
?>

<div id="contact-page">

    <div id="contact-page-title">
        <h1>Contact Us</h1>
    </div>

    <div id="contact-page-content" class="flexbox container-medium">

        <div id="contact-page-contact-form" class="contact-page-item">
            <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>



                <label for="firstName">First Name:</label>
                <input id="firstName" type="text" name="first-name" placeholder="First Name" required>
                <span class="error"><?= $firstNameError ?></span>

                <label for="lastName">Last Name:</label>
                <input id="lastName" type="text" name="last-name" placeholder="Last Name" required>
                <span class="error"><?= $lastNameError ?></span>

                <label for="email">Email:</label>
                <input id="email" type="email" name="email" placeholder="Email">
                <span class="error"><?= $emailError ?></span>

                <label for="phone">Contact Phone:</label>
                <input id="phone" type="text" name="phone" placeholder="Phone">

                <label for="question">Question:</label>
                <textarea id="question" name="question" rows="10" cols="30" placeholder="Enquiry"></textarea>

                <input type="submit" name="submit" value="Submit">
            </form>
        </div>

        <div id="contact-page-contact-info" class="contact-page-item">
            <div id="contact-info" class="flexbox">
                <div class="contact-info-item">
                    <p><span class="fas fa-phone"></span></p>

                    <p id="phone-number">Phone number</p>
                </div>
                <div class="contact-info-item">
                    <p><span class="fas fa-envelope"></span></p>

                    <p>Email</p>
                </div>
            </div>

            <h2>Follow Us on Social Media</h2>
            <p><a href="#"><span id="contact-facebook" class='fab fa-facebook'></span></a></p>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
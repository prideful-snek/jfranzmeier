<?php
if (isset($_POST['email'])) {

    // REPLACE THIS 2 LINES AS YOU DESIRE
    $email_to = "jfranzmeier2@gmail.com";
    $email_subject = "You've got a new message";

    function problem($error)
    {
        echo "It looks like there is a problem with your form data: <br><br>";
        echo $error . "<br><br>";
        echo "Please fix to proceed.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['fullName']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])
    ) {
        problem('It looks like there is some problem with your form data.');
    }

    $name = $_POST['fullName']; // required
    $email = $_POST['email']; // required
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Email address is not valid.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Name is not valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Message should not be less than 2 characters<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details following:\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- Replace this as your success message -->

    Thanks for contacting me, I will get back to you as soon as possible.

<?php
}
?>
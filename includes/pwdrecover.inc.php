<?php
require_once('inc.php');

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../pwdrecover.php?error=param-missing');
            exit;
        }// end if statemente
    }// end foreach loop
}// end checkParams()

// 1. check if all fields have been filled and submit button has been pressed
checkParams(array('email'));

if (isset($_POST['pwd-submit'])) {
    $selector = substr(md5(rand()), 0, 8);
    $token = substr(md5(rand()), 0, 32);

    $url = "http://cs139.dcs.warwick.ac.uk/~u1915472/cs139/cs139_coursework/pwdreset.php?selector=" . $selector . "&token=" . $token;
    $expires = date("U") + 1800;

    $email = h($_POST['email']);

    if ($db->getUserId($email) === null) {
        header('Location: ../index.php?error=usernotexist');
        exit;
    }
    $db->saveResetToken($email, $selector, $token, $expires);

    $to = $email;
    $subject = 'Splitify Reset Password';
    $message = '<h1>Splitify: Reset Password</h1>
       <p>Please click the link down below to reset you password: </p>
       <p>' . $url . '</p>
       <p>The link will be expired in few minutes.</p><br><br>
       <p>Splitify</p>';

    $headers = 'From: noreply@splitify.com' . "\r\n" .
        'Reply-To: reply@splitify.com' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    header("Location: ../index.php?email=sent");
} else {
    header('Location: ../index.php?error=nosubmit');
}
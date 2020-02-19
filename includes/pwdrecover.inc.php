<?php
require_once('inc.php');

if (isset($_POST['pwd-submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost:63342/cs139_coursework/pwd.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;

//    echo $url;
//    echo $selector;

    $email = h($_POST['email']);

    if ($db->getUserId($email) === null) {
        header('Location: ../index.php?error=usernotexist');
        exit;
    }
    $db->saveResetToken($email, $selector, $token, $expires);

    $to = $email;
    $subject = 'Splitify Reset Password';
    $message = $url;
//        '
//        <h1>Splitify: Reset Password</h1>
//        <p>Please click the link down below to reset you password: </p>
//        <p>' . $url . '</p>
//        <p>The link will be expired in few minutes.</p><br><br>
//        <p>Splitify</p>';

    $headers = 'From: noreply@splitify.com' . "\r\n" .
        'Reply-To: reply@splitify.com' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    header("Location: ../index.php?email=sent");
} else {
    header('Location: ../index.php?error=nosubmit');
}

<?php
require_once('inc.php');

if (isset($_POST['pwd-submit'])){
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost:63342/cs139_coursework/pwd.php?selector=".$selector."&validator=".bin2hex($token);
    $expires = date("U") + 1800;

    echo $url;
    echo $selector;

    $email = h($_POST['email']);

    if ($db->getUserId($email) === null){
        header('Location: ../index.php?error=usernotexist');
        exit;
    }
    $db->saveResetToken($email, $selector, $token, $expires);
    $db->sendPwdRecoverEmail($email, $url);
    header("Location: ../index.php?email=sent");
}
else {
    header('Location: ../index.php?error=nosubmit');
}
